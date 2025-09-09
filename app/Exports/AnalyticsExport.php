<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnalyticsExport implements WithMultipleSheets
{
    protected $analyticsComponent;

    public function __construct($analyticsComponent)
    {
        $this->analyticsComponent = $analyticsComponent;
    }

    public function sheets(): array
    {
        return [
            'POS Stats' => new PosStatsSheet($this->analyticsComponent),
            'Payment Methods' => new PaymentMethodsSheet($this->analyticsComponent),
            'Top Products' => new TopProductsSheet($this->analyticsComponent),
            'Terminal Performance' => new TerminalStatsSheet($this->analyticsComponent),
        ];
    }
}

class PosStatsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $analyticsComponent;

    public function __construct($analyticsComponent)
    {
        $this->analyticsComponent = $analyticsComponent;
    }

    public function collection(): Collection
    {
        $posStats = $this->analyticsComponent->getPosStatsProperty();

        return collect([
            (object) [
                'metric' => 'Total Sales',
                'current' => $posStats['current']['total_sales'],
                'comparison' => $posStats['comparison']['total_sales'],
                'growth' => $posStats['growth']['total_sales'],
            ],
            (object) [
                'metric' => 'Total Transactions',
                'current' => $posStats['current']['total_transactions'],
                'comparison' => $posStats['comparison']['total_transactions'],
                'growth' => $posStats['growth']['total_transactions'],
            ],
            (object) [
                'metric' => 'Average Transaction',
                'current' => $posStats['current']['avg_transaction'],
                'comparison' => $posStats['comparison']['avg_transaction'],
                'growth' => $posStats['growth']['avg_transaction'],
            ],
            (object) [
                'metric' => 'Items Sold',
                'current' => $posStats['current']['total_items_sold'],
                'comparison' => $posStats['comparison']['total_items_sold'],
                'growth' => $posStats['growth']['total_items_sold'],
            ],
        ]);
    }

    public function headings(): array
    {
        return ['Metric', 'Current Period', 'Previous Period', 'Growth %'];
    }

    public function map($row): array
    {
        return [
            $row->metric,
            $row->current,
            $row->comparison,
            $row->growth.'%',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}

class PaymentMethodsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $analyticsComponent;

    public function __construct($analyticsComponent)
    {
        $this->analyticsComponent = $analyticsComponent;
    }

    public function collection(): Collection
    {
        $paymentStats = $this->analyticsComponent->getPaymentMethodStatsProperty();

        return collect($paymentStats)->map(function ($stats, $method) {
            return (object) [
                'method' => ucfirst($method),
                'transactions' => $stats['count'],
                'amount' => $stats['amount'],
            ];
        })->values();
    }

    public function headings(): array
    {
        return ['Payment Method', 'Transaction Count', 'Total Amount'];
    }

    public function map($row): array
    {
        return [$row->method, $row->transactions, '$'.number_format($row->amount, 2)];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}

class TopProductsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $analyticsComponent;

    public function __construct($analyticsComponent)
    {
        $this->analyticsComponent = $analyticsComponent;
    }

    public function collection(): Collection
    {
        return collect($this->analyticsComponent->getTopProductsProperty());
    }

    public function headings(): array
    {
        return ['Product Name', 'Unit Price', 'Quantity Sold', 'Total Revenue'];
    }

    public function map($row): array
    {
        return [
            $row->name,
            '$'.number_format($row->price, 2),
            $row->total_quantity,
            '$'.number_format($row->total_revenue, 2),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}

class TerminalStatsSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $analyticsComponent;

    public function __construct($analyticsComponent)
    {
        $this->analyticsComponent = $analyticsComponent;
    }

    public function collection(): Collection
    {
        return collect($this->analyticsComponent->getTerminalStatsProperty());
    }

    public function headings(): array
    {
        return ['Terminal Name', 'Transaction Count', 'Total Sales', 'Average Transaction'];
    }

    public function map($row): array
    {
        return [
            $row['terminal_name'],
            $row['transactions'],
            '$'.number_format($row['sales'], 2),
            '$'.number_format($row['avg_transaction'], 2),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
