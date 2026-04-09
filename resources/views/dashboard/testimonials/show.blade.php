@extends('layouts.masterDashboard')

@section('title', 'Detail Testimonial — Arimbi Busana')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Detail Testimonial</h6>
                    <a href="{{ route('dashboard.testimonials.index') }}"
                        class="btn btn-secondary btn-sm ms-auto">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Nama Pengirim</label>
                                <input class="form-control" type="text" value="{{ $testimonial->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Produk yang Diulas</label>
                                <input class="form-control" type="text"
                                    value="{{ $testimonial->product->name ?? 'Produk Dihapus' }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Rating</label>
                                <div class="form-control bg-light d-flex align-items-center">
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $testimonial->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </div>
                                    <span class="ms-2 text-xs font-weight-bold">({{ $testimonial->rating }}/5)</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Tanggal Ulasan</label>
                                <input class="form-control" type="text"
                                    value="{{ $testimonial->created_at->format('d M Y, H:i') }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Status Tampilan</label>
                                <div class="form-control bg-light">
                                    <span
                                        class="badge badge-sm bg-gradient-{{ $testimonial->is_displayed ? 'success' : 'secondary' }}">
                                        {{ $testimonial->is_displayed ? 'Ditampilkan' : 'Disembunyikan' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Isi Ulasan</label>
                                <textarea class="form-control" rows="4" readonly>{{ $testimonial->comment }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-control-label d-block">File Testimonial</label>
                            <div class="d-flex flex-wrap gap-2">
                                @if($testimonial->image)
                                    @if(in_array(pathinfo($testimonial->image, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                                        <video src="{{ asset('storage/' . $testimonial->image) }}" class="rounded shadow-sm" style="max-width: 400px; max-height: 300px; object-fit: contain;" controls playsinline></video>
                                    @else
                                        <img src="{{ asset('storage/' . $testimonial->image) }}" class="rounded shadow-sm"
                                            style="max-width: 300px; max-height: 300px; object-fit: contain;">
                                    @endif
                                @else
                                    <div class="text-xs text-secondary italic">Tidak ada file testimonial terlampir.</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-between">
                        <form action="{{ route('dashboard.testimonials.destroy', $testimonial->id) }}" method="POST"
                            class="delete-form-{{ $testimonial->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                data-id="{{ $testimonial->id }}">
                                <i class="fas fa-trash me-1"></i> Hapus Testimonial
                            </button>
                        </form>

                        <div class="d-flex gap-2">
                            <form action="{{ route('dashboard.testimonials.toggle', $testimonial->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="btn btn-{{ $testimonial->is_displayed ? 'secondary' : 'success' }} btn-sm font-weight-bold">
                                    {{ $testimonial->is_displayed ? 'Sembunyikan' : 'Tampilkan di Web' }}
                                </button>
                            </form>
                            <a href="{{ route('dashboard.testimonials.index') }}" class="btn btn-primary btn-sm">Tutup</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function () {
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