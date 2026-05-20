<section id="burgers" class="scroll-mt-24">
    <flux:heading level="2" size="xl" class="mb-8 font-black">{{ __('client/menu.cat_burgers') }}</flux:heading>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <x-menu.product-card 
            spicy
            image="https://lh3.googleusercontent.com/aida-public/AB6AXuA-iNqDilSiAfBf0fkzfTm4feayuE3IvEoLrCdgUOfxzh751rmm1Ysy8rEmpcPXMcuMp3SuHKpTfz9IN-GJ_dRbsab9SGNwTltGKrVgcR4EdFfxXc-v8Xce39Ce2s9aE9nLroNYOTxI_aY8xKCa58dHzpitGxO0kc17-JVh6y2sojlQDgRw4fO97LjpRcbL4ckGC8gVt4TYzlyyRAT0jovyw24X2eeC_7N50N1whT27X_owrU9eXeDCyqJX3EHb1iWDDqm2Fp2Kbzq_"
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
