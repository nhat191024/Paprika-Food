<?php

namespace App\Filament\Widgets;

use App\Models\OrderItem;
use App\States\Order\Cancelled;
use Carbon\CarbonImmutable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TopProductsWidget extends TableWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = null;

    public function getHeading(): string
    {
        return __('admin/dashboard.top_products.heading');
    }

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected static ?int $defaultPaginationPageOption = 10;

    protected ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        $startDate = $this->pageFilters['startDate'] ?? now()->startOfMonth()->toDateString();
        $endDate = $this->pageFilters['endDate'] ?? now()->toDateString();

        $start = CarbonImmutable::parse($startDate)->startOfDay();
        $end = CarbonImmutable::parse($endDate)->endOfDay();

        return $table
            ->query(
                fn (): Builder => OrderItem::query()
                    ->fromSub(
                        DB::table('order_items as oi')
                            ->select([
                                DB::raw('MIN(oi.id) as id'),
                                'oi.product_id',
                                DB::raw('SUM(oi.quantity) as total_sold'),
                                DB::raw('SUM(oi.quantity * oi.price) as total_revenue'),
                            ])
                            ->join('orders', 'orders.id', '=', 'oi.order_id')
                            ->where('orders.status', '!=', Cancelled::$name)
                            ->whereBetween('orders.created_at', [$start, $end])
                            ->groupBy('oi.product_id')
                            ->orderByDesc('total_sold')
                            ->limit(10),
                        'order_items'
                    )
                    ->select('order_items.*')
                    ->with('product')
            )
            ->columns([
                TextColumn::make('product.name')
                    ->label(__('admin/dashboard.top_products.name'))
                    ->getStateUsing(fn (OrderItem $record): string => is_array($record->product?->name)
                        ? ($record->product->name[app()->getLocale()] ?? $record->product->name[array_key_first($record->product->name)] ?? '—')
                        : ($record->product?->name ?? '—'))
                    ->searchable(false),

                TextColumn::make('product.category.name')
                    ->label(__('admin/dashboard.top_products.category'))
                    ->getStateUsing(fn (OrderItem $record): string => is_array($record->product?->category?->name)
                        ? ($record->product->category->name[app()->getLocale()] ?? $record->product->category->name[array_key_first($record->product->category->name)] ?? '—')
                        : ($record->product?->category?->name ?? '—'))
                    ->badge()
                    ->color('gray'),

                TextColumn::make('total_sold')
                    ->label(__('admin/dashboard.top_products.total_sold'))
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('total_revenue')
                    ->label(__('admin/dashboard.top_products.total_revenue'))
                    ->formatStateUsing(fn ($state): string => '€' . number_format((float) $state, 2, '.', ','))
                    ->sortable()
                    ->alignRight(),
            ])
            ->filters([])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([])
            ->paginated(false);
    }
}
