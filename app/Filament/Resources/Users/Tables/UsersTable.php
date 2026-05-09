<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\Role;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->label(__('admin/customer.table.avatar'))
                    ->circular()
                    ->state(fn($record): ?string => $record->getFilamentAvatarUrl())
                    ->defaultImageUrl(fn($record): string => 'https://ui-avatars.com/api/?name=' . urlencode($record->name) . '&color=7F9CF5&background=EBF4FF'),
                TextColumn::make('name')
                    ->label(__('admin/customer.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('admin/customer.table.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label(__('admin/customer.table.roles'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => Role::labels()[$state] ?? $state)
                    ->color(fn(string $state): string => Role::colorFor($state)),
                IconColumn::make('email_verified_at')
                    ->label(__('admin/customer.table.email_verified_at'))
                    ->boolean()
                    ->state(fn($record): bool => $record->email_verified_at !== null),
                TextColumn::make('created_at')
                    ->label(__('admin/customer.table.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('admin/customer.table.updated_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // SelectFilter::make('roles')
                //     ->label(__('admin/customer.filters.roles'))
                //     ->relationship('roles', 'name')
                //     ->multiple()
                //     ->preload(),
                Filter::make('email_verified')
                    ->label(__('admin/customer.filters.email_verified'))
                    ->query(fn(Builder $query) => $query->whereNotNull('email_verified_at')),
            ])
            ->recordActions([
                // EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),/
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
