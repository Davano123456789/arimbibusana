@extends('layouts.masterDashboard')

@section('title', 'Daftar Produk — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Produk</h6>
                <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary btn-sm ms-auto">Tambah Produk</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produk</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kategori</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Harga</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Stok</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @php
                                                $imagePath = $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://via.placeholder.com/50';
                                            @endphp
                                            <img src="{{ $imagePath }}" class="avatar avatar-sm me-3" alt="product-image">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $product->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $product->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $product->category->name ?? 'Tanpa Kategori' }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $product->stock }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $product->status == 'active' ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('dashboard.products.show', $product->id) }}" class="text-info font-weight-bold text-xs me-2" data-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.products.edit', $product->id) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Edit Produk">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="javascript:;" method="POST" class="d-inline delete-form-{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="border-0 bg-transparent text-danger font-weight-bold text-xs delete-btn" data-id="{{ $product->id }}" data-toggle="tooltip" title="Hapus Produk">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada data produk.</p>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete confirmation with SweetAlert2
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const form = document.querySelector(`.delete-form-${id}`);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Produk ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5e72e4', // Argon Primary
                    cancelButtonColor: '#f5365c',  // Argon Danger
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Untuk sementara form action belum dinamis, kita arahkan secara manual jika perlu
                        // atau pastikan route destroy produk sudah ada di web.php
                        form.action = `/dashboard/products/${id}`;
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
