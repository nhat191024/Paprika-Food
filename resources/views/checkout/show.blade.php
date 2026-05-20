<x-layouts::main title="{{ __('client/checkout.title') }}">
    <div class="flex-1 bg-zinc-50 py-8 sm:px-6 sm:py-12 dark:bg-zinc-950 lg:px-8 w-full max-w-full overflow-x-hidden rounded-xl">
        <form method="POST" action="{{ route('checkout.store') }}" class="mx-auto grid max-w-6xl gap-8 lg:grid-cols-[1fr_24rem] w-full">
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

                        <div class="sm:col-span-2 mt-2" x-data="{
                            scheduled: '{{ old('scheduled_delivery_time') ? '1' : '0' }}',
                            selectedDay: '',
                            selectedTime: '',
                            days: [],
                            timeSlots: [],
                            businessHours: { start: 10, end: 22 },
                            init() {
                                this.generateDays();
                                const oldValue = '{{ old('scheduled_delivery_time') }}';
                                if (oldValue) {
                                    const date = new Date(oldValue);
                                    if (!isNaN(date.getTime())) {
                                        const yyyy = date.getFullYear();
                                        const mm = String(date.getMonth() + 1).padStart(2, '0');
                                        const dd = String(date.getDate()).padStart(2, '0');
                                        this.selectedDay = `${yyyy}-${mm}-${dd}`;
                                        this.selectedTime = `${String(date.getHours()).padStart(2, '0')}:${String(date.getMinutes()).padStart(2, '0')}`;
                                    }
                                }
                                if (!this.selectedDay && this.days.length > 0) {
                                    this.selectedDay = this.days[0].value;
                                }
                                this.generateTimeSlots();
                                this.$watch('selectedDay', () => {
                                    this.generateTimeSlots();
                                    if (!this.timeSlots.find(slot => slot.value === this.selectedTime)) {
                                        this.selectedTime = this.timeSlots[0] ? this.timeSlots[0].value : '';
                                    }
                                });
                            },
                            generateDays() {
                                const days = [];
                                const today = new Date();
                                let hasTodaySlots = false;
                                const closingTime = new Date();
                                closingTime.setHours(this.businessHours.end, 0, 0, 0);
                                const minTime = new Date(today.getTime() + 40 * 60 * 1000);
                                if (minTime < closingTime) {
                                    hasTodaySlots = true;
                                }
                                const startOffset = hasTodaySlots ? 0 : 1;
                                for (let i = startOffset; i < 7 + startOffset; i++) {
                                    const date = new Date();
                                    date.setDate(today.getDate() + i);
                                    const yyyy = date.getFullYear();
                                    const mm = String(date.getMonth() + 1).padStart(2, '0');
                                    const dd = String(date.getDate()).padStart(2, '0');
                                    const dateString = `${yyyy}-${mm}-${dd}`;
                                    let label = '';
                                    if (i === 0) {
                                        label = '{{ __("client/checkout.today") }}';
                                    } else if (i === 1) {
                                        label = '{{ __("client/checkout.tomorrow") }}';
                                    } else {
                                        const options = { weekday: 'short', month: 'short', day: 'numeric' };
                                        label = date.toLocaleDateString('{{ app()->getLocale() }}', options);
                                    }
                                    days.push({
                                        label: label,
                                        value: dateString
                                    });
                                }
                                this.days = days;
                            },
                            generateTimeSlots() {
                                const slots = [];
                                const today = new Date();
                                const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
                                const isTodaySelected = this.selectedDay === todayStr;
                                let startHour = this.businessHours.start;
                                let startMinute = 0;
                                if (isTodaySelected) {
                                    const minTime = new Date(today.getTime() + 40 * 60 * 1000);
                                    const minHour = minTime.getHours();
                                    const minMinute = minTime.getMinutes();
                                    if (minHour > startHour) {
                                        startHour = minHour;
                                        startMinute = Math.ceil(minMinute / 30) * 30;
                                        if (startMinute >= 60) {
                                            startHour += 1;
                                            startMinute = 0;
                                        }
                                    } else if (minHour === startHour) {
                                        startMinute = Math.max(startMinute, Math.ceil(minMinute / 30) * 30);
                                        if (startMinute >= 60) {
                                            startHour += 1;
                                            startMinute = 0;
                                        }
                                    }
                                }
                                let currentHour = startHour;
                                let currentMin = startMinute;
                                while (currentHour < this.businessHours.end || (currentHour === this.businessHours.end && currentMin === 0)) {
                                    const timeStr = `${String(currentHour).padStart(2, '0')}:${String(currentMin).padStart(2, '0')}`;
                                    slots.push({
                                        label: timeStr,
                                        value: timeStr
                                    });
                                    currentMin += 30;
                                    if (currentMin >= 60) {
                                        currentHour += 1;
                                        currentMin = 0;
                                    }
                                }
                                this.timeSlots = slots;
                            },
                            get datetimeValue() {
                                if (!this.selectedDay || !this.selectedTime) return '';
                                return `${this.selectedDay} ${this.selectedTime}:00`;
                            }
                        }">
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
                            
                            <div x-show="scheduled == '1'" x-transition class="mt-5 space-y-4 rounded-2xl border border-zinc-200 bg-zinc-50/50 p-4 dark:border-zinc-800 dark:bg-zinc-950/20" style="display: none;">
                                <input type="hidden" name="scheduled_delivery_time" :value="datetimeValue">
                                
                                <div class="space-y-2">
                                    <flux:label size="sm">{{ __('client/checkout.select_date') }}</flux:label>
                                    <div class="flex flex-wrap gap-2 pb-2">
                                        <template x-for="day in days" :key="day.value">
                                            <button type="button" 
                                                    @click="selectedDay = day.value"
                                                    :class="selectedDay === day.value ? 'bg-brand-red text-white border-transparent' : 'bg-white hover:bg-zinc-50 text-zinc-800 border-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:border-zinc-700 dark:text-zinc-200'"
                                                    class="rounded-xl border px-4 py-2 text-xs font-bold transition-all shadow-xs">
                                                <span x-text="day.label"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <flux:label size="sm">{{ __('client/checkout.select_time') }}</flux:label>
                                    
                                    <template x-if="timeSlots.length > 0">
                                        <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 max-h-40 overflow-y-auto pr-1">
                                            <template x-for="slot in timeSlots" :key="slot.value">
                                                <button type="button"
                                                        @click="selectedTime = slot.value"
                                                        :class="selectedTime === slot.value ? 'bg-zinc-900 text-white dark:bg-zinc-100 dark:text-zinc-900 border-transparent shadow-xs' : 'bg-white hover:bg-zinc-50 border-zinc-200 text-zinc-800 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:border-zinc-700 dark:text-zinc-200'"
                                                        class="rounded-lg border py-2 text-center text-xs font-bold transition-all">
                                                    <span x-text="slot.label"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </template>
                                    
                                    <template x-if="timeSlots.length === 0">
                                        <p class="text-xs text-zinc-500 italic">{{ __('client/checkout.no_slots') }}</p>
                                    </template>
                                </div>
                                <flux:error name="scheduled_delivery_time" />
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <flux:heading size="lg" class="mb-5">{{ __('client/checkout.payment_method') }}</flux:heading>
                    <div class="space-y-3">
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-zinc-200 p-4 dark:border-zinc-800">
                            <input type="radio" name="payment_method" value="cash" class="shrink-0 text-brand-red" @checked(old('payment_method', 'cash') === 'cash')>
                            <span class="font-semibold flex-1 leading-snug">{{ __('client/checkout.cash') }}</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-zinc-200 p-4 dark:border-zinc-800">
                            <input type="radio" name="payment_method" value="credit_card" class="shrink-0 text-brand-red" @checked(old('payment_method') === 'credit_card')>
                            <span class="font-semibold flex-1 leading-snug">{{ __('client/checkout.credit_card') }}</span>
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
                                    <div class="relative size-full flex items-center justify-center">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="size-full object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden size-full items-center justify-center bg-zinc-100 dark:bg-zinc-800">
                                            <svg class="size-6 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex size-full items-center justify-center bg-zinc-100 dark:bg-zinc-800">
                                        <svg class="size-6 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
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

                <div x-data="{
                        code: '{{ $cart['voucher_code'] ?? '' }}',
                        loading: false,
                        error: '',
                        apply() {
                            if (!this.code) return;
                            this.loading = true;
                            this.error = '';
                            fetch('{{ route('checkout.voucher.apply') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                                },
                                body: JSON.stringify({ code: this.code })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) { window.location.reload(); }
                                else { this.error = data.message; this.loading = false; }
                            })
                            .catch(() => { this.error = 'Something went wrong.'; this.loading = false; });
                        },
                        remove() {
                            this.loading = true;
                            fetch('{{ route('checkout.voucher.remove') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
                                }
                            })
                            .then(() => window.location.reload());
                        }
                    }" class="mb-6">
                    
                    @if(empty($cart['voucher_code']))
                        <div class="flex gap-2">
                            <flux:input x-model="code" placeholder="{{ __('client/checkout.voucher_code') ?? 'Voucher Code' }}" class="w-full uppercase" @keydown.enter.prevent="apply" />
                            <button type="button" @click="apply" :disabled="loading" class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-bold text-white transition-colors hover:bg-zinc-800 disabled:opacity-50 dark:bg-white dark:text-zinc-900 dark:hover:bg-zinc-200">
                                {{ __('client/checkout.apply') ?? 'Apply' }}
                            </button>
                        </div>
                        <p x-show="error" x-text="error" class="mt-2 text-sm text-brand-red"></p>
                    @else
                        <div class="flex items-center justify-between rounded-lg border border-green-200 bg-green-50 p-3 text-green-800 dark:border-green-900/50 dark:bg-green-900/20 dark:text-green-400">
                            <div class="flex items-center gap-2">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-bold uppercase tracking-wider">{{ $cart['voucher_code'] }}</span>
                            </div>
                            <button type="button" @click="remove" :disabled="loading" class="text-sm font-bold text-green-700 hover:text-green-900 hover:underline dark:text-green-500">
                                {{ __('client/checkout.remove') ?? 'Remove' }}
                            </button>
                        </div>
                    @endif
                </div>

                <div class="mb-2 flex justify-between text-sm">
                    <span>{{ __('client/cart.subtotal') }}</span>
                    <span>{{ number_format($cart['subtotal'], 2) }} EUR</span>
                </div>
                
                @if(!empty($cart['discount']) && $cart['discount'] > 0)
                    <div class="mb-2 flex justify-between text-sm text-green-600 dark:text-green-400 font-bold">
                        <span>{{ __('client/checkout.discount') ?? 'Discount' }}</span>
                        <span>-{{ number_format($cart['discount'], 2) }} EUR</span>
                    </div>
                @endif
                
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
