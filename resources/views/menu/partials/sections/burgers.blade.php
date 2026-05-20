<section id="burgers" class="scroll-mt-24">
    <flux:heading level="2" size="xl" class="mb-8 font-black">{{ __('client/menu.cat_burgers') }}</flux:heading>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <x-menu.product-card 
            spicy
            title="{{ __('client/menu.product_bulgogi_double_title') }}"
            description="{{ __('client/menu.product_bulgogi_double_desc') }}"
            price="6.50€"
        />
        
        <x-menu.product-card 
            title="{{ __('client/menu.product_beef_burger_title') }}"
            description="{{ __('client/menu.product_beef_burger_desc') }}"
            price="5.00€"
        />
        
        <x-menu.product-card 
            veggie
            title="{{ __('client/menu.product_veggie_delight_title') }}"
            description="{{ __('client/menu.product_veggie_delight_desc') }}"
            price="7.00€"
        />

        <x-menu.product-card 
            title="{{ __('client/menu.product_shrimp_burger_title') }}"
            description="{{ __('client/menu.product_shrimp_burger_desc') }}"
            price="6.00€"
        />

        <x-menu.product-card 
            spicy
            title="{{ __('client/menu.product_zinger_burger_title') }}"
            description="{{ __('client/menu.product_zinger_burger_desc') }}"
            price="5.50€"
        />
    </div>
</section>
