<x-layouts::main title="{{ __('client/home.about_title') }}">
    <div class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 -mb-6 lg:-mb-8 flex flex-col flex-1">
        <!-- Hero Section -->
        <section class="relative flex items-center justify-center py-32 bg-zinc-900 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1550547660-d9450f859349?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover opacity-40" alt="About Hero">
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 to-transparent"></div>
            </div>
            <div class="relative z-10 text-center px-4 max-w-4xl mx-auto" data-animate="fade-up">
                <h1 class="text-5xl md:text-7xl font-black text-white mb-6 tracking-tight uppercase">{{ __('client/home.about_title') }}</h1>
                <p class="text-xl md:text-2xl text-zinc-300 font-medium max-w-2xl mx-auto">{{ __('client/home.about_subtitle') }}</p>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="py-24 bg-white dark:bg-zinc-950 px-6 lg:px-8">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div data-animate="fade-right">
                    <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?q=80&w=1500&auto=format&fit=crop" class="w-full h-auto rounded-3xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500" alt="Our Story">
                </div>
                <div class="space-y-6" data-animate="fade-left">
                    <h2 class="text-sm font-bold text-brand-red uppercase tracking-widest">{{ __('client/home.about_story_subtitle') }}</h2>
                    <h3 class="text-4xl md:text-5xl font-extrabold text-zinc-900 dark:text-white leading-tight">{{ __('client/home.about_story_title') }}</h3>
                    <p class="text-lg text-zinc-600 dark:text-zinc-400">{{ __('client/home.about_content_1') }}</p>
                    <p class="text-lg text-zinc-600 dark:text-zinc-400">{{ __('client/home.about_content_2') }}</p>
                </div>
            </div>
        </section>

        <!-- Our Values Section -->
        <section class="py-24 bg-zinc-50 dark:bg-zinc-900 px-6 lg:px-8">
            <div class="max-w-7xl mx-auto text-center mb-16" data-animate="fade-up">
                <h2 class="text-sm font-bold text-brand-red uppercase tracking-widest mb-2">{{ __('client/home.about_why_choose_us') }}</h2>
                <h3 class="text-4xl font-extrabold text-zinc-900 dark:text-white">{{ __('client/home.about_values_title') }}</h3>
            </div>
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10" data-animate="stagger-children">
                <!-- Value 1 -->
                <div class="bg-white dark:bg-zinc-950 p-10 rounded-3xl shadow-sm border border-zinc-100 dark:border-zinc-800 text-center group hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <flux:icon.sparkles class="size-10 text-brand-red" />
                    </div>
                    <h4 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">{{ __('client/home.about_value_1_title') }}</h4>
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('client/home.about_value_1_desc') }}</p>
                </div>
                <!-- Value 2 -->
                <div class="bg-white dark:bg-zinc-950 p-10 rounded-3xl shadow-sm border border-zinc-100 dark:border-zinc-800 text-center group hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <flux:icon.fire class="size-10 text-brand-red" />
                    </div>
                    <h4 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">{{ __('client/home.about_value_2_title') }}</h4>
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('client/home.about_value_2_desc') }}</p>
                </div>
                <!-- Value 3 -->
                <div class="bg-white dark:bg-zinc-950 p-10 rounded-3xl shadow-sm border border-zinc-100 dark:border-zinc-800 text-center group hover:-translate-y-2 transition-all duration-300">
                    <div class="w-20 h-20 bg-red-50 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <flux:icon.bolt class="size-10 text-brand-red" />
                    </div>
                    <h4 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">{{ __('client/home.about_value_3_title') }}</h4>
                    <p class="text-zinc-600 dark:text-zinc-400">{{ __('client/home.about_value_3_desc') }}</p>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-24 bg-brand-red text-white text-center px-6 lg:px-8">
            <div class="max-w-3xl mx-auto space-y-8" data-animate="scale-in">
                <h2 class="text-4xl md:text-5xl font-black uppercase">{{ __('client/home.about_cta_title') }}</h2>
                <p class="text-xl text-red-100">{{ __('client/home.about_cta_subtitle') }}</p>
                <a href="{{ route('menu') }}" wire:navigate class="inline-block bg-white text-brand-red font-bold text-lg uppercase tracking-wide px-10 py-4 rounded-full shadow-lg hover:bg-red-50 transition-colors">
                    {{ __('client/home.about_cta') }}
                </a>
            </div>
        </section>

        @include('partials.footer')
    </div>
</x-layouts::main>
