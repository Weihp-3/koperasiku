<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $products = Product::where('stock', '>', 0)->get();
        $user = Auth::user();
        return view('dashboard.siswa', compact('products', 'user'));
    }

    public function pembelian()
    {
        $products = Product::where('stock', '>', 0)->paginate(12);
        return view('siswa.pembelian', compact('products'));
    }

}
