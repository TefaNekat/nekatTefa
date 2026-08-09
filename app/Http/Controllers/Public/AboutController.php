<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        $jurusans = Jurusan::all();

        return view('public.about', compact ('jurusans'));
    }
}
