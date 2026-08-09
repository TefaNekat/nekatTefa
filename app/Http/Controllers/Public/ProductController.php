<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Produk::where('status', 'published')->with('jurusan');

        if($request->filled('jurusan')){
            $query->whereHas('jurusan', function ($q) use ($request){
                $q->where('slug', $request->jurusan);
            });
        }

        if($request->filled('q')){
            $query->where('nama', 'like', '%' . $request->q . '%');
    }
        $produks = $query->latest()->get();

        return view('public.product', compact('produks'));
    }
}
