<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection(): Collection
    {
        $query = Order::where('type', 'pos')
            ->with(['cashier', 'terminal', 'payments', 'items.product']);

        // Apply filters
        if (! empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('receipt_number', 'like', "%{$search}%");
            });
        }

        if (! empty($this->filters['status']) && $this->filters['status'] !== 'all') {
            $query->where('status', $this->filters['status']);
        }

        if (! empty($this->filters['payment_status']) && $this->filters['payment_status'] !== 'all') {
            $query->where('payment_status', $this->filters['payment_status']);
        }

        if (! empty($this->filters['terminal']) && $this->filters['terminal'] !== 'all') {
            $query->where('terminal_id', $this->filters['terminal']);
        }

        if (! empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (! empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Receipt Number',
            'Date & Time',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Terminal',
            'Cashier',
            'Status',
            'Payment Status',
            'Items Count',
            'Subtotal',
            'Tax Amount',
            'Discount Amount',
            'Total Amount',
            'Payment Methods',
            'Payment Details',
            'Notes',
            'Refunded At',
        ];
    }

    /**
     * @var Order
     */
    public function map($transaction): array
    {
        // Get payment method details
        $paymentMethods = $transaction->payments->pluck('payment_method')->unique()->toArray();
        $paymentDetails = $transaction->payments->map(function ($payment) {
            return $payment->payment_method.': $'.number_format($payment->amount, 2);
        })->join(', ');

        return [
            $transaction->order_number,
            $transaction->receipt_number,
            $transaction->created_at->format('Y-m-d H:i:s'),
            $transaction->customer_name,
            $transaction->customer_email,
            $transaction->customer_phone,
            $transaction->terminal ? $transaction->terminal->name : 'N/A',
            $transaction->cashier ? $transaction->cashier->name : 'N/A',
            ucfirst($transaction->status),
            ucfirst(str_replace('_', ' ', $transaction->payment_status)),
            $transaction->items->count(),
            '$'.number_format($transaction->subtotal, 2),
            '$'.number_format($transaction->tax_amount, 2),
            '$'.number_format($transaction->discount_amount, 2),
            '$'.number_format($transaction->total_amount, 2),
            implode(', ', $paymentMethods),
            $paymentDetails,
            $transaction->notes,
            $transaction->refunded_at ? $transaction->refunded_at->format('Y-m-d H:i:s') : 'N/A',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Style the first row as bold
            1 => ['font' => ['bold' => true]],
        ];
    }
}
