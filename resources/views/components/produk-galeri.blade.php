@props(['produk'])
@php
    $gambarPertama = $produk->produkGambars->first();
    $gambarUrl = $gambarPertama ? (str_starts_with($gambarPertama->path_gambar, 'http') ? $gambarPertama->path_gambar : asset('storage/' . ltrim($gambarPertama->path_gambar, '/'))) : null;
@endphp

<div x-data="{ active: '{{ $gambarUrl }}' }" class="space-y-4">
    <div class="flex aspect-[4/3] items-center justify-center overflow-hidden rounded-2xl border border-[var(--color-neutral-200)] bg-white">
        <template x-if="active">
            <img :src="active" alt="{{ $produk->nama }}" class="h-full w-full object-cover">
        </template>
        <template x-if="!active">
            <div class="text-sm font-semibold text-[var(--color-neutral-400)]">Foto produk belum tersedia</div>
        </template>
    </div>
    @if ($produk->produkGambars->count() > 1)
        <div class="grid grid-cols-5 gap-3">
            @foreach ($produk->produkGambars as $gambar)
                @php $url = str_starts_with($gambar->path_gambar, 'http') ? $gambar->path_gambar : asset('storage/' . ltrim($gambar->path_gambar, '/')); @endphp
                <button type="button" @click="active = '{{ $url }}'" class="focus-ring aspect-square overflow-hidden rounded-lg border-2 border-transparent bg-white transition hover:border-[var(--color-primary-500)]">
                    <img src="{{ $url }}" alt="{{ $produk->nama }} thumbnail {{ $loop->iteration }}" loading="lazy" class="h-full w-full object-cover">
                </button>
            @endforeach
        </div>
    @endif
</div>