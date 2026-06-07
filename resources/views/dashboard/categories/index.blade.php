@extends('layouts.masterDashboard')

@section('title', 'Daftar Kategori — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex flex-wrap justify-content-between align-items-center gap-2">
                <h6>Daftar Kategori</h6>
                <div class="d-flex align-items-center ms-md-auto gap-2 flex-wrap">
                    <form action="{{ route('dashboard.categories.index') }}" method="GET" class="mb-0">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary mb-0" type="submit">Cari</button>
                            @if(request('search'))
                                <a href="{{ route('dashboard.categories.index') }}" class="btn btn-outline-secondary mb-0">Reset</a>
                            @endif
                        </div>
                    </form>
                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary btn-sm mb-0">Tambah Kategori</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" style="width: 50px;">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kategori</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Jumlah Produk</th>
                                <th class="text-secondary opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $category->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-info">{{ $category->products_count }} Produk</span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="text-secondary font-weight-bold text-xs me-3" data-toggle="tooltip" title="Edit Kategori">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="POST" class="d-inline delete-form-{{ $category->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="border-0 bg-transparent text-danger font-weight-bold text-xs delete-btn" data-id="{{ $category->id }}" data-toggle="tooltip" title="Hapus Kategori">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada data kategori.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer px-4 border-top">
                {{ $categories->links() }}
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
                    text: "Seluruh produk dalam kategori ini juga akan terhapus. Aksi ini tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5e72e4', // Argon Primary
                    cancelButtonColor: '#f5365c',  // Argon Danger
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endpush
