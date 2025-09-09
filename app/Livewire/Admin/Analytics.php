<?php

namespace App\Livewire\Admin;

use App\Exports\AnalyticsExport;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PosTerminal;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Analytics extends Component
{
    public $dateRange = '7days';

    public $selectedTerminal = 'all';

    public $comparisonPeriod = 'previous';

    public function mount(): void
    {
        if (! auth()->user()->hasRole(['super-admin', 'admin'])) {
            abort(403, 'Access denied');
        }
    }

    public function updatedDateRange(): void
    {
        $this->resetExcept(['dateRange', 'selectedTerminal', 'comparisonPeriod']);
    }

    public function updatedSelectedTerminal(): void
    {
        $this->resetExcept(['dateRange', 'selectedTerminal', 'comparisonPeriod']);
    }

    public function updatedComparisonPeriod(): void
    {
        $this->resetExcept(['dateRange', 'selectedTerminal', 'comparisonPeriod']);
    }

    public function getDateRangeProperty(): array
    {
        $endDate = now();

        switch ($this->dateRange) {
            case 'today':
                $startDate = now()->startOfDay();
                break;
            case '7days':
                $startDate = now()->subDays(7)->startOfDay();
                break;
            case '30days':
                $startDate = now()->subDays(30)->startOfDay();
                break;
            case '90days':
                $startDate = now()->subDays(90)->startOfDay();
                break;
            case '1year':
                $startDate = now()->subYear()->startOfDay();
                break;
            default:
                $startDate = now()->subDays(7)->startOfDay();
        }

        return ['start' => $startDate, 'end' => $endDate];
    }

    public function getComparisonDateRangeProperty(): array
    {
        $currentRange = $this->getDateRangeProperty();
        $diff = $currentRange['start']->diffInDays($currentRange['end']);

        $comparisonEnd = $currentRange['start']->copy()->subSecond();
        $comparisonStart = $comparisonEnd->copy()->subDays($diff)->startOfDay();

        return ['start' => $comparisonStart, 'end' => $comparisonEnd];
    }

    public function getPosStatsProperty(): array
    {
        $dateRange = $this->getDateRangeProperty();
        $comparisonRange = $this->getComparisonDateRangeProperty();

        $baseQuery = Order::where('type', 'pos')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->where('status', '!=', 'cancelled');

        $comparisonQuery = Order::where('type', 'pos')
            ->whereBetween('created_at', [$comparisonRange['start'], $comparisonRange['end']])
            ->where('status', '!=', 'cancelled');

        if ($this->selectedTerminal !== 'all') {
            $baseQuery->where('terminal_id', $this->selectedTerminal);
            $comparisonQuery->where('terminal_id', $this->selectedTerminal);
        }

        $currentStats = [
            'total_sales' => $baseQuery->clone()->sum('total_amount'),
            'total_transactions' => $baseQuery->clone()->count(),
            'avg_transaction' => $baseQuery->clone()->avg('total_amount') ?? 0,
            'total_items_sold' => $baseQuery->clone()->withSum('items', 'quantity')->get()->sum('items_sum_quantity'),
        ];

        $comparisonStats = [
            'total_sales' => $comparisonQuery->clone()->sum('total_amount'),
            'total_transactions' => $comparisonQuery->clone()->count(),
            'avg_transaction' => $comparisonQuery->clone()->avg('total_amount') ?? 0,
            'total_items_sold' => $comparisonQuery->clone()->withSum('items', 'quantity')->get()->sum('items_sum_quantity'),
        ];

        return [
            'current' => $currentStats,
            'comparison' => $comparisonStats,
            'growth' => [
                'total_sales' => $this->calculateGrowthPercentage($currentStats['total_sales'], $comparisonStats['total_sales']),
                'total_transactions' => $this->calculateGrowthPercentage($currentStats['total_transactions'], $comparisonStats['total_transactions']),
                'avg_transaction' => $this->calculateGrowthPercentage($currentStats['avg_transaction'], $comparisonStats['avg_transaction']),
                'total_items_sold' => $this->calculateGrowthPercentage($currentStats['total_items_sold'], $comparisonStats['total_items_sold']),
            ],
        ];
    }

    public function getPaymentMethodStatsProperty(): array
    {
        $dateRange = $this->getDateRangeProperty();

        $query = Payment::whereHas('order', function ($q) use ($dateRange) {
            $q->where('type', 'pos')
                ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
                ->where('status', '!=', 'cancelled');
        })->where('status', 'completed');

        if ($this->selectedTerminal !== 'all') {
            $query->whereHas('order', function ($q) {
                $q->where('terminal_id', $this->selectedTerminal);
            });
        }

        return $query->select('payment_method')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw('SUM(amount) as total_amount')
            ->groupBy('payment_method')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->payment_method => [
                    'count' => $item->transaction_count,
                    'amount' => $item->total_amount,
                ]];
            })
            ->toArray();
    }

    public function getHourlyStatsProperty(): array
    {
        $dateRange = $this->getDateRangeProperty();

        $query = Order::where('type', 'pos')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->where('status', '!=', 'cancelled');

        if ($this->selectedTerminal !== 'all') {
            $query->where('terminal_id', $this->selectedTerminal);
        }

        return $query->selectRaw('HOUR(created_at) as hour')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw('SUM(total_amount) as total_sales')
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->hour => [
                    'transactions' => $item->transaction_count,
                    'sales' => $item->total_sales,
                ]];
            })
            ->toArray();
    }

    public function getTopProductsProperty(): array
    {
        $dateRange = $this->getDateRangeProperty();

        $query = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.type', 'pos')
            ->whereBetween('orders.created_at', [$dateRange['start'], $dateRange['end']])
            ->where('orders.status', '!=', 'cancelled');

        if ($this->selectedTerminal !== 'all') {
            $query->where('orders.terminal_id', $this->selectedTerminal);
        }

        return $query->select('products.name', 'products.price')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->selectRaw('SUM(order_items.total_price) as total_revenue')
            ->groupBy('order_items.product_id', 'products.name', 'products.price')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function getTerminalStatsProperty(): array
    {
        $dateRange = $this->getDateRangeProperty();

        return Order::where('type', 'pos')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->where('status', '!=', 'cancelled')
            ->with('terminal')
            ->select('terminal_id')
            ->selectRaw('COUNT(*) as transaction_count')
            ->selectRaw('SUM(total_amount) as total_sales')
            ->selectRaw('AVG(total_amount) as avg_transaction')
            ->groupBy('terminal_id')
            ->orderBy('total_sales', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'terminal_name' => $item->terminal ? $item->terminal->name : 'Unknown Terminal',
                    'transactions' => $item->transaction_count,
                    'sales' => $item->total_sales,
                    'avg_transaction' => $item->avg_transaction,
                ];
            })
            ->toArray();
    }

    public function getTerminalsProperty()
    {
        return PosTerminal::where('is_active', true)->get();
    }

    public function getStatsProperty(): array
    {
        return [
            'totalUsers' => User::count(),
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalBrands' => Brand::count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentProducts' => Product::with(['category', 'brand'])->latest()->take(5)->get(),
        ];
    }

    private function calculateGrowthPercentage(float $current, float $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 2);
    }

    public function exportAnalytics(): mixed
    {
        $filename = 'analytics_report_'.now()->format('Y-m-d_H-i-s').'.xlsx';

        return Excel::download(new AnalyticsExport($this), $filename);
    }

    public function render()
    {
        return view('livewire.admin.analytics');
    }
}
