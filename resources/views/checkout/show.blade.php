<x-layouts::main title="{{ __('client/checkout.title') }}">
    <div class="-mx-6 -mt-6 flex-1 bg-zinc-50 px-6 py-12 dark:bg-zinc-950 lg:-mx-8 lg:-mt-8 lg:px-8">
        <form method="POST" action="{{ route('checkout.store') }}" class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[1fr_24rem]">
            @csrf

            <div class="space-y-6">
                <flux:heading size="xl">{{ __('client/checkout.title') }}</flux:heading>

                <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-5">{{ __('client/checkout.delivery_information') }}</flux:heading>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <flux:field>
                            <flux:label>{{ __('client/checkout.full_name') }}</flux:label>
                            <flux:input name="delivery_recipient_name" value="{{ old('delivery_recipient_name', auth()->user()?->name) }}" required />
                            <flux:error name="delivery_recipient_name" />
                        </flux:field>

                        <flux:field>
                            <flux:label>{{ __('client/checkout.phone_number') }}</flux:label>
                            <flux:input name="delivery_phone" value="{{ old('delivery_phone') }}" required />
                            <flux:error name="delivery_phone" />
                        </flux:field>

                        <flux:field class="sm:col-span-2">
                            <flux:label>{{ __('client/checkout.delivery_address') }}</flux:label>
                            <flux:input name="delivery_address_detail" value="{{ old('delivery_address_detail') }}" required />
                            <flux:error name="delivery_address_detail" />
                        </flux:field>

                        <flux:field class="sm:col-span-2">
                            <flux:label>{{ __('client/checkout.note') }}</flux:label>
                            <flux:textarea name="delivery_note" rows="4">{{ old('delivery_note') }}</flux:textarea>
                            <flux:error name="delivery_note" />
                        </flux:field>

                        <div class="sm:col-span-2 mt-2" x-data="{ scheduled: '{{ old('scheduled_delivery_time') ? '1' : '0' }}' }">
                            <flux:label>{{ __('client/checkout.delivery_time') }}</flux:label>
                            <div class="mt-3 flex gap-6">
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="is_scheduled" value="0" x-model="scheduled" class="text-brand-red">
                                    <span>{{ __('client/checkout.asap') }}</span>
                                </label>
                                <label class="flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="is_scheduled" value="1" x-model="scheduled" class="text-brand-red">
                                    <span>{{ __('client/checkout.schedule') }}</span>
                                </label>
                            </div>
                            <div x-show="scheduled == '1'" x-transition class="mt-4" style="display: none;">
                                <flux:input type="datetime-local" name="scheduled_delivery_time" min="{{ now()->format('Y-m-d\TH:i') }}" value="{{ old('scheduled_delivery_time') }}" />
                                <flux:error name="scheduled_delivery_time" />
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-5">{{ __('client/checkout.payment_method') }}</flux:heading>
                    <div class="space-y-3">
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-zinc-200 p-4 dark:border-zinc-800">
                            <input type="radio" name="payment_method" value="cash" class="text-brand-red" @checked(old('payment_method', 'cash') === 'cash')>
                            <span class="font-semibold">{{ __('client/checkout.cash') }}</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-zinc-200 p-4 dark:border-zinc-800">
                            <input type="radio" name="payment_method" value="credit_card" class="text-brand-red" @checked(old('payment_method') === 'credit_card')>
                            <span class="font-semibold">{{ __('client/checkout.credit_card') }}</span>
                        </label>
                    </div>
                    <flux:error name="payment_method" />
                </section>
            </div>

            <aside class="h-fit rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 lg:sticky lg:top-24">
                <flux:heading size="lg" class="mb-5">{{ __('client/checkout.order_summary') }}</flux:heading>
                <div class="space-y-4">
                    @foreach($cart['items'] as $item)
                        <div class="flex gap-3">
                            <div class="size-14 shrink-0 overflow-hidden rounded-xl bg-zinc-100 dark:bg-zinc-800">
                                @if($item['image'])
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="size-full object-contain">
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-bold">{{ $item['name'] }}</p>
                                <p class="text-xs text-zinc-500">x{{ $item['quantity'] }}</p>
                            </div>
                            <span class="text-sm font-bold">{{ number_format($item['subtotal'], 2) }} EUR</span>
                        </div>
                    @endforeach
                </div>

                <div class="my-6 border-t border-zinc-200 dark:border-zinc-800"></div>

                <div class="mb-2 flex justify-between text-sm">
                    <span>{{ __('client/cart.subtotal') }}</span>
                    <span>{{ number_format($cart['subtotal'], 2) }} EUR</span>
                </div>
                <div class="mb-6 flex justify-between text-xl font-black">
                    <span>{{ __('client/cart.total') }}</span>
                    <span class="text-brand-red">{{ number_format($cart['total'], 2) }} EUR</span>
                </div>

                <button type="submit" class="w-full rounded-full bg-brand-red px-6 py-4 text-sm font-black uppercase tracking-wide text-white hover:bg-red-700">
                    {{ __('client/checkout.order_now') }} →
                </button>
            </aside>
        </form>
    </div>
</x-layouts::main>
