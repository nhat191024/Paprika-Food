<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\States\Order\Cancelled;
use App\States\Order\Completed;
use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\Cache;

class RevenueChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('admin/dashboard.revenue_chart.heading');
    }

    protected ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? now()->startOfMonth()->toDateString();
        $endDate = $this->pageFilters['endDate'] ?? now()->toDateString();

        $start = CarbonImmutable::parse($startDate)->startOfDay();
        $end = CarbonImmutable::parse($endDate)->endOfDay();

        $period = collect();
        $current = $start;

        while ($current->lte($end)) {
            $period->push($current->toDateString());
            $current = $current->addDay();
        }

        $cacheKey = "dashboard.revenue_chart.{$start->toDateString()}.{$end->toDateString()}";

        [$revenueData, $ordersData] = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($start, $end) {
            return [
                Order::query()
                    ->whereState('status', Completed::class)
                    ->whereBetween('created_at', [$start, $end], 'and')
                    ->selectRaw('DATE(created_at) as date, SUM(final_amount) as total')
                    ->groupBy('date')
                    ->pluck('total', 'date')
                    ->toArray(),

                Order::query()
                    ->whereNotState('status', Cancelled::class)
                    ->whereBetween('created_at', [$start, $end], 'and')
                    ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
                    ->groupBy('date')
                    ->pluck('total', 'date')
                    ->toArray(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => __('admin/dashboard.revenue_chart.revenue_label'),
                    'data' => $period->map(fn(string $date) => (float) ($revenueData[$date] ?? 0))->values()->toArray(),
                    'borderColor' => '#ef4444',
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'fill' => true,
                    'tension' => 0.3,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => __('admin/dashboard.revenue_chart.orders_label'),
                    'data' => $period->map(fn(string $date) => (int) ($ordersData[$date] ?? 0))->values()->toArray(),
                    'borderColor' => '#f97316',
                    'backgroundColor' => 'rgba(249, 115, 22, 0.1)',
                    'fill' => false,
                    'tension' => 0.3,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $period->map(fn(string $date) => CarbonImmutable::parse($date)->format('d/m'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'left',
                ],
                'y1' => [
                    'type' => 'linear',
                    'display' => true,
                    'position' => 'right',
                    'grid' => ['drawOnChartArea' => false],
                ],
            ],
        ];
    }
}
