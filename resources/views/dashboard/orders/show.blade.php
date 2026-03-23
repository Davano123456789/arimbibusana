@extends('layouts.masterDashboard')

@section('title', 'Detail Pesanan - Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-lg-8 col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center bg-white border-bottom">
                <h6 class="mb-0">Informasi Pesanan: {{ $order->order_number }}</h6>
                @if($order->status == 'settlement')
                    <span class="badge bg-gradient-warning pb-2">Perlu Dikemas / Lunas</span>
                @elseif($order->status == 'shipped')
                    <span class="badge bg-gradient-info pb-2">Sedang Dikirim</span>
                @elseif($order->status == 'completed')
                    <span class="badge bg-gradient-success pb-2">Selesai</span>
                @elseif($order->status == 'waiting_refund')
                    <span class="badge bg-gradient-danger pb-2">Menunggu Refund</span>
                @elseif($order->status == 'refunded')
                    <span class="badge bg-gradient-secondary pb-2">Telah di-Refund</span>
                @elseif($order->status == 'unpaid')
                    <span class="badge bg-light text-dark border pb-2">Belum Dibayar</span>
                @else
                    <span class="badge bg-gradient-secondary pb-2">{{ strtoupper($order->status) }}</span>
                @endif
            </div>
            
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success text-white">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger text-white">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger text-white">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row mb-4">
                    <div class="col-sm-6">
                        <h6 class="text-xs uppercase text-secondary mb-1">Ditagihkan Kepada</h6>
                        <p class="font-weight-bold mb-1">{{ $order->customer_name }}</p>
                        <p class="text-sm mb-1"><i class="fas fa-phone mr-2 text-secondary"></i> {{ $order->customer_phone }}</p>
                    </div>
                    <div class="col-sm-6">
                        <h6 class="text-xs uppercase text-secondary mb-1">Alamat Pengiriman</h6>
                        <p class="text-sm mb-1">{{ $order->customer_address }}</p>
                        <p class="text-sm mb-1">{{ $order->city_name }}, {{ $order->province_name }}</p>
                        <p class="text-sm mt-3 font-weight-bold">Kurir Pilihan: <span class="text-uppercase text-primary">{{ $order->courier }}</span></p>
                    </div>
                </div>

                <hr class="horizontal dark">

                <h6 class="text-sm">Produk Dibeli</h6>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Qty</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga Satuan</th>
                                <th class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $item->product ? $item->product->name : 'Produk' }}</p>
                                    <p class="text-xs text-secondary mb-0">Ukuran: {{ $item->size_name ?? '-' }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary">{{ $item->quantity }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-end text-sm">
                                    <span class="font-weight-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end text-sm font-weight-bold">Subtotal Produk:</td>
                                <td class="text-end text-sm">Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-sm font-weight-bold">Ongkos Kirim:</td>
                                <td class="text-end text-sm">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-md font-weight-bolder">Total Tagihan Lunas:</td>
                                <td class="text-end text-md font-weight-bolder text-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <!-- Input Resi / Pengiriman -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header pb-0 bg-white">
                <h6 class="mb-0"><i class="fas fa-truck text-secondary me-2"></i> Status Pengiriman</h6>
            </div>
            <div class="card-body">
                @if($order->status == 'settlement' || $order->status == 'processing')
                    <div class="alert alert-warning text-white text-sm" role="alert">
                        <strong>Perhatian!</strong> Input nomor resi di bawah ini jika barang sudah diserahkan ke kurir untuk merubah status menjadi "Sedang Dikirim".
                    </div>
                    <form action="{{ route('dashboard.orders.resi', $order->id) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-control-label">Nomor Resi ({{ strtoupper($order->courier) }})</label>
                            <input type="text" name="tracking_number" class="form-control" placeholder="ABC123456789" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Simpan & Tandai Dikirim</button>
                    </form>
                @elseif($order->status == 'shipped' || $order->status == 'completed')
                    <div class="d-flex flex-column bg-gray-100 p-3 rounded-3 mb-3">
                        <span class="text-xs text-secondary mb-1">Nomor Resi Lacak</span>
                        <span class="font-weight-bolder text-lg mb-2">{{ $order->tracking_number ?? 'Belum ada data' }}</span>
                        <span class="text-xs text-secondary mb-1">Dikirim Pada</span>
                        <span class="font-weight-bold">{{ $order->shipped_at ? date('d M Y, H:i', strtotime($order->shipped_at)) : '-' }}</span>
                    </div>

                    @if($order->status == 'shipped')
                        <form action="{{ route('dashboard.orders.complete', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-success w-100 btn-sm mb-0 mt-3" onclick="return confirm('Yakin ingin memaksa pesanan ini ditandai Selesai?')">
                                <i class="fas fa-check-double me-2"></i> Paksa Mode "Selesai" (Arrived)
                            </button>
                        </form>
                    @endif
                @else
                    <p class="text-sm text-center text-muted py-3">Pesanan tidak dalam tahap pengiriman.</p>
                @endif
            </div>
        </div>

        <!-- Refund Operations -->
        @if($order->status == 'waiting_refund' || $order->status == 'refunded' || $order->cancel_reason)
        <div class="card shadow-sm border-0 border-danger">
            <div class="card-header pb-0 bg-white">
                <h6 class="mb-0 text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Informasi Pembatalan & Refund</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-xs text-secondary text-uppercase font-weight-bolder">Alasan Pembatalan</label>
                    <p class="text-sm bg-gray-100 p-2 rounded">{{ $order->cancel_reason ?? 'Tidak ada alasan' }}</p>
                </div>

                @if($order->status == 'waiting_refund' || $order->status == 'refunded')
                    <div class="mb-3">
                        <label class="text-xs text-secondary text-uppercase font-weight-bolder">Rekening Tujuan Refund</label>
                        <p class="text-sm bg-gray-100 p-2 rounded mb-0">
                            <strong>{{ $order->refund_bank }}</strong> <br>
                            NO. REK: {{ $order->refund_account_number }}
                        </p>
                    </div>
                @endif

                @if($order->status == 'waiting_refund')
                    <hr>
                    <div class="alert alert-danger text-white text-sm" role="alert">
                        Lakukan transfer dana manual ke rekening pelanggan di atas. Upload bukti struk transfer di bawah ini untuk menutup kasus.
                    </div>
                    <form action="{{ route('dashboard.orders.refund', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="form-control-label">Foto Bukti Transfer (Refund)</label>
                            <input type="file" name="refund_receipt" class="form-control form-control-sm" accept="image/jpeg,image/png,image/jpg" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Tandai Telah Direfund</button>
                    </form>
                @elseif($order->status == 'refunded')
                    <div class="alert alert-success text-white text-sm">
                        <i class="fas fa-check-circle me-1"></i> Dana telah dikembalikan.
                    </div>
                    @if($order->refund_receipt)
                        <div class="text-center mt-3">
                            <label class="text-xs text-secondary">Bukti Transfer:</label><br>
                            <a href="{{ asset('storage/' . $order->refund_receipt) }}" target="_blank">
                                <img src="{{ asset('storage/' . $order->refund_receipt) }}" class="img-fluid rounded border mt-2" style="max-height: 200px;">
                            </a>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
