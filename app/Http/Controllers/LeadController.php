<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Produk;
use App\Services\WhatsappMessageBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function store(Produk $produk, WhatsappMessageBuilder $waBuilder): RedirectResponse
    {
        $user = Auth::guard('web')->user();

        Lead::create([
            'user_id' => $user->id,
            'produk_id' => $produk->id,
            'jurusan_id' => $produk->jurusan_id,
            'status' => 'baru_masuk',
        ]);

        $link = $waBuilder->generateLink($user, $produk);

        return redirect()->away($link);
    }
}