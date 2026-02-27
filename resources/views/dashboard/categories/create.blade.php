@extends('layouts.masterDashboard')

@section('title', 'Tambah Kategori — Arimbi Busana')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>Tambah Kategori Baru</h6>
                <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary btn-sm ms-auto">Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.categories.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Nama Kategori</label>
                                <input class="form-control" type="text" id="name" name="name" placeholder="Contoh: Mukena, Tunik, Scarf" required value="{{ old('name') }}">
                                <p class="text-xs text-secondary mt-1">Slug akan dibuat otomatis berdasarkan nama kategori.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="reset" class="btn btn-light btn-sm me-2">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Kategori</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
