@extends('layouts.masterPublic')
@section('title', 'Pembayaran Berhasil — Arimbi Queen')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-16 text-center">
    <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-green-100 text-green-500 mb-6 shadow-sm">
        <i class="fa-solid fa-check text-5xl"></i>
    </div>
    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4 font-serif">Pembayaran Berhasil!</h1>
    <p class="text-gray-500 mb-8 mx-auto leading-relaxed">Terima kasih atas pesanan Anda. Kami telah menerima pembayaran sebesar <strong class="text-accent">Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> dengan nomor pesanan <strong>{{ $order->order_number }}</strong>. Salinan invoice pesanan juga telah dikirimkan ke email Anda.</p>
    
    <div class="bg-gray-50 rounded-2xl p-6 text-left mb-8 border border-gray-100 shadow-sm text-sm">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-400 font-medium text-xs uppercase tracking-wider mb-1">Penerima</p>
                <p class="font-bold text-gray-800">{{ $order->customer_name }}</p>
                <p class="text-gray-600 mt-0.5">{{ $order->customer_phone }}</p>
            </div>
            <div>
                <p class="text-gray-400 font-medium text-xs uppercase tracking-wider mb-1">Kurir</p>
                <p class="font-bold text-gray-800 uppercase">{{ $order->courier }}</p>
            </div>
            <div class="col-span-2 mt-2">
                <p class="text-gray-400 font-medium text-xs uppercase tracking-wider mb-1">Alamat Pengiriman</p>
                <p class="text-gray-800 leading-relaxed">{{ $order->customer_address }}, {{ $order->city_name }}, {{ $order->province_name }}</p>
            </div>
        </div>
    </div>
    
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ url('/pesanan') }}" class="px-8 py-3 bg-accent hover:brightness-110 text-white rounded-full font-medium transition shadow-lg shadow-accent/20">Lihat Pesanan Saya</a>
        <a href="{{ url('/') }}" class="px-8 py-3 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-full font-medium transition shadow-sm">Kembali ke Beranda</a>
    </div>
</div>
@endsection
