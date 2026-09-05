@props(['produk'])
@php
    $gambar = $produk->produkGambars->first();
    $gambarUrl = $gambar ? (str_starts_with($gambar->path_gambar, 'http') ? $gambar->path_gambar : asset('storage/' . ltrim($gambar->path_gambar, '/'))) : null;
    $namaJurusan = [
        'mm' => 'Broadcasting & Perfilman',
        'tei' => 'Teknik Elektronika',
        'tkr' => 'Otomotif',
        'mesin' => 'Mesin',
        'tekstil' => 'Tekstil',
        'dgm' => 'Design Gambar Mesin (DGM)',
        'meka' => 'Mekatronika (Meka)',
    ][$produk->jurusan?->slug] ?? $produk->jurusan?->nama;
@endphp

<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-[var(--color-neutral-200)] bg-white shadow-[var(--shadow-sm)] transition duration-150 hover:-translate-y-0.5 hover:shadow-[var(--shadow-md)]">
    @if ($gambarUrl)
        <img src="{{ $gambarUrl }}" alt="{{ $produk->nama }}" loading="lazy" class="aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-[1.02]">
    @else
        <div class="flex aspect-[4/3] items-center justify-center bg-[var(--color-neutral-100)] text-sm font-bold text-[var(--color-neutral-400)]">Foto produk</div>
    @endif
    <div class="flex flex-1 flex-col p-5">
        @if ($namaJurusan)
            <span class="w-fit rounded-full bg-[var(--color-primary-100)] px-2.5 py-1 text-[11px] font-bold text-[var(--color-primary-600)]">{{ $namaJurusan }}</span>
        @endif
        <h3 class="mt-3 font-display text-lg font-bold text-[var(--color-neutral-900)]">{{ $produk->nama }}</h3>
        <p class="mt-2 line-clamp-2 flex-1 text-sm leading-6 text-[var(--color-neutral-500)]">{{ $produk->deskripsi }}</p>
        <div class="mt-5 flex items-center justify-between gap-3">
            <span class="font-display text-base font-bold text-[var(--color-primary-600)]">{{ $produk->harga_formatted }}</span>
            <a href="{{ route('product.show', $produk->slug) }}" class="focus-ring text-sm font-bold text-[var(--color-primary-600)]">Detail <span aria-hidden="true">→</span></a>
        </div>
    </div>
</article>