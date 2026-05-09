<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case STAFF = 'staff';
    case CUSTOMER = 'customer';

    public function label(): string
    {
        return __("common/role.{$this->value}");
    }

    public static function labels(): array
    {
        return array_reduce(self::cases(), static fn (array $labels, self $role): array => [
            ...$labels,
            $role->value => $role->label(),
        ], []);
    }

    public function color(): string
    {
        return match ($this) {
            self::ADMIN => 'danger',
            self::STAFF => 'warning',
            self::CUSTOMER => 'success',
        };
    }

    public static function colorFor(string $value): string
    {
        return match ($value) {
            self::ADMIN->value => self::ADMIN->color(),
            self::STAFF->value => self::STAFF->color(),
            self::CUSTOMER->value => self::CUSTOMER->color(),
            default => 'gray',
        };
    }
}
