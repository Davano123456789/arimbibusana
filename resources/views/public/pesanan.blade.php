@extends('layouts.masterPublic')

@section('title', 'Pesanan Saya — Arimbi Queen')
@section('description', 'Daftar riwayat pesanan dan status pemesanan Anda di Arimbi Queen.')

@section('head')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-badge {
            padding: 4px 12px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-unpaid { background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }
        .status-pending { background: #FEF3C7; color: #D97706; border: 1px solid #FDE68A; }
        .status-settlement { background: #DCFCE7; color: #16A34A; border: 1px solid #BBF7D0; }
        .status-cancel, .status-expire { background: #F3F4F6; color: #6B7280; border: 1px solid #E5E7EB; }
    </style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12 min-h-[60vh]">
    <h1 class="text-3xl font-bold text-gray-900 mb-2 font-serif">Pesanan Saya</h1>
    <p class="text-gray-500 mb-8">Kelola dan pantau status riwayat pemesanan Anda.</p>

    @if($orders->isEmpty())
        <div class="text-center py-20 bg-gray-50 rounded-2xl border border-gray-100 placeholder-state">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white shadow-sm mb-4">
                <i class="fa-solid fa-box-open text-3xl text-gray-300"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada pesanan</h3>
            <p class="text-gray-500 mb-6">Anda belum pernah melakukan pemesanan sebelumnya.</p>
            <a href="{{ url('/produk') }}" class="inline-block px-8 py-3 bg-accent text-white rounded-full font-medium hover:brightness-110 transition shadow-lg shadow-accent/20">Mulai Belanja</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                    <!-- Order Header -->
                    <div class="bg-gray-50 px-6 py-4 flex flex-col sm:flex-row sm:items-center justify-between border-b border-gray-100 gap-4">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Nomor Pesanan</p>
                                <p class="text-sm font-bold text-gray-800">{{ $order->order_number }}</p>
                            </div>
                            <div class="hidden sm:block h-8 w-px bg-gray-200"></div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium">Tanggal Pembelian</p>
                                <p class="text-sm text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    <!-- Status Badges Update -->
                    <div>
                        @if($order->status === 'unpaid')
                            <span class="status-badge status-unpaid inline-flex items-center gap-1.5"><i class="fa-solid fa-clock text-[10px]"></i> Belum Dibayar</span>
                        @elseif($order->status === 'pending')
                            <span class="status-badge status-pending inline-flex items-center gap-1.5"><i class="fa-solid fa-hourglass-half text-[10px]"></i> Menunggu Konfirmasi</span>
                        @elseif($order->status === 'settlement')
                            <span class="status-badge status-settlement inline-flex items-center gap-1.5"><i class="fa-solid fa-box text-[10px]"></i> Menunggu Dikemas</span>
                        @elseif($order->status === 'shipped')
                            <span class="status-badge text-blue-700 bg-blue-100 border border-blue-200 inline-flex items-center gap-1.5"><i class="fa-solid fa-truck text-[10px]"></i> Sedang Dikirim</span>
                        @elseif($order->status === 'completed')
                            <span class="status-badge text-green-700 bg-green-100 border border-green-200 inline-flex items-center gap-1.5"><i class="fa-solid fa-check-double text-[10px]"></i> Selesai</span>
                        @elseif($order->status === 'waiting_refund')
                            <span class="status-badge status-pending inline-flex items-center gap-1.5"><i class="fa-solid fa-money-bill-transfer text-[10px]"></i> Menunggu Refund</span>
                        @elseif($order->status === 'refunded')
                            <span class="status-badge status-cancel inline-flex items-center gap-1.5"><i class="fa-solid fa-money-check-dollar text-[10px]"></i> Direfund</span>
                        @else
                            <span class="status-badge status-cancel inline-flex items-center gap-1.5"><i class="fa-solid fa-xmark text-[10px]"></i> Dibatalkan / Kedaluwarsa</span>
                        @endif
                    </div>
                    </div>

                    <!-- Order Body (Items Showcase) -->
                    <div class="p-6">
                        @php
                            $firstItem = $order->items->first();
                        @endphp
                        
                        <div class="flex items-start gap-4">
                            <!-- Product Image -->
                            <div class="w-20 h-20 rounded-xl bg-gray-100 flex-shrink-0 overflow-hidden border border-gray-100">
                                @if($firstItem && $firstItem->product && $firstItem->product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $firstItem->product->images->sortByDesc('is_cover')->first()->image) }}" class="w-full h-full object-cover" alt="Product">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-300">
                                        <i class="fa-solid fa-image text-xl"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Product Detail -->
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 text-base mb-1 truncate">
                                    {{ $firstItem ? $firstItem->product->name : 'Produk Tidak Ditemukan' }}
                                </h4>
                                <div class="flex flex-wrap gap-x-4 gap-y-1 items-center">
                                    <p class="text-sm text-gray-500">
                                        {{ $firstItem ? $firstItem->quantity . ' x Rp ' . number_format($firstItem->price, 0, ',', '.') : '' }}
                                    </p>
                                    @if($order->shipping_etd && $order->shipping_etd !== '-')
                                        <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                            <i class="fa-solid fa-truck-fast"></i> Estimasi {{ $order->shipping_etd }}
                                        </div>
                                    @endif
                                </div>
                                
                                @if($order->items->count() > 1)
                                    <p class="text-xs text-gray-400 bg-gray-50 inline-block px-2 py-1 rounded-md mt-2">
                                        + {{ $order->items->count() - 1 }} produk lainnya
                                    </p>
                                @endif

                                @if($order->status === 'unpaid')
                                    <div class="mt-3 flex items-center gap-2 text-[11px] font-bold text-red-500 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100 inline-flex">
                                        <i class="fa-solid fa-stopwatch animate-pulse"></i>
                                        BAYAR SEBELUM: {{ $order->created_at->addHours(24)->format('d M, H:i') }} WIB
                                    </div>
                                @endif
                            </div>

                            <!-- Order Action & Total -->
                            <div class="text-right flex flex-col justify-between items-end h-[80px]">
                                <p class="text-sm text-gray-500 font-medium">Total Belanja</p>
                                <p class="font-bold text-lg text-accent">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions (Footer) -->
                    @if($order->status === 'unpaid')
                        <div class="bg-orange-50/50 px-6 py-4 flex items-center justify-between border-t border-orange-100 gap-4 flex-wrap">
                            <p class="text-sm text-orange-800 flex items-center gap-2">
                                <i class="fa-solid fa-circle-exclamation text-orange-500"></i>
                                Anda belum menyelesaikan pembayaran.
                            </p>
                            
                            <div class="flex gap-2">
                                <form id="form-cancel-{{ $order->id }}" action="{{ route('pesanan.cancel', $order->id) }}" method="POST" class="hidden">@csrf <input type="hidden" name="cancel_reason" id="reason-cancel-{{ $order->id }}"></form>
                                <button onclick="promptCancel({{ $order->id }})" class="px-5 py-2.5 bg-white border border-red-200 hover:bg-red-50 text-red-600 text-sm font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                                    Batalkan
                                </button>
                                @if($order->snap_token)
                                    <button onclick="payNow('{{ $order->snap_token }}')" class="px-6 py-2.5 bg-accent hover:brightness-110 text-white text-sm font-bold rounded-xl shadow-lg shadow-accent/20 transition-all flex items-center gap-2">
                                        Lanjutkan Pembayaran <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @elseif(in_array($order->status, ['settlement', 'pending']))
                        <div class="bg-gray-50/50 px-6 py-4 flex items-center justify-between border-t border-gray-100 gap-4 flex-wrap">
                            <form id="form-refund-{{ $order->id }}" action="{{ route('pesanan.refund', $order->id) }}" method="POST" class="hidden">
                                @csrf 
                                <input type="hidden" name="cancel_reason" id="refund-reason-{{ $order->id }}">
                                <input type="hidden" name="refund_bank" id="refund-bank-{{ $order->id }}">
                                <input type="hidden" name="refund_account_number" id="refund-account-{{ $order->id }}">
                            </form>
                            @if($order->status === 'settlement')
                                <button onclick="promptRefund({{ $order->id }})" class="px-5 py-2 text-red-500 hover:bg-red-50 rounded-lg text-sm font-medium transition-all flex items-center gap-2">
                                    <i class="fa-solid fa-rotate-left"></i> Ajukan Pengembalian Dana
                                </button>
                            @else
                                <div></div>
                            @endif
                            <a href="{{ route('pesanan.invoice', $order->order_number) }}" class="px-6 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl shadow-sm transition-all flex items-center gap-2">
                                <i class="fa-solid fa-receipt text-gray-400"></i> Lihat Invoice
                            </a>
                        </div>
                    @elseif($order->status === 'shipped')
                        <div class="bg-blue-50/50 px-6 py-4 flex items-center justify-between border-t border-blue-100 gap-4 flex-wrap">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-blue-500 font-bold uppercase tracking-wider mb-1">Pengiriman — {{ strtoupper($order->courier) }}</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-gray-900 font-mono font-bold text-lg cursor-pointer hover:text-accent" onclick="copyText('{{ $order->tracking_number }}')" title="Salin Resi">
                                        {{ $order->tracking_number }} 
                                        <i class="fa-regular fa-copy text-sm ml-1 text-gray-400"></i>
                                    </span>
                                </div>
                                @if($order->shipped_at)
                                    <p class="text-[11px] text-gray-500 mt-1">Dikirim pada: {{ \Carbon\Carbon::parse($order->shipped_at)->format('d M Y, H:i') }}</p>
                                @endif
                            </div>
                            
                            <div class="flex gap-3">
                                <a href="{{ route('pesanan.invoice', $order->order_number) }}" class="px-5 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-xl shadow-sm transition-all flex items-center gap-2">
                                    Invoice
                                </a>
                                <form action="{{ route('pesanan.complete', $order->id) }}" method="POST" class="m-0" id="form-complete-{{ $order->id }}">
                                    @csrf
                                    <button type="button" onclick="promptComplete({{ $order->id }})" class="px-6 py-2.5 bg-green-500 hover:bg-green-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all flex items-center gap-2">
                                        <i class="fa-solid fa-box-open"></i> Pesanan Diterima
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif(in_array($order->status, ['waiting_refund', 'refunded']))
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-between items-center flex-wrap gap-4">
                            <div class="flex gap-6">
                                <div class="text-sm">
                                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1">Tujuan Refund</p>
                                    <p class="text-gray-800 font-bold">{{ strtoupper($order->refund_bank) }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->refund_account_number }}</p>
                                </div>
                                @if($order->status === 'refunded' && $order->refund_receipt)
                                <div class="h-10 w-px bg-gray-200"></div>
                                <div class="text-sm">
                                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-wider mb-1">Bukti Transfer</p>
                                    <a href="{{ asset('storage/' . $order->refund_receipt) }}" target="_blank" class="text-accent hover:underline font-bold flex items-center gap-1.5">
                                        <i class="fa-solid fa-image"></i> Buka Foto Bukti
                                    </a>
                                </div>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('pesanan.invoice', $order->order_number) }}" class="px-6 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl shadow-sm transition-all">
                                    Detail Invoice
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50/50 px-6 py-4 flex items-center justify-end border-t border-gray-100 gap-4 flex-wrap">
                            <a href="{{ route('pesanan.invoice', $order->order_number) }}" class="px-6 py-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-xl shadow-sm transition-all flex items-center gap-2">
                                <i class="fa-solid fa-receipt text-gray-400"></i> Lihat Detail
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach

            <!-- Pagination Links -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        </div>
    @endif
