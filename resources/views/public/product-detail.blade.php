@extends('layouts.app')

@section('title', $produk->nama . ' | NEKAT TEFA')

@section('content')
    <section class="site-container py-10 sm:py-14">
        <nav aria-label="Breadcrumb" class="mb-8 flex flex-wrap items-center gap-2 text-xs text-[var(--color-neutral-500)]"><a href="{{ route('home') }}" class="hover:text-[var(--color-primary-600)]">Home</a><span aria-hidden="true">/</span><a href="{{ route('product.index') }}" class="hover:text-[var(--color-primary-600)]">Product</a><span aria-hidden="true">/</span><span class="text-[var(--color-neutral-900)]">{{ $produk->nama }}</span></nav>
        <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr]">
            <x-produk-galeri :produk="$produk" />
            <div>
                @if ($produk->jurusan)<span class="rounded-full bg-[var(--color-primary-100)] px-3 py-1.5 text-xs font-bold text-[var(--color-primary-600)]">{{ $produk->jurusan->nama }}</span>@endif
                <h1 class="mt-5 font-display text-3xl font-extrabold tracking-tight text-[var(--color-neutral-900)] sm:text-4xl">{{ $produk->nama }}</h1>
                <p class="mt-5 font-display text-2xl font-bold text-[var(--color-primary-600)]">{{ $produk->harga_formatted }}</p>
                <p class="mt-5 text-sm leading-7 text-[var(--color-neutral-700)]">{{ $produk->deskripsi }}</p>
                <form method="POST" action="{{ route('lead.store', $produk) }}" class="mt-7">@csrf<button type="submit" class="focus-ring inline-flex h-11 w-full items-center justify-center rounded-lg bg-[var(--color-accent-500)] px-5 text-sm font-bold text-[var(--color-neutral-900)] transition hover:bg-[var(--color-accent-600)] sm:w-auto">Hubungi Admin <span class="ml-2" aria-hidden="true">→</span></button></form>
                <p class="mt-3 text-xs text-[var(--color-neutral-500)]">Butuh informasi lebih lanjut? Tim admin jurusan siap membantu melalui WhatsApp.</p>
            </div>
        </div>
        <div class="mt-16 grid gap-8 border-t border-[var(--color-neutral-200)] pt-10 md:grid-cols-3">
            @foreach ([['Fungsi', $produk->fungsi], ['Manfaat', $produk->manfaat], ['Fitur & Keunggulan', $produk->fitur_keunggulan]] as [$heading, $content])
                <div><h2 class="font-display text-lg font-bold text-[var(--color-neutral-900)]">{{ $heading }}</h2><p class="mt-3 whitespace-pre-line text-sm leading-7 text-[var(--color-neutral-500)]">{{ $content ?: 'Informasi akan segera diperbarui.' }}</p></div>
            @endforeach
        </div>
    </section>
@endsection