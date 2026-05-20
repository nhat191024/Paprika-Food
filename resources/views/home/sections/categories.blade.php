<!-- Categories Grid Section -->
<section class="flex w-full flex-col items-center border-t border-zinc-200 bg-[#eeeeee] px-8 py-20 dark:border-zinc-800 dark:bg-zinc-900">
    <div class="w-full max-w-7xl text-center">
        <h2 class="mb-12 text-3xl font-extrabold uppercase text-[#1A1A1A] dark:text-zinc-100 md:text-5xl">{{ __('client/home.categories_title') }}</h2>
        <div class="mb-12 grid grid-cols-2 gap-6 md:grid-cols-4">
            <flux:card class="group cursor-pointer overflow-hidden !rounded-xl !border-none !p-0">
                <div class="relative aspect-square overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                    <img alt="Chicken" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC-reOPs2WeyrNO_YLNWAD_SRgaX-AEVwg-yrUXh7J4sZYeZ29aTF3HeGLQjvBj8eszdrqqvkYQIJILldb7_zAW6VW2ykYCycc4ziqPyhs0dNCzkUdKXn39BhjplS75udm4pmvqtRKsT4LE8kpVu2E6c4bBCV1lOhrtcuxI9mkl32-Zh12_Vn8QslHiX4cm2tpAtzzJ8__yJkuNYh2W9wBLaAFopmueiaRiwijCBj2JP6JH9OvknbNI1ldplH8wmxRCj3XSFQmkmx9p">
                </div>
                <div class="bg-white p-4 text-center dark:bg-zinc-800">
                    <h3 class="text-lg font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ __('client/home.category_chicken') }}</h3>
                </div>
            </flux:card>
            <flux:card class="group cursor-pointer overflow-hidden !rounded-xl !border-none !p-0">
                <div class="relative aspect-square overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                    <img alt="Sides" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzLRkx1Nbx91mgBewsibfpYZ9M5OVUZO1FqtsWULA8ibUYYsVJHteGF5ajwjsfp9n9v2NA60zZ7NwQmf7O7cnU0qVaInLpp2-15kVRhCoX2qJI5unIUdHViJw19b2bwuCJGBxstW9E768lSSfI3vCBIvifEeRVa0gaW3JxzxLsp0i7rUlIHHgrsRxYH2RylndO5BqYESFcypIUH_wGu8sra4JsZ4JeZdSasw5Fa10vcbpoZtkk-WM9MqI7l13Kzclu8Od4hmKwQ9WB">
                </div>
                <div class="bg-white p-4 text-center dark:bg-zinc-800">
                    <h3 class="text-lg font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ __('client/home.category_sides') }}</h3>
                </div>
            </flux:card>
            <flux:card class="group cursor-pointer overflow-hidden !rounded-xl !border-none !p-0">
                <div class="relative aspect-square overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                    <img alt="Dessert" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzgn2x-uGmxs4aiHoFxXYi7e8kFhBbaQ7MNHhzjj7lFy3p4wpqGtnlCbjKsJSvrVi8cK5CsGoE175TVJC5dFGzZ-PE6fc5IRjY9Vbe0ROTlY4k1X4mZE9BP0zbidsOfNgB1zWh34XUIi7g_5aeYLnO5ll3MBt6IXL07tQYkRrw_fQzWtckVQlcaGHwkcq6pRs23qhtmSauTfK4j8OgBqgXmj1GElUVLOROVGpr8VWbAYBpUqbQk7KGoDRplQJQN08B88FFoe9UsOgX">
                </div>
                <div class="bg-white p-4 text-center dark:bg-zinc-800">
                    <h3 class="text-lg font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ __('client/home.category_dessert') }}</h3>
                </div>
            </flux:card>
            <flux:card class="group cursor-pointer overflow-hidden !rounded-xl !border-none !p-0">
                <div class="relative aspect-square overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                    <img alt="Beverage" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDt_Fv-r-fAu6Sua_rpD6l69DHHeMmEjNkMwz34rnszsvRP2YuiEXxSgu1vE4aIzcqsomDKhrrr7Jt7m9dA8dMm-6Kh7jJr29A1gfHapPxa7_-geUvc_FuQvUIHVUkHhRjHTuDXzBibcTgntYeYy21Mr2LS3vLBHjtKPA0b5uk5taQ3jcRmQYFuFbXXYS1nnn6Eosb4XI11Xw4vaSiagkBs03VbNmktOTlUun5-ZL9dOo4Putk_U35K_M2uyuVH_6AqtzbpdBV6Db3r">
                </div>
                <div class="bg-white p-4 text-center dark:bg-zinc-800">
                    <h3 class="text-lg font-bold uppercase text-[#1A1A1A] dark:text-zinc-100">{{ __('client/home.category_beverage') }}</h3>
                </div>
            </flux:card>
        </div>

        <flux:button size="base" class="!border-none !bg-[#ffae00] !font-bold !tracking-wide !text-[#1A1A1A] !shadow-md !uppercase hover:!bg-yellow-500 !rounded-full px-10 py-3 text-lg">
            {{ __('client/home.categories_button') }}
        </flux:button>
    </div>
</section>
