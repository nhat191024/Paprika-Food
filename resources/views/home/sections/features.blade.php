<!-- Burger Carousel / Feature Section -->
<section class="w-full bg-[#eeeeee] px-8 py-20 text-center dark:bg-zinc-900">
    <div class="mx-auto max-w-7xl">
        <h2 class="mb-12 text-4xl font-extrabold uppercase text-[#1A1A1A] dark:text-zinc-100 md:text-5xl">{{ __('client/home.features_title') }}</h2>
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <a href="{{ route('menu') }}" wire:navigate class="flex flex-col items-center bg-white p-6 dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700/50 reveal-on-scroll opacity-0 translate-y-8 cursor-pointer hover:shadow-md transition-shadow">
                <img alt="Bulgogi Burger" class="mb-4 w-full aspect-square object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBxp_d55Wv25YdY_ZsB9wWrzxmvRrAa3ZMvwLcrYuDyz0QJyBt89TvT3D4t1vSzdWAuE3BP1ECVSFCqz59FWcvycA-njlo9VpIXoGJFOAS9jHPo-USO0rGdEJyYdNdW8wy1cWpM3IiX1OTdVERpeP9AY-Y55iBjAc275pCULuO8IwUxra-9hsyqrUA_ZGDQ8haPnT2vOzUTwsFUjARa-2SmH8EZRS86VmQYZtR9M420dRtp5G0u0QL8OsU2TaelK6SYJc_uDq0QjzXI">
                <h3 class="text-xl font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ __('client/home.burger_bulgogi') }}</h3>
            </a>
            <a href="{{ route('menu') }}" wire:navigate class="flex flex-col items-center bg-white p-6 dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700/50 reveal-on-scroll opacity-0 translate-y-8 animation-delay-200 cursor-pointer hover:shadow-md transition-shadow">
                <img alt="Shrimp Burger" class="mb-4 w-full aspect-square object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTV6eJ_1T3XYBrNzB-OaAbVzo3b9cnevUIcB_7h8coOzJU0Rx__P4mAXMzs5Ns-F6prqTF0etFPH1_OXy83_Y91hCergLUU3YLVNzXQJldph1zVKUywgp5adqRb8Oby9yT4hiryorEM1g_Sw2Ij5QodZzYjDO3zOSCs4uVK_55WguAX9EXvnTTjzIxQUMiGkh6jmWhzyinsn42GfiBkebv8-V6DpuXQLFGVZ_1emAC7RcOmrAG4WKvWCQSi3pn32Xl7V9sZPrCcu0w">
                <h3 class="text-xl font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ __('client/home.burger_shrimp') }}</h3>
            </a>
            <a href="{{ route('menu') }}" wire:navigate class="flex flex-col items-center bg-white p-6 dark:bg-zinc-800 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-700/50 reveal-on-scroll opacity-0 translate-y-8 animation-delay-400 cursor-pointer hover:shadow-md transition-shadow">
                <img alt="Hanwoo Bulgogi" class="mb-4 w-full aspect-square object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCMQYqUdslowaeWCbfF3nNcfUAY_HKF0_On7fvXeUkPuhCtY_bKnC8iLJw6U8r_4MBnW0qCaNK-qUIwFPr8P1grz5KvBWzgYKQNlT4__z1voj8v3JdaFKHVEb6h33rjOuENW4XoiiKGljMIsnKKNYrKxsLuSvekpKF4FHC2Ssm_NDuJ_cG22Vcn8SNURL78YPIz-uU1tap5aOxsE0mbGWUlLxLSixiEA222pkdJZJo3_uIFz7SEySH9LdflY-7VMcG5G7vL_eG1J1QE">
                <h3 class="text-xl font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ __('client/home.burger_hanwoo') }}</h3>
            </a>
        </div>
    </div>
</section>
