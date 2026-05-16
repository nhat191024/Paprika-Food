<!-- Store Highlight Section -->
<section class="py-24 px-8 w-full bg-white dark:bg-zinc-950 flex justify-center">
    <div class="max-w-7xl w-full grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
        <!-- Store Image -->
        <div class="w-full rounded-xl overflow-hidden shadow-lg">
            <img alt="Jewel Changi Storefront" class="w-full h-auto object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTV6eJ_1T3XYBrNzB-OaAbVzo3b9cnevUIcB_7h8coOzJU0Rx__P4mAXMzs5Ns-F6prqTF0etFPH1_OXy83_Y91hCergLUU3YLVNzXQJldph1zVKUywgp5adqRb8Oby9yT4hiryorEM1g_Sw2Ij5QodZzYjDO3zOSCs4uVK_55WguAX9EXvnTTjzIxQUMiGkh6jmWhzyinsn42GfiBkebv8-V6DpuXQLFGVZ_1emAC7RcOmrAG4WKvWCQSi3pn32Xl7V9sZPrCcu0w">
        </div>
        <!-- Store Details -->
        <div class="flex flex-col gap-6">
            <h2 class="text-4xl md:text-5xl font-extrabold text-[#008000] dark:text-[#22c55e] leading-tight uppercase">
                {!! __('client/home.store_name') !!}
            </h2>
            <div class="space-y-4 mt-2">
                <p class="text-lg text-[#1A1A1A] dark:text-zinc-300 font-medium">
                    {!! __('client/home.store_address') !!}
                </p>
                <p class="text-lg text-[#1A1A1A] dark:text-zinc-300 font-medium">
                    {{ __('client/home.store_hours') }}
                </p>
            </div>
            <div class="mt-6">
                <flux:button size="base" class="!bg-[#f00028] !text-white hover:!bg-red-700 !font-bold !tracking-wide !uppercase !border-none !shadow-md px-8 py-4">
                    {{ __('client/home.store_button') }}
                </flux:button>
            </div>
        </div>
    </div>
</section>
