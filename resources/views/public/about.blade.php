@extends('layouts.app')

@section('title', 'About | NEKAT TEFA')

@section('content')
    <section class="border-b border-[var(--color-neutral-200)] bg-white">
        <div class="site-container py-16 sm:py-20"><p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--color-primary-500)]">Our Departments</p><h1 class="mt-3 max-w-2xl font-display text-4xl font-extrabold tracking-tight text-[var(--color-neutral-900)] sm:text-5xl">Tentang jurusan kami</h1><p class="mt-5 max-w-2xl text-base leading-7 text-[var(--color-neutral-500)]">Menciptakan sinergi antara kurikulum akademik dengan standar industri melalui Teaching Factory.</p></div>
    </section>
    <section class="site-container py-20">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($jurusans as $jurusan)
                <x-department-card :jurusan="$jurusan" />
            @empty
                <p class="text-sm text-[var(--color-neutral-500)]">Data jurusan belum tersedia.</p>
            @endforelse
        </div>
    </section>
    <div class="pb-20"><x-cta-banner /></div>
@endsection