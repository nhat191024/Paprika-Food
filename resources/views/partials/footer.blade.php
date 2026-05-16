<!-- Footer -->
<footer class="bg-[#32373c] py-16 px-8 text-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 items-start">
        <!-- Logo Col -->
        <div class="flex flex-col items-start">
            <div class="mb-6 opacity-80 hover:opacity-100 transition-opacity">
                <x-app-logo href="{{ route('home') }}" wire:navigate class="!text-white brightness-0 invert" />
            </div>
            <p class="text-sm text-gray-400">{!! __('client/home.footer_copyright') !!}</p>
        </div>
        <!-- Nav Links Col -->
        <div class="flex flex-col md:flex-row gap-8 md:gap-16">
            <div class="flex flex-col gap-3">
                <a class="hover:text-[#f00028] transition-colors font-medium uppercase text-sm" href="#">{{ __('client/home.footer_menu') }}</a>
                <a class="hover:text-[#f00028] transition-colors font-medium uppercase text-sm" href="#">{{ __('client/home.footer_promotions') }}</a>
                <a class="hover:text-[#f00028] transition-colors font-medium uppercase text-sm" href="#">{{ __('client/home.footer_locations') }}</a>
                <a class="hover:text-[#f00028] transition-colors font-medium uppercase text-sm" href="#">{{ __('client/home.footer_about') }}</a>
            </div>
            <div class="flex flex-col gap-3">
                <a class="text-gray-400 hover:text-white transition-colors text-sm" href="#">{{ __('client/home.footer_privacy') }}</a>
                <a class="text-gray-400 hover:text-white transition-colors text-sm" href="#">{{ __('client/home.footer_terms') }}</a>
                <a class="text-gray-400 hover:text-white transition-colors text-sm" href="#">{{ __('client/home.footer_contact') }}</a>
            </div>
        </div>
        <!-- Social Icons Col -->
        <div class="flex flex-col items-start md:items-end w-full">
            <h4 class="font-bold mb-4 uppercase">{{ __('client/home.footer_follow_us') }}</h4>
            <div class="flex gap-4">
                <flux:button icon="camera" variant="subtle" class="!rounded-full !w-10 !h-10 !p-0 flex items-center justify-center !bg-gray-700 !text-white hover:!bg-[#f00028] !border-none" />
                <flux:button icon="share" variant="subtle" class="!rounded-full !w-10 !h-10 !p-0 flex items-center justify-center !bg-gray-700 !text-white hover:!bg-[#f00028] !border-none" />
            </div>
        </div>
    </div>
</footer>
