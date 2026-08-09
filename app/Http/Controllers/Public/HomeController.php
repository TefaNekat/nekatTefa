<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $jurusans = Jurusan::all();

        return view('public.home', compact('jurusans'));
    }
}
