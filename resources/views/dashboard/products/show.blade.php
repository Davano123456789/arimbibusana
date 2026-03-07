@extends('layouts.masterDashboard')

@section('title', 'Detail Produk — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Detail Produk</h6>
                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary btn-sm ms-auto">Kembali</a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Nama Produk</label>
                            <input class="form-control" type="text" value="{{ $product->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Kategori</label>
                            <input class="form-control" type="text" value="{{ $product->category->name ?? '-' }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Harga (Rp)</label>
                            <input class="form-control" type="text" value="{{ number_format($product->price, 0, ',', '.') }}" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <hr class="horizontal dark mt-0">
                        <h6 class="text-sm">Varian Ukuran & Stok (Total: {{ $product->stock }})</h6>
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ukuran</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Stok Tersedia</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->sizes as $size)
                                    <tr>
                                        <td><span class="text-sm font-weight-bold">{{ $size->size }}</span></td>
                                        <td><span class="text-sm">{{ $size->stock }}</span></td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-{{ $size->stock > 0 ? 'success' : 'danger' }}">
                                                {{ $size->stock > 0 ? 'Tersedia' : 'Kosong' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <hr class="horizontal dark">
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label">Deskripsi Produk</label>
                            <textarea class="form-control" rows="4" readonly>{{ $product->description ?? '-' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-control-label d-block">Preview Foto Produk</label>
                        <div class="d-flex flex-wrap gap-3">
                            @forelse($product->images as $image)
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $image->image) }}" class="rounded shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                                    <p class="text-xs font-weight-bold mt-2 mb-0 text-dark">{{ $image->color ?? 'Tanpa Warna' }}</p>
                                </div>
                            @empty
                                <div class="text-xs text-secondary italic">Tidak ada foto produk.</div>
                            @endforelse
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-control-label d-block">Status Produk</label>
                        <div class="form-check form-switch ps-0">
                            <input class="form-check-input ms-auto" type="checkbox" {{ $product->status == 'active' ? 'checked' : '' }} disabled>
                            <label class="form-check-label ms-2">{{ $product->status == 'active' ? 'Aktif (Muncul di Web)' : 'Non-Aktif' }}</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-control-label d-block">Label Khusus</label>
                        <div class="form-check form-switch ps-0">
                            <input class="form-check-input ms-auto" type="checkbox" {{ $product->is_best_seller ? 'checked' : '' }} disabled>
                            <label class="form-check-label ms-2">Best Seller</label>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-control-label d-block">&nbsp;</label>
                        <div class="form-check form-switch ps-0">
                            <input class="form-check-input ms-auto" type="checkbox" {{ $product->is_recommended ? 'checked' : '' }} disabled>
                            <label class="form-check-label ms-2">Produk Rekomendasi</label>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 text-end">
                    <a href="{{ route('dashboard.products.index') }}" class="btn btn-primary btn-sm">Tutup</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
