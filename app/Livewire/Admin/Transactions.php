<?php

namespace App\Livewire\Admin;

use App\Exports\TransactionsExport;
use App\Models\Order;
use App\Models\PosTerminal;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Transactions extends Component
{
    use WithPagination;

    public $search = '';

    public $filterStatus = 'all';

    public $filterPaymentStatus = 'all';

    public $filterTerminal = 'all';

    public $filterDateFrom = '';

    public $filterDateTo = '';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    public $showOrderModal = false;

    public $selectedOrder = null;

    public function mount(): void
    {
        if (! auth()->user()->hasRole(['super-admin', 'admin', 'manager', 'cashier'])) {
            abort(403, 'Access denied');
        }

        $this->filterDateFrom = now()->startOfDay()->format('Y-m-d');
        $this->filterDateTo = now()->endOfDay()->format('Y-m-d');
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterPaymentStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterTerminal(): void
    {
        $this->resetPage();
    }

    public function updatedFilterDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedFilterDateTo(): void
    {
        $this->resetPage();
    }

    public function sortBy($field): void
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'desc';
        }
        $this->resetPage();
    }

    public function viewOrder(int $orderId): void
    {
        $this->selectedOrder = Order::with(['items.product', 'payments', 'terminal', 'cashier'])
            ->findOrFail($orderId);
        $this->showOrderModal = true;
    }

    public function closeOrderModal(): void
    {
        $this->showOrderModal = false;
        $this->selectedOrder = null;
    }

    public function refundOrder(int $orderId): void
    {
        $order = Order::findOrFail($orderId);

        if ($order->payment_status !== 'paid') {
            session()->flash('error', 'Only paid orders can be refunded.');

            return;
        }

        $order->update([
            'status' => 'refunded',
            'payment_status' => 'refunded',
            'refunded_at' => now(),
        ]);

        // Update payments
        $order->payments()->update(['status' => 'refunded']);

        // Restore inventory
        foreach ($order->items as $item) {
            $item->product->increment('inventory_quantity', $item->quantity);
        }

        session()->flash('message', 'Order refunded successfully.');
        $this->closeOrderModal();
    }

    public function resetFilters(): void
    {
        $this->search = '';
        $this->filterStatus = 'all';
        $this->filterPaymentStatus = 'all';
        $this->filterTerminal = 'all';
        $this->filterDateFrom = now()->startOfDay()->format('Y-m-d');
        $this->filterDateTo = now()->endOfDay()->format('Y-m-d');
        $this->resetPage();
    }

    public function exportExcel(): mixed
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'payment_status' => $this->filterPaymentStatus,
            'terminal' => $this->filterTerminal,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo,
        ];

        $filename = 'transactions_'.now()->format('Y-m-d_H-i-s').'.xlsx';

        return Excel::download(new TransactionsExport($filters), $filename);
    }

    public function exportCsv(): mixed
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'payment_status' => $this->filterPaymentStatus,
            'terminal' => $this->filterTerminal,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo,
        ];

        $filename = 'transactions_'.now()->format('Y-m-d_H-i-s').'.csv';

        return Excel::download(new TransactionsExport($filters), $filename, \Maatwebsite\Excel\Excel::CSV);
    }

    public function exportPdf(): mixed
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->filterStatus,
            'payment_status' => $this->filterPaymentStatus,
            'terminal' => $this->filterTerminal,
            'date_from' => $this->filterDateFrom,
            'date_to' => $this->filterDateTo,
        ];

        $filename = 'transactions_'.now()->format('Y-m-d_H-i-s').'.pdf';

        return Excel::download(new TransactionsExport($filters), $filename, \Maatwebsite\Excel\Excel::DOMPDF);
    }

    public function getTransactionsProperty()
    {
        return Order::where('type', 'pos')
            ->when($this->search, function ($q) {
                $q->where(function ($query) {
                    $query->where('order_number', 'like', "%{$this->search}%")
                        ->orWhere('customer_name', 'like', "%{$this->search}%")
                        ->orWhere('customer_email', 'like', "%{$this->search}%")
                        ->orWhere('receipt_number', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterStatus !== 'all', function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->when($this->filterPaymentStatus !== 'all', function ($q) {
                $q->where('payment_status', $this->filterPaymentStatus);
            })
            ->when($this->filterTerminal !== 'all', function ($q) {
                $q->where('terminal_id', $this->filterTerminal);
            })
            ->when($this->filterDateFrom, function ($q) {
                $q->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateTo, function ($q) {
                $q->whereDate('created_at', '<=', $this->filterDateTo);
            })
            ->with(['cashier', 'terminal', 'payments'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(15);
    }

    public function getTerminalsProperty()
    {
        return PosTerminal::where('is_active', true)->get();
    }

    public function getTodayStatsProperty()
    {
        $today = now()->startOfDay();
        $posOrders = Order::where('type', 'pos')
            ->whereDate('created_at', $today)
            ->where('status', '!=', 'cancelled');

        return [
            'total_transactions' => $posOrders->count(),
            'total_sales' => $posOrders->sum('total_amount'),
            'total_cash' => $posOrders->whereHas('payments', function ($q) {
                $q->where('payment_method', 'cash');
            })->with('payments')->get()->sum(function ($order) {
                return $order->payments->where('payment_method', 'cash')->sum('amount');
            }),
            'total_card' => $posOrders->whereHas('payments', function ($q) {
                $q->where('payment_method', 'card');
            })->with('payments')->get()->sum(function ($order) {
                return $order->payments->where('payment_method', 'card')->sum('amount');
            }),
            'avg_transaction' => $posOrders->count() > 0 ? $posOrders->avg('total_amount') : 0,
        ];
    }

    public function render()
    {
        return view('livewire.admin.transactions');
    }
}
