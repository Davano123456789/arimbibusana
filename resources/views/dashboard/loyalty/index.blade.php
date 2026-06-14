@extends('layouts.masterDashboard')

@section('title', 'Loyalty Points — Arimbi Queen')

@section('content')
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12 col-xl-8 mx-auto">
      <div class="card shadow-lg border-0 border-radius-xl">
        <div class="card-header pb-0 p-4 bg-gradient-dark">
          <div class="row">
            <div class="col-md-8 d-flex align-items-center">
              <h6 class="mb-0 text-white"><i class="fas fa-coins me-2"></i> Pengaturan Loyalty Points</h6>
            </div>
          </div>
        </div>
        <div class="card-body p-4">
          @if(session('success'))
            <div class="alert alert-success text-white alert-dismissible fade show" role="alert">
              <span class="alert-icon"><i class="fas fa-check-circle me-2"></i></span>
              <span class="alert-text">{{ session('success') }}</span>
            </div>
          @endif

          @if($errors->any())
            <div class="alert alert-danger text-white alert-dismissible fade show" role="alert">
              <span class="alert-icon"><i class="fas fa-exclamation-circle me-2"></i></span>
              <span class="alert-text">
                <ul class="mb-0 ps-3">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </span>
            </div>
          @endif

          <form action="{{ route('dashboard.loyalty.update') }}" method="POST">
            @csrf
            
            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-4">Sistem Utama</h6>
            
            <div class="row">
              <div class="col-md-12 mb-4">
                <label class="form-label font-weight-bold text-sm">Status Poin Loyalitas</label>
                <div class="form-check form-switch ps-0">
                  <input type="hidden" name="loyalty_status" value="0">
                  <input class="form-check-input ms-auto" type="checkbox" name="loyalty_status" value="1" id="loyalty_status" {{ ($settings['loyalty_status'] ?? '0') == '1' ? 'checked' : '' }}>
                  <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0 font-weight-bold text-xs" for="loyalty_status">Aktifkan Fitur Poin untuk Pelanggan</label>
                </div>
                <small class="text-xs text-muted">Aktifkan agar pembeli dapat mengumpulkan dan menukarkan poin saat checkout.</small>
              </div>
            </div>

            <hr class="horizontal dark my-3">

            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-4">Aturan Perolehan Poin (Earn)</h6>

            <div class="row">
              <div class="col-md-6 mb-4">
                <label class="form-label font-weight-bold text-sm">Minimal Belanja (Rp)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                  <input type="number" name="loyalty_min_order" class="form-control px-3" value="{{ $settings['loyalty_min_order'] ?? '1000000' }}" placeholder="1000000" min="0" required>
                </div>
                <small class="text-xs text-muted">Minimal subtotal belanja produk dalam satu pesanan untuk mendapatkan poin.</small>
              </div>

              <div class="col-md-6 mb-4">
                <label class="form-label font-weight-bold text-sm">Poin yang Diberikan</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-coins text-warning"></i></span>
                  <input type="number" name="loyalty_points_given" class="form-control px-3" value="{{ $settings['loyalty_points_given'] ?? '100' }}" placeholder="100" min="1" required>
                </div>
                <small class="text-xs text-muted">Jumlah poin yang diberikan kepada pembeli jika syarat belanja terpenuhi.</small>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12 mb-4">
                <label class="form-label font-weight-bold text-sm">Metode Perolehan Poin</label>
                <select name="loyalty_method" class="form-select border px-3 py-2 rounded text-sm" required>
                  <option value="multiplier" {{ ($settings['loyalty_method'] ?? 'multiplier') == 'multiplier' ? 'selected' : '' }}>Kelipatan (Contoh: Belanja kelipatan 1jt dapat 100 poin)</option>
                  <option value="flat" {{ ($settings['loyalty_method'] ?? 'multiplier') == 'flat' ? 'selected' : '' }}>Flat / Sekali Dapat (Belanja >= 1jt tetap dapat 100 poin)</option>
                </select>
                <small class="text-xs text-muted">Metode kalkulasi perolehan poin dari total belanja produk pelanggan.</small>
              </div>
            </div>

            <hr class="horizontal dark my-3">

            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-4">Aturan Penukaran Poin (Redeem)</h6>

            <div class="row">
              <div class="col-md-12 mb-4">
                <label class="form-label font-weight-bold text-sm">Nilai Diskon per 1 Poin (Rp)</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="fas fa-tags text-success"></i></span>
                  <input type="number" name="loyalty_point_value" class="form-control px-3" value="{{ $settings['loyalty_point_value'] ?? '100' }}" placeholder="100" min="1" required>
                </div>
                <small class="text-xs text-muted">Nilai potongan belanja (dalam Rupiah) untuk setiap 1 poin yang ditukarkan.</small>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
              <button type="submit" class="btn bg-gradient-dark mb-0 font-weight-bold">
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
