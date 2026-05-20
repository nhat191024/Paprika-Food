<!-- Store Highlight Section -->
<section class="flex w-full justify-center bg-white px-8 py-24 dark:bg-zinc-950">
    <div class="grid w-full max-w-7xl grid-cols-1 items-center gap-16 md:grid-cols-2">
        <div class="w-full overflow-hidden rounded-xl shadow-lg">
            <img alt="Jewel Changi Storefront" class="h-auto w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTV6eJ_1T3XYBrNzB-OaAbVzo3b9cnevUIcB_7h8coOzJU0Rx__P4mAXMzs5Ns-F6prqTF0etFPH1_OXy83_Y91hCergLUU3YLVNzXQJldph1zVKUywgp5adqRb8Oby9yT4hiryorEM1g_Sw2Ij5QodZzYjDO3zOSCs4uVK_55WguAX9EXvnTTjzIxQUMiGkh6jmWhzyinsn42GfiBkebv8-V6DpuXQLFGVZ_1emAC7RcOmrAG4WKvWCQSi3pn32Xl7V9sZPrCcu0w">
        </div>
        <div class="flex flex-col gap-6">
            <h2 class="text-4xl font-extrabold uppercase leading-tight text-[#008000] dark:text-[#22c55e] md:text-5xl">
                {!! __('client/home.store_name') !!}
            </h2>
            <div class="mt-2 space-y-4">
                <p class="font-medium text-lg text-[#1A1A1A] dark:text-zinc-300">
                    {!! __('client/home.store_address') !!}
                </p>
                <p class="font-medium text-lg text-[#1A1A1A] dark:text-zinc-300">
                    {{ __('client/home.store_hours') }}
                </p>
            </div>
            <div class="mt-6">
                <a href="{{ route('menu') }}" wire:navigate class="inline-flex items-center justify-center border-none bg-[#f00028] font-bold tracking-wide text-white shadow-md hover:bg-red-700 uppercase px-8 py-4 rounded-xl transition-colors">
                    {{ __('client/home.store_button') }}
                </a>
            </div>
        </div>
    </div>
</section>
