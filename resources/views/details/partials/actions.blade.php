<div class="flex items-center gap-6 pt-6 border-t border-zinc-200 dark:border-zinc-800">
    <div class="flex items-center bg-zinc-100 dark:bg-zinc-800 rounded-full overflow-hidden border border-zinc-200 dark:border-zinc-700">
        <button @click="qty > 1 ? qty-- : null" class="px-5 py-3 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors flex items-center justify-center text-zinc-600 dark:text-zinc-300">
            <flux:icon.minus class="w-5 h-5" />
        </button>
        <span class="font-bold w-8 text-center text-zinc-900 dark:text-white text-lg" x-text="qty"></span>
        <button @click="qty++" class="px-5 py-3 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors flex items-center justify-center text-zinc-600 dark:text-zinc-300">
            <flux:icon.plus class="w-5 h-5" />
        </button>
    </div>
    <button
        type="button"
        x-on:click="addToCart()"
        class="flex-grow bg-red-600 text-white font-bold py-4 px-6 rounded-full hover:bg-red-700 disabled:cursor-not-allowed disabled:bg-zinc-300 disabled:text-zinc-500 dark:disabled:bg-zinc-800 dark:disabled:text-zinc-500 transition-colors shadow-md flex justify-center items-center gap-2"
        x-bind:disabled="! canAddToCart() || isAddingToCart"
    >
        <flux:icon.shopping-bag class="w-5 h-5" />
        <span class="tracking-wide">
            <span x-show="! isAddingToCart">{{ __('client/details.add_to_cart') }}</span>
            <span x-show="isAddingToCart">{{ __('client/cart.adding') }}</span>
            - <span x-text="formatPrice(totalPrice())"></span>
        </span>
    </button>
</div>

<p x-show="cartError" x-text="cartError" class="text-sm font-medium text-red-600 dark:text-red-400"></p>
