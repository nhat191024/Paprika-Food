<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FilamentNavigationGroup implements HasLabel
{
    case SYSTEM;
    case MENU;
    case CONTENT;
    case SETTINGS;

    public function getLabel(): string
    {
        return match ($this) {
            self::SYSTEM => __('admin/sidebar.navigation.groups.system'),
            self::MENU => __('admin/sidebar.navigation.groups.menu'),
            self::CONTENT => __('admin/sidebar.navigation.groups.content'),
            self::SETTINGS => __('admin/sidebar.navigation.groups.settings'),
        };
    }
}
