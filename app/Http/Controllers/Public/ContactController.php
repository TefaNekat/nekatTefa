<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $page = Page::where('slug', 'contact')->first();

        return view('public.contact', compact('page'));
    }
}