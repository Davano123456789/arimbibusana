@extends('layouts.masterDashboard')

@section('title', 'Pengaturan Website — Arimbi Queen')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12 col-xl-8 mx-auto">
      <div class="card shadow-lg border-0 border-radius-xl">
        <div class="card-header pb-0 p-4 bg-gradient-dark">
          <div class="row">
            <div class="col-md-8 d-flex align-items-center">
              <h6 class="mb-0 text-white"><i class="fas fa-cog me-2"></i> Pengaturan Website</h6>
            </div>
          </div>
        </div>
        <div class="card-body p-4">
          <form action="{{ route('dashboard.settings.update') }}" method="POST">
            @csrf
            
            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-4">Integrasi TikTok Live</h6>
            
            <div class="row">
              <div class="col-md-6 mb-4">
                <label class="form-label">Status TikTok Live</label>
                <div class="form-check form-switch ps-0">
                  <input type="hidden" name="is_tiktok_live" value="0">
                  <input class="form-check-input ms-auto" type="checkbox" name="is_tiktok_live" value="1" id="is_tiktok_live" {{ ($settings['is_tiktok_live'] ?? '0') == '1' ? 'checked' : '' }}>
                  <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="is_tiktok_live">Aktifkan Indikator Live di Navbar</label>
                </div>
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Username TikTok (Tanpa @)</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fab fa-tiktok"></i></span>
                <input type="text" name="tiktok_username" class="form-control" value="{{ $settings['tiktok_username'] ?? '' }}" placeholder="arimbiqueen">
              </div>
              <small class="text-xs text-muted">Digunakan untuk link profil jika sedang tidak live.</small>
            </div>

            <div class="mb-4">
              <label class="form-label">Link TikTok Live</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-link"></i></span>
                <input type="url" name="tiktok_live_url" class="form-control" value="{{ $settings['tiktok_live_url'] ?? '' }}" placeholder="https://www.tiktok.com/@username/live">
              </div>
              <small class="text-xs text-muted">Link langsung ke halaman live streaming Anda.</small>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn bg-gradient-dark mb-0">
                <i class="fas fa-save me-2"></i> Simpan Perubahan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
