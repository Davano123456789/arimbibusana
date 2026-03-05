@extends('layouts.masterPublic')

@section('title', 'Keranjang Belanja — Arimbi Queen')
@section('description', 'Keranjang belanja Anda di Arimbi Queen.')

@section('head')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --cream: #F5ECE0;
            --dark-cream: #E8D9C5;
            --cream-dark: #B78A58;
            --accent: #5B3A29;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
        }

        .text-accent { color: var(--accent); }
        .bg-cream-dark { background-color: var(--cream-dark); }
        .border-accent { border-color: var(--accent); }

        .btn-cream-dark {
            background-color: var(--cream-dark);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .btn-cream-dark:hover {
            filter: brightness(0.9);
            transform: translateY(-2px);
        }

        /* Quantity Input Hide Arrows */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ url('/') }}" class="hover:text-accent">Beranda</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i></li>
                <li class="text-gray-900 font-medium">Keranjang Belanja</li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 font-serif">Keranjang Belanja</h1>

        @if($cartItems->count() > 0)
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Cart Items List -->
            <div class="flex-1">
                <!-- Cart Header (Desktop) -->
                <div class="hidden md:grid grid-cols-12 gap-4 border-b border-gray-200 pb-4 mb-6 text-sm font-bold text-gray-500 uppercase tracking-wider">
                    <div class="col-span-6">Produk</div>
                    <div class="col-span-2 text-center">Harga</div>
                    <div class="col-span-2 text-center">Jumlah</div>
                    <div class="col-span-2 text-right">Total</div>
                </div>

                @php $total = 0; @endphp
                @foreach($cartItems as $item)
                    @php 
                        $itemTotal = $item->product->price * $item->quantity;
                        $total += $itemTotal;
                    @endphp
                    <!-- Cart Item -->
                    <div class="cart-item grid grid-cols-1 md:grid-cols-12 gap-6 items-center border-b border-gray-100 py-6" data-id="{{ $item->id }}">
                        <!-- Product Info -->
                        <div class="col-span-1 md:col-span-6 flex gap-4">
                            <div class="w-24 h-32 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                                @if($item->product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $item->product->images->first()->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/no-image.jpg') }}" alt="No Image" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="font-bold text-gray-900 text-lg mb-1 font-serif">{{ $item->product->name }}</h4>
                                <p class="text-sm text-gray-500 mb-2">Ukuran: <span class="font-medium text-gray-900">{{ $item->size->size }}</span></p>
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1 transition-colors w-fit btn-delete">
                                        <i class="fa-regular fa-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Price (Desktop) -->
                        <div class="hidden md:block col-span-2 text-center text-gray-900 font-medium">
                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                        </div>

                        <!-- Quantity -->
                        <div class="col-span-1 md:col-span-2 flex items-center justify-between md:justify-center">
                            <span class="md:hidden text-sm font-medium text-gray-500">Jumlah:</span>
                            <div class="flex items-center border border-gray-300 rounded-lg bg-white h-10 w-fit">
                                <button class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-accent transition-colors btn-minus"><i class="fa-solid fa-minus text-xs"></i></button>
                                <input type="number" value="{{ $item->quantity }}" min="1" class="w-10 text-center border-none focus:ring-0 text-gray-900 font-bold p-0 text-sm appearance-none bg-transparent qty-input" readonly />
                                <button class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-accent transition-colors btn-plus"><i class="fa-solid fa-plus text-xs"></i></button>
                            </div>
                        </div>

                        <!-- Subtotal -->
                        <div class="col-span-1 md:col-span-2 flex items-center justify-between md:justify-end">
                            <span class="md:hidden text-sm font-medium text-gray-500">Total:</span>
                            <span class="font-bold text-accent item-total">Rp {{ number_format($itemTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach

                <div class="mt-8">
                    <a href="{{ url('/produk') }}" class="text-sm font-medium text-gray-500 hover:text-accent flex items-center gap-2 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-96">
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 sticky top-24">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900 cart-subtotal">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Diskon</span>
                            <span class="font-medium text-green-600">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Estimasi Pengiriman</span>
                            <span class="text-xs text-gray-400 italic">Dihitung saat checkout</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-8">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-bold text-2xl text-accent cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ url('/pembayaran') }}" 
                       class="w-full btn-cream-dark py-4 rounded-xl font-bold flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transition-all active:scale-95 block text-center">
                        <i class="fa-solid fa-credit-card fa-lg"></i> Checkout
                    </a>
                    
                    <p class="text-[10px] text-gray-400 text-center mt-4 leading-relaxed">
                        <i class="fa-solid fa-lock mr-1"></i> Pembayaran aman & terpercaya
                    </p>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-20 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                <i class="fa-solid fa-cart-shopping text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2 font-serif">Keranjang Anda Kosong</h3>
            <p class="text-gray-500 mb-8 max-w-xs mx-auto">Sepertinya Anda belum menambahkan produk apapun ke dalam keranjang belanja.</p>
            <a href="{{ url('/produk') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-accent text-white rounded-xl font-bold hover:brightness-110 transition-all shadow-lg shadow-accent/20">
                Mulai Belanja <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        @endif
    </div>
@endsection

@section('scripts')
<script>
    // Quantity Logic
    const formatIDR = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number).replace('Rp', 'Rp ');
    };

    const updateQuantity = async (id, quantity) => {
        try {
            const response = await fetch(`{{ url('/keranjang') }}/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity })
            });
            const data = await response.json();
            if (data.success) {
                // For now, simple reload or we could update UI dynamically
                window.location.reload(); 
            }
        } catch (error) {
            console.error('Error:', error);
        }
    };

    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.cart-item');
            const id = item.dataset.id;
            const input = item.querySelector('.qty-input');
            let val = parseInt(input.value);
            if (val > 1) {
                val -= 1;
                input.value = val;
                updateQuantity(id, val);
            }
        });
    });

    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.cart-item');
            const id = item.dataset.id;
            const input = item.querySelector('.qty-input');
            let val = parseInt(input.value);
            val += 1;
            input.value = val;
            updateQuantity(id, val);
        });
    });

    // Delete Confirmation with SweetAlert2
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            
            Swal.fire({
                title: 'Hapus Barang?',
                text: "Apakah Anda yakin ingin menghapus produk ini dari keranjang?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#B78A58', // cream-dark
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '1rem',
                customClass: {
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection