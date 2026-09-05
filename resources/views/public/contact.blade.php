@extends('layouts.app')

@section('title', 'Contact | NEKAT TEFA')

@section('content')
    <section class="border-b border-[var(--color-neutral-200)] bg-white"><div class="site-container py-16 sm:py-20"><p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--color-primary-500)]">Get in touch</p><h1 class="mt-3 font-display text-4xl font-extrabold tracking-tight text-[var(--color-neutral-900)] sm:text-5xl">Mari mulai percakapan.</h1><p class="mt-5 max-w-xl text-base leading-7 text-[var(--color-neutral-500)]">Punya pertanyaan tentang produk, jurusan, atau peluang kolaborasi? Kami siap mendengar.</p></div></section>
    <section class="site-container py-14 sm:py-20">
        <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr]">
            <div class="rounded-2xl border border-[var(--color-neutral-200)] bg-white p-6 shadow-[var(--shadow-sm)] sm:p-8">
                <h2 class="font-display text-xl font-bold">Kirim pesan</h2>
                <form method="GET" action="{{ route('contact') }}" class="mt-7 space-y-5">
                    <div class="grid gap-5 sm:grid-cols-2"><div><label for="name" class="text-sm font-semibold">Nama</label><input id="name" name="name" type="text" class="mt-2 h-10 w-full rounded-lg border border-[var(--color-neutral-200)] px-3 text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"></div><div><label for="email" class="text-sm font-semibold">Email</label><input id="email" name="email" type="email" class="mt-2 h-10 w-full rounded-lg border border-[var(--color-neutral-200)] px-3 text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"></div></div>
                    <div><label for="subject" class="text-sm font-semibold">Subject</label><input id="subject" name="subject" type="text" class="mt-2 h-10 w-full rounded-lg border border-[var(--color-neutral-200)] px-3 text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"></div>
                    <div><label for="message" class="text-sm font-semibold">Pesan</label><textarea id="message" name="message" rows="5" class="mt-2 w-full rounded-lg border border-[var(--color-neutral-200)] px-3 py-2 text-sm focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]"></textarea></div>
                    <button type="submit" class="focus-ring inline-flex h-11 items-center rounded-lg bg-[var(--color-primary-500)] px-5 text-sm font-bold text-white hover:bg-[var(--color-primary-600)]">Kirim Pesan <span class="ml-2" aria-hidden="true">→</span></button>
                </form>
            </div>
            <div class="space-y-7">
                @if (isset($page) && $page)<div class="prose-tefa rounded-2xl border border-[var(--color-neutral-200)] bg-white p-6 shadow-[var(--shadow-sm)] sm:p-8"><h2>{{ $page->judul }}</h2>{!! $page->konten !!}</div>@endif
                <div><h2 class="font-display text-xl font-bold">Alamat kami</h2><p class="mt-3 text-sm leading-7 text-[var(--color-neutral-500)]">SMK Negeri 1 Katapang<br>Jl. Teknologi Pendidikan<br>Bandung, Jawa Barat</p></div>
                <div><h2 class="font-display text-xl font-bold">Hubungi kami</h2><div class="mt-3 space-y-2 text-sm text-[var(--color-neutral-500)]"><a href="mailto:info@nekatefa.com" class="block text-[var(--color-primary-600)] hover:underline">info@nekatefa.com</a><a href="tel:+62221234567" class="block text-[var(--color-primary-600)] hover:underline">+62 22 1234 567</a></div></div>
            </div>
        </div>
    </section>
@endsection