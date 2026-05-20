<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="flex flex-col min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container sticky class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('home') }}" wire:navigate />
            
            <flux:spacer />
            
            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                    {{ __('client/navigation.home') }}
                </flux:navbar.item>
                <flux:navbar.item icon="squares-2x2" :href="route('menu')" :current="request()->routeIs('menu')" wire:navigate>
                    {{ __('client/navigation.menu') }}
                </flux:navbar.item>
                <!-- <flux:navbar.item icon="magnifying-glass" href="#" wire:navigate>
                    {{ __('client/navigation.explore') }}
                </flux:navbar.item> -->
                <flux:navbar.item icon="shopping-bag" :href="route('orders.index')" :current="request()->routeIs('orders.index')" wire:navigate>
                    {{ __('client/navigation.orders') }}
                </flux:navbar.item>
                <flux:navbar.item icon="information-circle" href="#" wire:navigate>
                    {{ __('client/navigation.about') }}
                </flux:navbar.item>
            </flux:navbar>
            <flux:spacer />

            <x-cart.nav-button />

            <flux:dropdown>
                <flux:button icon="language" variant="ghost" square />
                <flux:menu class="min-w-[12rem]">
                    <x-language-switcher flat />
                </flux:menu>
            </flux:dropdown>
            
            @auth
                <x-desktop-user-menu />
            @else
                <div class="flex items-center gap-4">
                    <flux:button variant="ghost" :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:button>
                    <flux:button variant="primary" :href="route('register')" wire:navigate>{{ __('Register') }}</flux:button>
                </div>
            @endauth
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('home') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('client/navigation.navigation')">
                    <flux:sidebar.item icon="home" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                        {{ __('client/navigation.home') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="squares-2x2" :href="route('menu')" :current="request()->routeIs('menu')" wire:navigate>
                        {{ __('client/navigation.menu') }}
                    </flux:sidebar.item>
                    <!-- <flux:sidebar.item icon="magnifying-glass" href="#" wire:navigate>
                        {{ __('client/navigation.explore') }}
                    </flux:sidebar.item> -->
                    <flux:sidebar.item icon="shopping-bag" :href="route('orders.index')" :current="request()->routeIs('orders.index')" wire:navigate>
                        {{ __('client/navigation.orders') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="information-circle" href="#" wire:navigate>
                        {{ __('client/navigation.about') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            @auth
                <flux:sidebar.nav>
                    <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" wire:navigate>
                        {{ __('common/sidebar.dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="cog" :href="route('profile.edit')" wire:navigate>
                        {{ __('common/sidebar.profile') }}
                    </flux:sidebar.item>
                </flux:sidebar.nav>
            @else
                <flux:sidebar.nav>
                    <flux:sidebar.item icon="arrow-right-end-on-rectangle" :href="route('login')" wire:navigate>
                        {{ __('Log in') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="user-plus" :href="route('register')" wire:navigate>
                        {{ __('Register') }}
                    </flux:sidebar.item>
                </flux:sidebar.nav>
            @endauth
        </flux:sidebar>

        <flux:main class="mx-auto w-full flex flex-1 flex-col">
            {{ $slot }}
        </flux:main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        <x-cart.manager />

        @fluxScripts
    </body>
</html>
