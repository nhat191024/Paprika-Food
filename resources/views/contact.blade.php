<x-layouts::main title="{{ __('client/home.contact_title') }}">
    <div class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 -mb-6 lg:-mb-8 flex flex-col flex-1">
        <!-- Hero Section -->
        <section class="relative flex items-center justify-center py-24 md:py-32 bg-zinc-900 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1596524430615-b46475ddff6e?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-30" alt="Contact Hero">
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-zinc-900/60 to-transparent"></div>
            </div>
            <div class="relative z-10 text-center px-4 max-w-3xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tight uppercase">{{ __('client/home.contact_title') }}</h1>
                <p class="text-xl md:text-2xl text-zinc-300 font-medium">{{ __('client/home.contact_subtitle') }}</p>
            </div>
        </section>

        <!-- Info & Map Section -->
        <section class="py-24 bg-white dark:bg-zinc-950 px-6 lg:px-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16">
                
                <!-- Contact Information Cards -->
                <div class="space-y-8">
                    <div class="mb-10">
                        <h2 class="text-sm font-bold text-brand-red uppercase tracking-widest mb-2">{{ __('client/home.contact_get_in_touch') }}</h2>
                        <h3 class="text-3xl md:text-4xl font-extrabold text-zinc-900 dark:text-white leading-tight">{{ __('client/home.contact_serve_you') }}</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800 flex flex-col hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                                <flux:icon.map-pin class="size-6 text-brand-red" />
                            </div>
                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">{{ __('client/home.contact_address_label') }}</h4>
                            <p class="text-zinc-600 dark:text-zinc-400 font-medium">{{ __('client/home.contact_address') }}</p>
                        </div>

                        <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800 flex flex-col hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                                <flux:icon.clock class="size-6 text-brand-red" />
                            </div>
                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">{{ __('client/home.contact_hours_label') }}</h4>
                            <p class="text-zinc-600 dark:text-zinc-400 font-medium">{{ __('client/home.contact_hours') }}</p>
                        </div>

                        <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800 flex flex-col hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                                <flux:icon.phone class="size-6 text-brand-red" />
                            </div>
                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">{{ __('client/home.contact_phone_label') }}</h4>
                            <p class="text-zinc-600 dark:text-zinc-400 font-medium">{{ __('client/home.contact_phone') }}</p>
                        </div>

                        <div class="bg-zinc-50 dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-100 dark:border-zinc-800 flex flex-col hover:-translate-y-1 transition-transform">
                            <div class="w-12 h-12 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center mb-6 shadow-sm">
                                <flux:icon.envelope class="size-6 text-brand-red" />
                            </div>
                            <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">{{ __('client/home.contact_email_label') }}</h4>
                            <p class="text-zinc-600 dark:text-zinc-400 font-medium">{{ __('client/home.contact_email') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Visual Map/Form Side -->
                <div class="bg-zinc-100 dark:bg-zinc-900 rounded-[2.5rem] p-8 md:p-12 flex flex-col justify-center items-center text-center shadow-inner relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 dark:opacity-5">
                        <!-- A decorative pattern or map background placeholder -->
                        <svg class="w-full h-full text-zinc-900 dark:text-white" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="currentColor" stroke-width="0.5"/>
                            </pattern>
                            <rect width="100" height="100" fill="url(#grid)" />
                        </pattern>
                        </svg>
                    </div>
                    
                    <div class="relative z-10 space-y-6 max-w-sm">
                        <div class="w-20 h-20 bg-brand-red/10 rounded-full flex items-center justify-center mx-auto text-brand-red">
                            <flux:icon.chat-bubble-left-ellipsis class="size-10" />
                        </div>
                        <h3 class="text-2xl font-black uppercase text-zinc-900 dark:text-white">{{ __('client/home.contact_have_question') }}</h3>
                        <p class="text-zinc-600 dark:text-zinc-400">{{ __('client/home.contact_reach_out') }}</p>
                        <a href="mailto:{{ __('client/home.contact_email') }}" class="inline-block mt-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold px-8 py-4 rounded-full hover:bg-zinc-800 dark:hover:bg-zinc-100 transition-colors">
                            {{ __('client/home.contact_send_email') }}
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Navigation Prompt -->
        <section class="py-16 bg-brand-red px-6 lg:px-8 border-t border-red-800">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
                <h3 class="text-3xl font-black text-white uppercase text-center md:text-left">{{ __('client/home.contact_hungry') }}</h3>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('menu') }}" wire:navigate class="bg-white text-brand-red font-bold uppercase tracking-wide px-8 py-4 rounded-full shadow-lg hover:bg-red-50 transition-colors">
                        {{ __('client/navigation.menu') }}
                    </a>
                    <a href="{{ route('orders.index') }}" wire:navigate class="bg-red-800 text-white font-bold uppercase tracking-wide px-8 py-4 rounded-full shadow-lg hover:bg-red-900 transition-colors border border-red-700">
                        {{ __('client/navigation.orders') }}
                    </a>
                </div>
            </div>
        </section>

        @include('partials.footer')
    </div>
</x-layouts::main>
