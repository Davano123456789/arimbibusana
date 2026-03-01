@extends('layouts.masterDashboard')

@section('title', 'Manajemen Informasi & Popup — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Manajemen Informasi & Popup</h6>
                <a href="{{ route('dashboard.announcements.create') }}" class="btn btn-primary btn-sm ms-auto">Tambah Informasi</a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Informasi</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Link</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Aktif</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tampil di Popup</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $info)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ ($announcements->currentPage() - 1) * $announcements->perPage() + $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            <img src="{{ asset('storage/' . $info->image) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="info-image">
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $info->title }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    @if($info->link_url)
                                        <a href="{{ $info->link_url }}" target="_blank" class="text-xs text-info underline">Buka Link</a>
                                    @else
                                        <span class="text-xs text-secondary">-</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <form action="{{ route('dashboard.announcements.toggle-status', $info->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="badge badge-sm border-0 bg-gradient-{{ $info->is_active ? 'success' : 'secondary' }} cursor-pointer">
                                            {{ $info->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <form action="{{ route('dashboard.announcements.toggle-popup', $info->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="badge badge-sm border-0 bg-gradient-{{ $info->show_as_popup ? 'primary' : 'light text-dark' }} cursor-pointer" {{ !$info->is_active && !$info->show_as_popup ? 'disabled' : '' }}>
                                            {{ $info->show_as_popup ? 'Aktif di Popup' : 'Set sebagai Popup' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('dashboard.announcements.edit', $info->id) }}" class="text-secondary font-weight-bold text-xs me-3" data-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dashboard.announcements.destroy', $info->id) }}" method="POST" class="d-inline delete-form-{{ $info->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="border-0 bg-transparent text-danger font-weight-bold text-xs delete-btn" data-id="{{ $info->id }}" data-toggle="tooltip" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada data informasi.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $announcements->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const form = document.querySelector(`.delete-form-${id}`);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
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
