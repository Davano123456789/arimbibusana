@extends('layouts.masterDashboard')

@section('title', 'Daftar Testimonial — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Daftar Testimonial</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama & Feedback</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Produk</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Rating</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Tampil</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testi)
                            <tr>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ ($testimonials->currentPage() - 1) * $testimonials->perPage() + $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div>
                                            @if($testi->image)
                                                <img src="{{ asset('storage/' . $testi->image) }}" class="avatar avatar-sm me-3 border-radius-lg" alt="testi-image">
                                            @else
                                                <div class="avatar avatar-sm me-3 border-radius-lg bg-gradient-primary d-flex align-items-center justify-content-center">
                                                    <span class="text-white text-xs">{{ strtoupper(substr($testi->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $testi->name }}</h6>
                                            <p class="text-xs text-secondary mb-0 text-wrap" style="max-width: 300px;">{{ Str::limit($testi->comment, 100) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $testi->product->name ?? 'Produk dihapus' }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="d-flex align-items-center justify-content-center text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $testi->rating ? 'fas' : 'far' }} fa-star text-xs"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <form action="{{ route('dashboard.testimonials.toggle', $testi->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="badge badge-sm border-0 bg-gradient-{{ $testi->is_displayed ? 'success' : 'secondary' }} cursor-pointer" data-toggle="tooltip" title="Klik untuk ubah status">
                                            {{ $testi->is_displayed ? 'Ditampilkan' : 'Disembunyikan' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('dashboard.testimonials.show', $testi->id) }}" class="text-info font-weight-bold text-xs me-3" data-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('dashboard.testimonials.destroy', $testi->id) }}" method="POST" class="d-inline delete-form-{{ $testi->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="border-0 bg-transparent text-danger font-weight-bold text-xs delete-btn" data-id="{{ $testi->id }}" data-toggle="tooltip" title="Hapus Testimonial">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <p class="text-xs font-weight-bold mb-0 text-secondary">Belum ada data testimonial.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3">
                    {{ $testimonials->links() }}
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
                    text: "Testimonial ini akan dihapus secara permanen!",
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
