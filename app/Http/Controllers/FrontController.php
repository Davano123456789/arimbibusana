<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('public.beranda');
    }

    public function produk()
    {
        return view('public.produk');
    }

    public function produkUnggulan()
    {
        return view('public.produkUnggulan');
    }

    public function detailProduk()
    {
        return view('public.detail-produk');
    }

    public function keranjang()
    {
        return view('public.keranjang');
    }

    public function pembayaran()
    {
        return view('public.pembayaran');
    }
}
