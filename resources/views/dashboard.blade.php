<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6">
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">
                {{ __('Welcome back, :name!', ['name' => auth()->user()->name]) }}
            </h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-2">
                {{ __('This is your client dashboard. Here you can manage your account settings, view your active orders, and update your profile.') }}
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Account Status Card -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">
                    {{ __('Account Status') }}
                </h2>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded-lg">
                            <flux:icon.envelope class="size-5 text-zinc-500" />
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Email') }}</p>
                            <p class="font-medium text-zinc-900 dark:text-white">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded-lg">
                            <flux:icon.shield-check class="size-5 text-zinc-500" />
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Verification Status') }}</p>
                            <p class="font-medium text-zinc-900 dark:text-white">
                                @if(auth()->user()->hasVerifiedEmail())
                                    <span class="text-green-600 dark:text-green-400">{{ __('Verified') }}</span>
                                @else
                                    <span class="text-amber-600 dark:text-amber-400">{{ __('Unverified') }}</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="bg-zinc-100 dark:bg-zinc-800 p-2 rounded-lg">
                            <flux:icon.calendar class="size-5 text-zinc-500" />
                        </div>
                        <div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Member Since') }}</p>
                            <p class="font-medium text-zinc-900 dark:text-white">{{ auth()->user()->created_at->format('M j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Access Links -->
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4">
                    {{ __('Quick Access') }}
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <flux:button variant="ghost" class="w-full justify-start" icon="user" :href="route('profile.edit')" wire:navigate>
                        {{ __('Profile') }}
                    </flux:button>
                    <flux:button variant="ghost" class="w-full justify-start" icon="shield-check" :href="route('security.edit')" wire:navigate>
                        {{ __('Security') }}
                    </flux:button>
                    <flux:button variant="ghost" class="w-full justify-start" icon="paint-brush" :href="route('appearance.edit')" wire:navigate>
                        {{ __('Appearance') }}
                    </flux:button>
                </div>

                <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-4 mt-8">
                    {{ __('Actions') }}
                </h2>
                <div class="flex gap-3">
                    <flux:button variant="primary" :href="route('menu')" wire:navigate>
                        {{ __('View menu') }}
                    </flux:button>
                    <flux:button variant="ghost" :href="route('orders.index')" wire:navigate>
                        {{ __('View orders') }}
                    </flux:button>
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
