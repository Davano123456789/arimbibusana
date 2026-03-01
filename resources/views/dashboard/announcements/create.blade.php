@extends('layouts.masterDashboard')

@section('title', 'Tambah Informasi — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Tambah Informasi / Promo</h6>
                <a href="{{ route('dashboard.announcements.index') }}" class="btn btn-secondary btn-sm ms-auto">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.announcements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Judul Informasi</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title') }}" placeholder="Contoh: Promo Ramadhan 2026" required>
                                @error('title')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Link Tujuan (Opsional)</label>
                                <input class="form-control @error('link_url') is-invalid @enderror" type="url" name="link_url" value="{{ old('link_url') }}" placeholder="https://example.com/promo">
                                @error('link_url')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Gambar Informasi / Promo</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="imageInput" accept="image/*" required>
                                <p class="text-xs text-secondary mt-1">Saran: Gunakan gambar berukuran 800x800px atau 800x1200px untuk hasil terbaik di popup.</p>
                                @error('image')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                            <div id="imagePreviewContainer" class="mb-4 d-none">
                                <label class="text-xs font-weight-bold">Preview:</label>
                                <img id="imagePreview" src="#" class="rounded shadow-sm d-block" style="max-height: 300px;">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" name="is_active" id="is_active" checked>
                                <label class="form-check-label ms-3" for="is_active">Aktifkan Informasi ini</label>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" name="show_as_popup" id="show_as_popup">
                                <label class="form-check-label ms-3" for="show_as_popup">Jadikan sebagai Popup Utama</label>
                            </div>
                            <p class="text-[10px] text-info ms-3">Catatan: Jika dipilih, popup lain yang sedang aktif akan otomatis non-aktif.</p>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Informasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('imageInput').onchange = evt => {
        const [file] = document.getElementById('imageInput').files;
        if (file) {
            document.getElementById('imagePreviewContainer').classList.remove('d-none');
            document.getElementById('imagePreview').src = URL.createObjectURL(file);
        }
    }
</script>
@endpush
