@extends('layouts.masterDashboard')

@section('title', 'Dashboard — Arimbi Busana')

@section('content')
<div class="row">
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Pesanan Hari Ini</p>
              <h5 class="font-weight-bolder">{{ $ordersToday }}</h5>
              <p class="mb-0">
                @if($ordersDiffPercent >= 0)
                  <span class="text-success text-sm font-weight-bolder">+{{ number_format($ordersDiffPercent, 1) }}%</span>
                @else
                  <span class="text-danger text-sm font-weight-bolder">{{ number_format($ordersDiffPercent, 1) }}%</span>
                @endif
                dibanding kemarin
              </p>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
              <i class="fas fa-shopping-cart text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Pendapatan</p>
              <h5 class="font-weight-bolder">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h5>
              <p class="mb-0">
                @if($revenueDiffPercent >= 0)
                  <span class="text-success text-sm font-weight-bolder">+{{ number_format($revenueDiffPercent, 1) }}%</span>
                @else
                  <span class="text-danger text-sm font-weight-bolder">{{ number_format($revenueDiffPercent, 1) }}%</span>
                @endif
                minggu ini
              </p>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
              <i class="fas fa-money-bill-wave text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Pelanggan</p>
              <h5 class="font-weight-bolder">{{ $totalClients }}</h5>
              <p class="mb-0">
                @if($clientsDiffPercent >= 0)
                  <span class="text-success text-sm font-weight-bolder">+{{ number_format($clientsDiffPercent, 1) }}%</span>
                @else
                  <span class="text-danger text-sm font-weight-bolder">{{ number_format($clientsDiffPercent, 1) }}%</span>
                @endif
                dari minggu lalu
              </p>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
              <i class="fas fa-user-friends text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-uppercase font-weight-bold">Produk Aktif</p>
              <h5 class="font-weight-bolder">{{ $activeProductsCount }}</h5>
              <p class="mb-0">
                <span class="text-success text-sm font-weight-bolder">+{{ $newProductsThisWeek }}</span> produk baru minggu ini
              </p>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
              <i class="fas fa-boxes text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection
