<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\States\Order\Cancelled;
use App\States\Order\Completed;
use App\States\Order\Pending;
use App\States\Order\Processing;
use App\States\Order\Ready;
use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\Cache;

class OrdersByStatusChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = null;

    public function getHeading(): string
    {
        return __('admin/dashboard.orders_by_status_chart.heading');
    }

    protected ?string $pollingInterval = null;

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? now()->startOfMonth()->toDateString();
        $endDate = $this->pageFilters['endDate'] ?? now()->toDateString();

        $start = CarbonImmutable::parse($startDate)->startOfDay();
        $end = CarbonImmutable::parse($endDate)->endOfDay();

        $statuses = [
            __('admin/dashboard.orders_by_status_chart.pending') => Pending::$name,
            __('admin/dashboard.orders_by_status_chart.processing') => Processing::$name,
            __('admin/dashboard.orders_by_status_chart.ready') => Ready::$name,
            __('admin/dashboard.orders_by_status_chart.completed') => Completed::$name,
            __('admin/dashboard.orders_by_status_chart.cancelled') => Cancelled::$name,
        ];

        $cacheKey = "dashboard.orders_by_status.{$start->toDateString()}.{$end->toDateString()}";

        $counts = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($start, $end) {
            return Order::query()
                ->whereBetween('created_at', [$start, $end], 'and')
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray();
        });

        $data = collect($statuses)->map(fn(string $state) => (int) ($counts[$state] ?? 0));

        return [
            'datasets' => [
                [
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => [
                        '#94a3b8',
                        '#f97316',
                        '#3b82f6',
                        '#22c55e',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => $data->keys()->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
