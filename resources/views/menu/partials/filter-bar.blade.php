{{-- Break out of flux:main container for the sticky filter bar --}}
<div class="sticky top-[3.5rem] z-40 -mx-6 lg:-mx-8 -mt-6 lg:-mt-8 bg-white border-b border-zinc-200 dark:bg-zinc-900 dark:border-zinc-700 py-3 px-6 lg:px-8 shadow-xs">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-4">
            <div class="relative w-full md:w-80">
                <flux:input x-model="search" placeholder="{{ __('client/menu.search_placeholder') }}" icon="magnifying-glass" variant="filled" class="!bg-zinc-100 dark:!bg-zinc-800" />
            </div>
            <div class="hidden flex items-center gap-2 overflow-x-auto w-full pb-2 md:pb-0 scrollbar-hide">
                <button 
                    @click="activeFilter = activeFilter === 'non-spicy' ? 'all' : 'non-spicy'"
                    :class="activeFilter === 'non-spicy' ? 'bg-brand-red text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                    class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200"
                >
                    {{ __('client/menu.filter_non_spicy') }}
                </button>
                
                <button 
                    @click="activeFilter = activeFilter === 'spicy' ? 'all' : 'spicy'"
                    :class="activeFilter === 'spicy' ? 'bg-brand-red text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                    class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 flex items-center gap-2"
                >
                    <flux:icon name="fire" class="size-4" ::variant="activeFilter === 'spicy' ? 'solid' : 'outline'" />
                    {{ __('client/menu.filter_spicy') }}
                </button>

                <button 
                    @click="activeFilter = activeFilter === 'veggie' ? 'all' : 'veggie'"
                    :class="activeFilter === 'veggie' ? 'bg-brand-red text-white' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                    class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors duration-200 flex items-center gap-2"
                >
                    <flux:icon name="leaf" class="size-4" />
                    {{ __('client/menu.filter_veggie') }}
                </button>
            </div>
        </div>
</div>
