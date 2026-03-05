@extends('layouts.masterDashboard')

@section('title', 'Daftar Blog — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Blog</h6>
                <a href="{{ route('dashboard.blogs.create') }}" class="btn btn-primary btn-sm ms-auto">Tambah Blog</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Blog</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Author</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ ($blogs->currentPage() - 1) * $blogs->perPage() + $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ $blog->thumbnail ? asset('storage/' . $blog->thumbnail) : 'https://via.placeholder.com/150x100' }}" class="avatar avatar-sm me-3" alt="blog-thumbnail" style="width: 60px !important; height: 40px !important; border-radius: 4px !important;">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $blog->title }}</h6>
                                            <p class="text-xs text-secondary mb-0 text-truncate" style="max-width: 250px;">{{ $blog->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $blog->author }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $blog->published_at ? $blog->published_at->format('d/m/Y') : '-' }}</span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-{{ $blog->status == 'published' ? 'success' : 'secondary' }}">
                                        {{ $blog->status == 'published' ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('public.blog.detail', $blog->slug) }}" target="_blank" class="text-info font-weight-bold text-xs me-2" data-toggle="tooltip" title="Pratinjau">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dashboard.blogs.edit', $blog->id) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Edit Blog">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.blogs.destroy', $blog->id) }}" method="POST" class="d-inline delete-form-{{ $blog->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="border-0 bg-transparent text-danger font-weight-bold text-xs delete-btn" data-id="{{ $blog->id }}" data-toggle="tooltip" title="Hapus Blog">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada data blog.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $blogs->links() }}
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
                    text: "Blog ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5e72e4',
                    cancelButtonColor: '#f5365c',
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
