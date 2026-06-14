@extends('layouts.masterDashboard')

@section('title', 'Detail Member — Arimbi Busana')

@section('content')
<div class="row">
    <!-- User Profile & Summary Card -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body pt-4 p-3 text-center">
                <div class="avatar avatar-xl bg-gradient-primary rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2.2rem; color: #fff;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-sm mb-3 text-secondary">{{ $user->email }}</p>
                <span class="badge bg-gradient-info mb-4">Member / Pelanggan</span>

                <hr class="horizontal dark">

                <div class="text-start mt-3">
                    <h6 class="text-xs text-secondary text-uppercase mb-2">Informasi Profil</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0 border-0 text-sm">
                            <span class="text-secondary">Terdaftar Sejak:</span>
                            <span class="font-weight-bold">{{ $user->created_at->format('d M Y, H:i') }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 border-0 text-sm">
                            <span class="text-secondary">Status Verifikasi:</span>
                            @if($user->email_verified_at)
                                <span class="font-weight-bold text-success"><i class="fas fa-check-circle me-1"></i> Terverifikasi</span>
                            @else
                                <span class="font-weight-bold text-warning"><i class="fas fa-exclamation-circle me-1"></i> Belum Verifikasi</span>
                            @endif
                        </li>
                    </ul>
                </div>

                <div class="mt-4">
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Member
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards & Shopping Details -->
    <div class="col-lg-8 col-md-12">
        <!-- Stats Widgets -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Total Belanja</p>
                                    <h6 class="font-weight-bolder mb-0 mt-1">Rp {{ number_format($totalSpent, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                    <i class="fas fa-coins text-sm opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Beli Sukses</p>
                                    <h6 class="font-weight-bolder mb-0 mt-1">{{ $successfulOrdersCount }} Kali</h6>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                    <i class="fas fa-shopping-bag text-sm opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3 mb-xl-0">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Total Transaksi</p>
                                    <h6 class="font-weight-bolder mb-0 mt-1">{{ $orders->count() }} Order</h6>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="fas fa-receipt text-sm opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card shadow-sm border-0 bg-gradient-faded-warning">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-xs mb-0 text-uppercase font-weight-bold">Saldo Poin</p>
                                    <h6 class="font-weight-bolder mb-0 mt-1">{{ number_format($user->points, 0, ',', '.') }} Poin</h6>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle" style="background-image: linear-gradient(310deg, #f53939 0%, #fbcf33 100%)">
                                    <i class="fas fa-coins text-sm opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchased Items Table -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header pb-0 bg-white border-bottom">
                <h6 class="mb-0"><i class="fas fa-boxes text-secondary me-2"></i> Daftar Barang yang Pernah Dibeli</h6>
                <p class="text-xs text-secondary mt-1 mb-0">Hanya menampilkan barang dari transaksi/pesanan yang berstatus sukses (Lunas/Lunas & Dikirim/Selesai)</p>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produk</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Varian</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga Satuan</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-4">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchasedItems as $item)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @php
                                                $product = $item->product;
                                                $imagePath = $product && $product->cover_image 
                                                    ? asset('storage/' . $product->cover_image) 
                                                    : ($product && $product->images->first() 
                                                        ? asset('storage/' . $product->images->first()->image) 
                                                        : 'https://via.placeholder.com/50');
                                            @endphp
                                            <img src="{{ $imagePath }}" class="avatar avatar-sm me-3" alt="product-image">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $product->name ?? 'Produk Dihapus' }}</h6>
                                            <p class="text-xs text-secondary mb-0">Order: <a href="{{ route('dashboard.orders.show', $item->order_id) }}" class="font-weight-bold text-primary">{{ $item->order->order_number }}</a></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">
                                        Ukuran: {{ $item->size_name ?? '-' }}<br>
                                        Warna: {{ $item->color_name ?? '-' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $item->quantity }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-end pe-4 text-sm">
                                    <span class="font-weight-bold text-dark">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada barang yang dibeli.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Orders History Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header pb-0 bg-white border-bottom">
                <h6 class="mb-0"><i class="fas fa-history text-secondary me-2"></i> Riwayat Lengkap Transaksi / Pesanan</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No. Pesanan</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Tagihan</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm font-weight-bold">{{ $order->order_number }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if($order->status == 'settlement')
                                        <span class="badge badge-sm bg-gradient-warning">Perlu Dikemas</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge badge-sm bg-gradient-info">Sedang Dikirim</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge badge-sm bg-gradient-success">Selesai</span>
                                    @elseif($order->status == 'waiting_refund')
                                        <span class="badge badge-sm bg-gradient-danger">Menunggu Refund</span>
                                    @elseif($order->status == 'refunded')
                                        <span class="badge badge-sm bg-gradient-secondary">Refund Selesai</span>
                                    @elseif($order->status == 'unpaid')
                                        <span class="badge badge-sm bg-secondary">Belum Dibayar</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">{{ strtoupper($order->status) }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('dashboard.orders.show', $order->id) }}" class="text-primary font-weight-bold text-xs" data-toggle="tooltip" title="Lihat Order">
                                        <i class="fas fa-eye me-1"></i> Detail Pesanan
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada riwayat transaksi.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Point Transactions History Table -->
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header pb-0 bg-white border-bottom">
                <h6 class="mb-0"><i class="fas fa-coins text-secondary me-2"></i> Riwayat Poin Loyalitas</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0 text-xs">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tipe</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->pointTransactions()->latest()->get() as $tx)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary text-xs font-weight-bold">{{ $tx->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if($tx->type == 'earn')
                                        <span class="badge badge-sm bg-gradient-success">DAPAT</span>
                                    @elseif($tx->type == 'redeem')
                                        <span class="badge badge-sm bg-gradient-info">TUKAR</span>
                                    @elseif($tx->type == 'refund')
                                        <span class="badge badge-sm bg-gradient-warning">REFUND</span>
                                    @elseif($tx->type == 'revoke')
                                        <span class="badge badge-sm bg-gradient-danger">TARIK</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">{{ strtoupper($tx->type) }}</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center text-sm font-weight-bold {{ $tx->amount > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $tx->amount > 0 ? '+' : '' }}{{ number_format($tx->amount, 0, ',', '.') }}
                                </td>
                                <td>
                                    <p class="text-xs text-secondary mb-0">{{ $tx->description }}</p>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada riwayat transaksi poin.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
