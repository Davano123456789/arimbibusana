@extends('layouts.masterDashboard')

@section('title', 'Manajemen Pesanan - Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-3 d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h6 class="mb-3 mb-md-0">Manajemen Pesanan</h6>
                <div class="nav-wrapper position-relative w-100 w-md-auto">
                    <ul class="nav nav-pills nav-fill p-1 bg-gray-100 rounded-lg">
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-3 py-1 {{ $status == 'processing' ? 'active bg-white shadow text-dark font-weight-bold' : '' }}" href="{{ route('dashboard.orders.index', ['status' => 'processing']) }}">
                                <span class="ms-1">Perlu Dikemas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-3 py-1 {{ $status == 'shipped' ? 'active bg-white shadow text-dark font-weight-bold' : '' }}" href="{{ route('dashboard.orders.index', ['status' => 'shipped']) }}">
                                <span class="ms-1">Sedang Dikirim</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-3 py-1 {{ $status == 'completed' ? 'active bg-white shadow text-dark font-weight-bold' : '' }}" href="{{ route('dashboard.orders.index', ['status' => 'completed']) }}">
                                <span class="ms-1">Selesai</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-3 py-1 {{ $status == 'refund' ? 'active bg-white shadow text-dark font-weight-bold' : '' }}" href="{{ route('dashboard.orders.index', ['status' => 'refund']) }}">
                                <span class="ms-1">Batal/Refund</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-0 px-3 py-1 {{ $status == 'unpaid' ? 'active bg-white shadow text-dark font-weight-bold' : '' }}" href="{{ route('dashboard.orders.index', ['status' => 'unpaid']) }}">
                                <span class="ms-1">Belum Dibayar</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Invoice</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pelanggan</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Bayar</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                @if($status === 'refund')
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status/Alasan</th>
                                @endif
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration + $orders->firstItem() - 1 }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm font-weight-bold">{{ $order->order_number }}</h6>
                                            <p class="text-xs text-secondary mb-0">Kurir: <span class="text-uppercase">{{ $order->courier }}</span></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $order->customer_name }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $order->customer_phone }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </td>
                                @if($status === 'refund')
                                <td class="align-middle text-center">
                                    @if($order->status === 'cancel' || $order->status === 'expire')
                                        <span class="badge badge-sm bg-gradient-secondary">Batal / Expired</span>
                                    @elseif($order->status === 'waiting_refund')
                                        <span class="badge badge-sm bg-gradient-warning">Antrean Refund</span>
                                    @elseif($order->status === 'refunded')
                                        <span class="badge badge-sm bg-gradient-success">Refund Terkirim</span>
                                    @endif
                                    @if($order->cancel_reason)
                                        <p class="text-xxs text-secondary mb-0 mt-1" style="max-width: 150px; white-space: normal;">Alasan: {{ $order->cancel_reason }}</p>
                                    @endif
                                </td>
                                @endif
                                <td class="align-middle text-center">
                                    <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn btn-sm bg-gradient-info text-white me-2">
                                        Pilih / Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada data pesanan pada tab ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer px-4 border-top">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
