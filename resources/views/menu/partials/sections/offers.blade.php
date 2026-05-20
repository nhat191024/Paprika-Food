<section id="offers" class="scroll-mt-24">
    <flux:heading level="2" size="xl" class="mb-8 font-black">{{ __('client/menu.cat_offers') }}</flux:heading>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <x-menu.product-card 
            title="{{ __('client/menu.product_double_combo_title') }}"
            description="{{ __('client/menu.product_double_combo_desc') }}"
            price="{{ __('client/menu.from') }} 12.90€"
        />
    </div>
</section>
