@extends('layouts.app')

@section('title', 'NEKAT TEFA | Teaching Factory Katapang')

@section('content')
    <section class="overflow-hidden bg-[var(--color-primary-600)]">
        <div class="site-container grid min-h-[560px] items-center gap-12 py-16 lg:grid-cols-[1.05fr_0.95fr] lg:py-20">
            <div class="max-w-xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-[var(--color-accent-500)]">Teaching Factory Katapang</p>
                <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl">Belajar dengan standar industri. Berkarya untuk dunia nyata.</h1>
                <p class="mt-6 max-w-lg text-base leading-7 text-blue-100">NEKAT TEFA menghadirkan pengalaman produksi profesional di lingkungan sekolah, tempat kompetensi tumbuh melalui karya yang bisa digunakan.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('product.index') }}" class="focus-ring inline-flex h-11 items-center rounded-lg bg-[var(--color-accent-500)] px-5 text-sm font-bold text-[var(--color-neutral-900)] transition hover:bg-[var(--color-accent-600)]">Lihat Produk <span class="ml-2" aria-hidden="true">→</span></a>
                    <a href="{{ route('about') }}" class="focus-ring inline-flex h-11 items-center rounded-lg border border-blue-200/60 px-5 text-sm font-bold text-white transition hover:bg-white/10">Kenali TEFA</a>
                </div>
                <div class="mt-10 flex items-center gap-3 text-sm text-blue-100"><span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 font-bold text-[var(--color-accent-500)]">✓</span> Industry-minded learning environment</div>
            </div>
            <div class="relative">
                <div class="absolute -inset-4 rounded-[2rem] border border-white/10"></div>
                <div class="relative flex aspect-[4/3] items-end overflow-hidden rounded-2xl bg-[linear-gradient(135deg,#2f68d1,#163b89)] p-7 shadow-[var(--shadow-lg)]">
                    <div class="absolute right-8 top-8 h-28 w-28 rounded-full border-[14px] border-[var(--color-accent-500)]/80"></div>
                    <div class="relative max-w-xs"><p class="text-xs font-bold uppercase tracking-[0.18em] text-blue-100">School meets industry</p><p class="mt-3 font-display text-2xl font-bold text-white">Dari ruang praktik menuju karya yang bernilai.</p></div>
                </div>
            </div>
        </div>
    </section>

    <section class="site-container py-20">
        <x-section-heading eyebrow="Bidang Keahlian" title="Satu ekosistem, banyak kemungkinan." description="Temukan kompetensi dan karya dari jurusan-jurusan yang bergerak bersama dalam Teaching Factory." />
        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($jurusans->reject(fn ($jurusan) => in_array($jurusan->slug, ['akuntansi', 'boga', 'tataboga'], true)) as $jurusan)
                <x-department-card :jurusan="$jurusan" />
            @empty
                <p class="text-sm text-[var(--color-neutral-500)]">Data jurusan belum tersedia.</p>
            @endforelse
        </div>
    </section>

    <section class="border-y border-[var(--color-neutral-200)] bg-white">
        <div class="site-container grid items-center gap-12 py-20 lg:grid-cols-[0.9fr_1.1fr]">
            <div class="flex aspect-[4/3] items-end rounded-2xl bg-[var(--color-primary-100)] p-8">
                <div><p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--color-primary-500)]">Apa itu Teaching Factory?</p><p class="mt-4 font-display text-3xl font-bold leading-tight text-[var(--color-primary-700)]">Belajar dari masalah nyata, menghasilkan solusi nyata.</p></div>
            </div>
            <div>
                <p class="text-sm leading-7 text-[var(--color-neutral-700)]">Teaching Factory membawa ritme, standar, dan cara kerja industri ke dalam pembelajaran. Siswa berlatih melalui proses yang relevan, terukur, dan berorientasi pada kualitas.</p>
                <div class="mt-8 space-y-5">
                    @foreach ([['Belajar Nyata', 'Simulasi lingkungan kerja profesional di sekolah.'], ['Produk Berkualitas', 'Karya lahir dari proses dan standar yang terarah.'], ['Siap Kerja', 'Kompetensi dibangun melalui pengalaman yang relevan.']] as [$title, $text])
                        <div class="flex gap-4"><div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[var(--color-accent-100)] font-bold text-[var(--color-accent-600)]">✓</div><div><h3 class="font-display font-bold text-[var(--color-neutral-900)]">{{ $title }}</h3><p class="mt-1 text-sm leading-6 text-[var(--color-neutral-500)]">{{ $text }}</p></div></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @if (isset($page) && $page)
        <section class="site-container py-20"><div class="prose-tefa"><h2>{{ $page->judul }}</h2>{!! $page->konten !!}</div></section>
    @endif

    <div class="py-20"><x-cta-banner /></div>
@endsection