</div>

<script>
    function payNow(snapToken) {
        if(!snapToken) {
            Swal.fire('Oops', 'Token pembayaran tidak valid.', 'error');
            return;
        }

        window.snap.pay(snapToken, {
            onSuccess: function(result) {
                window.location.href = "{{ url('/pembayaran/finish') }}?order_id=" + result.order_id;
            },
            onPending: function(result) {
                window.location.href = "{{ url('/pembayaran/finish') }}?order_id=" + result.order_id;
            },
            onError: function(result) {
                window.location.href = "{{ url('/pembayaran/finish') }}?order_id=" + result.order_id;
            },
            onClose: function() {
                Swal.fire('Info', 'Anda menutup jendela pembayaran sebelum proses selesai.', 'info');
            }
        });
    }

    async function promptCancel(id) {
        const { value: reason } = await Swal.fire({
            title: 'Batalkan Pesanan?',
            input: 'textarea',
            inputLabel: 'Ceritakan alasan Anda membatalkan pesanan ini (Opsional)',
            inputPlaceholder: 'Tulis alasan di sini...',
            showCancelButton: true,
            confirmButtonText: 'Batalkan Pesanan',
            cancelButtonText: 'Kembali',
            confirmButtonColor: '#e3342f'
        });

        if (reason !== undefined) {
            document.getElementById('reason-cancel-' + id).value = reason;
            document.getElementById('form-cancel-' + id).submit();
        }
    }

    async function promptRefund(id) {
        const { value: formValues } = await Swal.fire({
            title: 'Ajukan Pengembalian Dana',
            html: `
                <div class="px-2">
                    <p class="text-sm text-gray-500 mb-6 text-left leading-relaxed">Dana akan kami transfer kembali maksimal 2x24 Jam kerja ke rekening Anda setelah disetujui.</p>
                    <div class="space-y-4 text-left">
                        <div>
                            <label class="block font-bold text-xs uppercase text-gray-500 mb-1">Alasan Pembatalan</label>
                            <input id="swal-reason" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition-all" placeholder="Contoh: Salah ukuran/warna">
                        </div>
                        <div>
                            <label class="block font-bold text-xs uppercase text-gray-500 mb-1">Nama Bank Tujuan</label>
                            <input id="swal-bank" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition-all" placeholder="Contoh: BCA a/n Devan">
                        </div>
                        <div>
                            <label class="block font-bold text-xs uppercase text-gray-500 mb-1">Nomor Rekening</label>
                            <input id="swal-acc" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-accent/20 focus:border-accent outline-none transition-all" placeholder="Masukkan nomor rekening valid">
                        </div>
                    </div>
                </div>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Ajukan Refund',
            confirmButtonColor: '#e3342f',
            cancelButtonText: 'Batal',
            width: '32rem',
            padding: '2rem',
            preConfirm: () => {
                const reason = document.getElementById('swal-reason').value;
                const bank = document.getElementById('swal-bank').value;
                const acc = document.getElementById('swal-acc').value;
                if (!reason || !bank || !acc) {
                    Swal.showValidationMessage('Semua kolom wajib diisi!')
                }
                return { reason, bank, acc }
            }
        });

        if (formValues) {
            document.getElementById('refund-reason-' + id).value = formValues.reason;
            document.getElementById('refund-bank-' + id).value = formValues.bank;
            document.getElementById('refund-account-' + id).value = formValues.acc;
            document.getElementById('form-refund-' + id).submit();
        }
    }

    function promptComplete(id) {
        Swal.fire({
            title: 'Pesanan Diterima?',
            text: "Pastikan Anda telah menerima dan memeriksa barang pesanan Anda dengan baik.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16A34A',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Nanti Dulu'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-complete-' + id).submit();
            }
        });
    }

    function copyText(text) {
        navigator.clipboard.writeText(text);
        Swal.fire({
            title: 'Berhasil!',
            text: 'Nomor Resi '+text+' disalin ke clipboard',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    }
</script>
@endsection
