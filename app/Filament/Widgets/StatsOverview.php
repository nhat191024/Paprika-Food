<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Order;
use App\States\Order\Cancelled;
use App\States\Order\Completed;
use App\States\Order\Pending;
use App\States\Order\Processing;
use Carbon\CarbonImmutable;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $startDate = $this->pageFilters['startDate'] ?? now()->startOfMonth()->toDateString();
        $endDate = $this->pageFilters['endDate'] ?? now()->toDateString();

        $start = CarbonImmutable::parse($startDate)->startOfDay();
        $end = CarbonImmutable::parse($endDate)->endOfDay();

        $previousStart = $start->sub($end->diff($start))->startOfDay();
        $previousEnd = $start->subSecond();

        $cacheKey = "dashboard.stats.{$start->toDateString()}.{$end->toDateString()}";

        $data = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($start, $end, $previousStart, $previousEnd) {
            return [
                'revenue' => Order::query()
                    ->whereState('status', Completed::class)
                    ->whereBetween('created_at', [$start, $end], 'and')
                    ->sum('final_amount'),

                'previous_revenue' => Order::query()
                    ->whereState('status', Completed::class)
                    ->whereBetween('created_at', [$previousStart, $previousEnd], 'and')
                    ->sum('final_amount'),

                'total_orders' => Order::query()
                    ->whereBetween('created_at', [$start, $end], 'and')
                    ->count('*'),

                'previous_orders' => Order::query()
                    ->whereBetween('created_at', [$previousStart, $previousEnd], 'and')
                    ->count('*'),

                'pending_orders' => Order::query()
                    ->whereState('status', [Pending::class, Processing::class])
                    ->count('*'),

                'cancelled_orders' => Order::query()
                    ->whereState('status', Cancelled::class)
                    ->whereBetween('created_at', [$start, $end], 'and')
                    ->count('*'),

                'new_customers' => Customer::query()
                    ->whereBetween('created_at', [$start, $end], 'and')
                    ->count('*'),

                'previous_customers' => Customer::query()
                    ->whereBetween('created_at', [$previousStart, $previousEnd], 'and')
                    ->count('*'),

                'revenue_chart' => Order::query()
                    ->whereState('status', Completed::class)
                    ->whereBetween('created_at', [$start, $end], 'and')
                    ->selectRaw('DATE(created_at) as date, SUM(final_amount) as total')
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->pluck('total')
                    ->toArray(),
            ];
        });

        $revenue = $data['revenue'];
        $previousRevenue = $data['previous_revenue'];
        $totalOrders = $data['total_orders'];
        $previousOrders = $data['previous_orders'];
        $pendingOrders = $data['pending_orders'];
        $newCustomers = $data['new_customers'];
        $previousCustomers = $data['previous_customers'];

        $revenueChange = $previousRevenue > 0
            ? round((($revenue - $previousRevenue) / $previousRevenue) * 100, 1)
            : 0;

        $ordersChange = $previousOrders > 0
            ? round((($totalOrders - $previousOrders) / $previousOrders) * 100, 1)
            : 0;

        $customersChange = $previousCustomers > 0
            ? round((($newCustomers - $previousCustomers) / $previousCustomers) * 100, 1)
            : 0;

        return [
            Stat::make(__('admin/dashboard.stats.revenue'), chr(0x20AC) . number_format((float) $revenue, 2, '.', ','))
                ->description($revenueChange >= 0
                    ? __('admin/dashboard.stats.vs_previous', ['change' => "+{$revenueChange}"])
                    : __('admin/dashboard.stats.vs_previous', ['change' => $revenueChange]))
                ->descriptionIcon($revenueChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($revenueChange >= 0 ? 'success' : 'danger')
                ->chart($data['revenue_chart']),

            Stat::make(__('admin/dashboard.stats.total_orders'), number_format($totalOrders))
                ->description($ordersChange >= 0
                    ? __('admin/dashboard.stats.vs_previous', ['change' => "+{$ordersChange}"])
                    : __('admin/dashboard.stats.vs_previous', ['change' => $ordersChange]))
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersChange >= 0 ? 'success' : 'danger'),

            Stat::make(__('admin/dashboard.stats.pending_orders'), number_format($pendingOrders))
                ->description(__('admin/dashboard.stats.pending_orders_description'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make(__('admin/dashboard.stats.new_customers'), number_format($newCustomers))
                ->description($customersChange >= 0
                    ? __('admin/dashboard.stats.vs_previous', ['change' => "+{$customersChange}"])
                    : __('admin/dashboard.stats.vs_previous', ['change' => $customersChange]))
                ->descriptionIcon($customersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($customersChange >= 0 ? 'success' : 'danger'),
        ];
    }
}
