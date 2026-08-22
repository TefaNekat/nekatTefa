<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Page;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $jurusans = Jurusan::all();
        $page = Page::where('slug', 'home')->first();

        return view('public.home', compact('jurusans', 'page'));
    }
}