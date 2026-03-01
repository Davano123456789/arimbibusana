@extends('layouts.masterDashboard')

@section('title', 'Edit Informasi — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Edit Informasi / Promo</h6>
                <a href="{{ route('dashboard.announcements.index') }}" class="btn btn-secondary btn-sm ms-auto">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.announcements.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Judul Informasi</label>
                                <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" value="{{ old('title', $announcement->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Link Tujuan (Opsional)</label>
                                <input class="form-control @error('link_url') is-invalid @enderror" type="url" name="link_url" value="{{ old('link_url', $announcement->link_url) }}">
                                @error('link_url')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Gambar Baru (Biarkan kosong jika tidak diganti)</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="imageInput" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback text-xs">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="text-xs font-weight-bold">Gambar Saat Ini / Preview:</label>
                                <img id="imagePreview" src="{{ asset('storage/' . $announcement->image) }}" class="rounded shadow-sm d-block" style="max-height: 300px;">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-check form-switch ps-0">
                                <input class="form-check-input ms-auto" type="checkbox" name="is_active" id="is_active" {{ $announcement->is_active ? 'checked' : '' }}>
                                <label class="form-check-label ms-3" for="is_active">Aktifkan Informasi ini</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
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
            document.getElementById('imagePreview').src = URL.createObjectURL(file);
        }
    }
</script>
@endpush
