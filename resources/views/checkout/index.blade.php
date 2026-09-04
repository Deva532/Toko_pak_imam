@extends('layouts.app')

@section('title', 'Checkout Pesanan | Toko Pak Imam')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="checkoutApp()">
    <h1 class="text-xl sm:text-2xl font-black text-gray-900 mb-6 flex items-center gap-2">
        <i class="fa-solid fa-truck-ramp-box text-brand-600"></i> Checkout Pesanan
    </h1>

    <form method="POST" action="{{ route('checkout.process') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf

        <!-- LEFT STEPS CONTAINER -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- STEP 1: ALAMAT PENGIRIMAN -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                    <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs">1</span>
                        Alamat Pengiriman
                    </h3>
                    <a href="{{ route('customer.addresses') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        + Kelola Alamat
                    </a>
                </div>

                @if($addresses->count() > 0)
                <div class="space-y-3">
                    @foreach($addresses as $addr)
                    <label class="block p-4 rounded-2xl border transition cursor-pointer" :class="selectedAddressId == {{ $addr->id }} ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-100' : 'border-gray-200 hover:border-gray-300'">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-2">
                                <input type="radio" name="address_id" value="{{ $addr->id }}" x-model="selectedAddressId" class="text-brand-600 focus:ring-brand-500">
                                <span class="text-xs font-bold text-gray-900">{{ $addr->label }}</span>
                                @if($addr->is_default)
                                <span class="bg-brand-100 text-brand-700 text-[10px] font-black px-2 py-0.5 rounded-full uppercase">Utama</span>
                                @endif
                            </div>
                            <span class="text-xs font-bold text-gray-700">{{ $addr->recipient_name }} ({{ $addr->phone }})</span>
                        </div>
                        <p class="text-xs text-gray-600 mt-2 pl-6">
                            {{ $addr->address }}, Kel/Kec. {{ $addr->district }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}
                        </p>
                        @if($addr->note)
                        <p class="text-[11px] text-gray-400 mt-1 pl-6 italic"><i class="fa-regular fa-note-sticky mr-1"></i> {{ $addr->note }}</p>
                        @endif
                    </label>
                    @endforeach
                </div>
                @else
                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 text-amber-800 text-xs">
                    Anda belum menyimpan alamat pengiriman. Silakan tambah alamat terlebih dahulu di menu <a href="{{ route('customer.addresses') }}" class="font-bold underline">Kelola Alamat</a>.
                </div>
                @endif
            </div>

            <!-- STEP 2: METODE PENGIRIMAN -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
                    <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs">2</span>
                    Pilih Pengiriman
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($shippingMethods as $sm)
                    <label class="p-4 rounded-2xl border transition cursor-pointer flex flex-col justify-between" :class="selectedShippingId == {{ $sm->id }} ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-100' : 'border-gray-200 hover:border-gray-300'">
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <input type="radio" name="shipping_method_id" value="{{ $sm->id }}" x-model="selectedShippingId" @change="shippingCost = {{ $sm->cost }}" class="text-brand-600 focus:ring-brand-500">
                                <span class="text-xs font-black text-brand-600">Rp{{ number_format($sm->cost, 0, ',', '.') }}</span>
                            </div>
                            <h4 class="text-xs font-bold text-gray-900 mt-2">{{ $sm->name }}</h4>
                            <p class="text-[11px] text-gray-500 mt-0.5"><i class="fa-regular fa-clock mr-1"></i> {{ $sm->estimated_days }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- STEP 3: METODE PEMBAYARAN -->
            <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <h3 class="text-sm font-extrabold text-gray-900 flex items-center gap-2 mb-4 pb-3 border-b border-gray-100">
                    <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-xs">3</span>
                    Metode Pembayaran
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
                    <label class="p-3 rounded-2xl border transition cursor-pointer text-center flex flex-col items-center justify-center" :class="paymentMethod == 'cod' ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-100' : 'border-gray-200 hover:border-gray-300'">
                        <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="sr-only">
                        <i class="fa-solid fa-hand-holding-dollar text-2xl text-brand-600 mb-1"></i>
                        <span class="text-xs font-bold text-gray-900">COD (Bayar di Tempat)</span>
                    </label>

                    <label class="p-3 rounded-2xl border transition cursor-pointer text-center flex flex-col items-center justify-center" :class="paymentMethod == 'bank_transfer' ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-100' : 'border-gray-200 hover:border-gray-300'">
                        <input type="radio" name="payment_method" value="bank_transfer" x-model="paymentMethod" class="sr-only">
                        <i class="fa-solid fa-building-columns text-2xl text-blue-600 mb-1"></i>
                        <span class="text-xs font-bold text-gray-900">Transfer Bank</span>
                    </label>

                    <label class="p-3 rounded-2xl border transition cursor-pointer text-center flex flex-col items-center justify-center" :class="paymentMethod == 'qris' ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-100' : 'border-gray-200 hover:border-gray-300'">
                        <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="sr-only">
                        <i class="fa-solid fa-qrcode text-2xl text-purple-600 mb-1"></i>
                        <span class="text-xs font-bold text-gray-900">QRIS Instant</span>
                    </label>

                    <label class="p-3 rounded-2xl border transition cursor-pointer text-center flex flex-col items-center justify-center" :class="paymentMethod == 'ewallet' ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-100' : 'border-gray-200 hover:border-gray-300'">
                        <input type="radio" name="payment_method" value="ewallet" x-model="paymentMethod" class="sr-only">
                        <i class="fa-solid fa-wallet text-2xl text-amber-500 mb-1"></i>
                        <span class="text-xs font-bold text-gray-900">E-Wallet (Gopay/Ovo)</span>
                    </label>
                </div>

                <!-- NOTES -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Catatan Tambahan untuk Kurir / Toko</label>
                    <textarea name="notes" rows="2" placeholder="Contoh: Titip di satpam rumah, atau tolong pilih beras yang bagus" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs focus:ring-2 focus:ring-brand-500 focus:outline-none"></textarea>
                </div>
            </div>

        </div>

        <!-- RIGHT ORDER SUMMARY -->
        <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm h-fit space-y-6">
            <h3 class="text-sm font-extrabold text-gray-900 border-b border-gray-100 pb-4">Ringkasan Pesanan</h3>

            <!-- ITEMS BRIEF LIST -->
            <div class="space-y-3 max-h-56 overflow-y-auto no-scrollbar pr-1">
                @foreach($cart->items as $item)
                <div class="flex items-center gap-3">
                    <img src="{{ $item->product->main_image }}" class="w-12 h-12 object-cover rounded-xl border border-gray-100 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-gray-900 truncate">{{ $item->product->name }}</p>
                        <p class="text-[10px] text-gray-500">{{ $item->quantity }} x Rp{{ number_format($item->product->effective_price, 0, ',', '.') }}</p>
                    </div>
                    <span class="text-xs font-bold text-gray-900">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>

            <!-- VOUCHER INPUT -->
            <div class="pt-3 border-t border-gray-100">
                <label class="block text-[11px] font-bold text-gray-700 mb-1">Kode Voucher Diskon</label>
                <div class="flex gap-2">
                    <input type="text" x-model="voucherCode" placeholder="Kode: PAKIMAMHEMAT" class="bg-gray-50 border border-gray-200 rounded-xl p-2 text-xs uppercase flex-1 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    <button type="button" @click="applyVoucher()" class="bg-gray-900 hover:bg-gray-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                        Gunakan
                    </button>
                </div>
                <template x-if="discount > 0">
                    <p class="text-[11px] font-bold text-emerald-600 mt-1"><i class="fa-solid fa-circle-check"></i> Voucher berhasil! Diskon Rp10.000 terpasang.</p>
                </template>
            </div>

            <!-- BREAKDOWN -->
            <div class="space-y-2.5 text-xs pt-3 border-t border-gray-100">
                <div class="flex items-center justify-between text-gray-600">
                    <span>Subtotal Produk</span>
                    <span class="font-bold text-gray-900">Rp{{ number_format($cart->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-gray-600">
                    <span>Ongkos Kirim</span>
                    <span class="font-bold text-brand-600" x-text="formatRupiah(shippingCost)"></span>
                </div>
                <template x-if="discount > 0">
                    <div class="flex items-center justify-between text-emerald-600">
                        <span>Diskon Voucher</span>
                        <span class="font-bold">-Rp10.000</span>
                    </div>
                </template>

                <div class="border-t border-gray-100 pt-3 flex items-center justify-between text-sm font-extrabold text-gray-900">
                    <span>Total Tagihan</span>
                    <span class="text-xl text-brand-600" x-text="formatRupiah(totalAmount)"></span>
                </div>
            </div>

            <button type="submit" :disabled="!selectedAddressId" class="w-full bg-brand-600 hover:bg-brand-700 disabled:bg-gray-300 text-white font-extrabold text-sm py-4 rounded-2xl shadow-xl transition transform active:scale-95 flex items-center justify-center gap-2">
                Buat Pesanan Sekarang <i class="fa-solid fa-check"></i>
            </button>
        </div>

    </form>
</div>

<script>
    function checkoutApp() {
        return {
            subtotal: {{ $cart->subtotal }},
            selectedAddressId: {{ $defaultAddress ? $defaultAddress->id : 'null' }},
            selectedShippingId: {{ $shippingMethods->first() ? $shippingMethods->first()->id : 'null' }},
            shippingCost: {{ $shippingMethods->first() ? $shippingMethods->first()->cost : 0 }},
            paymentMethod: 'cod',
            voucherCode: '',
            discount: 0,
            applyVoucher() {
                if (this.voucherCode.trim().toUpperCase() === 'PAKIMAMHEMAT') {
                    this.discount = 10000;
                } else {
                    alert('Kode voucher tidak valid.');
                }
            },
            get totalAmount() {
                return Math.max(0, this.subtotal + this.shippingCost - this.discount);
            },
            formatRupiah(num) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(num);
            }
        }
    }
</script>
@endsection
