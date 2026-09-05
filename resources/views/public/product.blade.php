@extends('layouts.app')

@section('title', 'Product | NEKAT TEFA')

@section('content')
    <section class="border-b border-[var(--color-neutral-200)] bg-white">
        <div class="site-container py-14 sm:py-16"><p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--color-primary-500)]">Innovation & Production</p><h1 class="mt-3 font-display text-4xl font-extrabold tracking-tight text-[var(--color-neutral-900)] sm:text-5xl">Produk Teaching Factory</h1><p class="mt-5 max-w-2xl text-base leading-7 text-[var(--color-neutral-500)]">Jelajahi karya yang lahir dari kompetensi, proses, dan semangat untuk membuat sesuatu yang berguna.</p></div>
    </section>
    <section class="site-container py-12">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('product.index') }}" class="rounded-full px-4 py-2 text-xs font-bold {{ !request('jurusan') ? 'bg-[var(--color-primary-600)] text-white' : 'bg-white text-[var(--color-neutral-700)] ring-1 ring-[var(--color-neutral-200)]' }}">Semua</a>
                @foreach (['rpl' => 'RPL', 'tei' => 'Teknik Elektronika', 'tkr' => 'Otomotif', 'tkj' => 'TJKT', 'mm' => 'Broadcasting & Perfilman', 'mesin' => 'Mesin', 'tekstil' => 'Tekstil', 'dgm' => 'Design Gambar Mesin (DGM)', 'meka' => 'Mekatronika (Meka)'] as $slug => $label)
                    <a href="{{ route('product.index', ['jurusan' => $slug]) }}" class="rounded-full px-4 py-2 text-xs font-bold {{ request('jurusan') === $slug ? 'bg-[var(--color-primary-600)] text-white' : 'bg-white text-[var(--color-neutral-700)] ring-1 ring-[var(--color-neutral-200)]' }}">{{ $label }}</a>
                @endforeach
            </div>
            <form method="GET" action="{{ route('product.index') }}" class="flex w-full max-w-sm gap-2">
                @if (request('jurusan')) <input type="hidden" name="jurusan" value="{{ request('jurusan') }}"> @endif
                <label for="product-search" class="sr-only">Cari produk</label>
                <input id="product-search" name="q" value="{{ request('q') }}" type="search" placeholder="Cari produk..." class="h-10 min-w-0 flex-1 rounded-lg border border-[var(--color-neutral-200)] bg-white px-3 text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                <button class="focus-ring h-10 rounded-lg bg-[var(--color-primary-500)] px-4 text-sm font-bold text-white hover:bg-[var(--color-primary-600)]">Cari</button>
            </form>
        </div>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">
            @forelse ($produks as $produk)
                <x-produk-card :produk="$produk" />
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-[var(--color-neutral-200)] bg-white px-6 py-14 text-center"><h2 class="font-display text-lg font-bold">Tidak ada produk ditemukan.</h2><p class="mt-2 text-sm text-[var(--color-neutral-500)]">Coba gunakan kata kunci lain atau pilih jurusan yang berbeda.</p><a href="{{ route('product.index') }}" class="focus-ring mt-5 inline-flex h-10 items-center rounded-lg bg-[var(--color-primary-500)] px-4 text-sm font-bold text-white">Reset Filter</a></div>
            @endforelse
        </div>
    </section>
@endsection