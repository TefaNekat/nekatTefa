@props(['jurusan'])

<article class="group flex h-full flex-col rounded-2xl border border-[var(--color-neutral-200)] bg-white p-5 shadow-[var(--shadow-sm)] transition duration-150 hover:-translate-y-0.5 hover:border-[var(--color-primary-500)] hover:shadow-[var(--shadow-md)]">
    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[var(--color-primary-100)] text-sm font-extrabold text-[var(--color-primary-600)]">{{ strtoupper(substr($jurusan->nama, 0, 2)) }}</div>
    <h3 class="mt-5 font-display text-lg font-bold text-[var(--color-neutral-900)]">{{ $jurusan->nama }}</h3>
    <p class="mt-2 flex-1 text-sm leading-6 text-[var(--color-neutral-500)]">{{ $jurusan->deskripsi ?: 'Mengembangkan kompetensi vokasi melalui pengalaman produksi yang nyata.' }}</p>
    <a href="{{ route('product.index', ['jurusan' => $jurusan->slug]) }}" class="focus-ring mt-5 inline-flex items-center gap-2 text-sm font-bold text-[var(--color-primary-600)]">Lihat Produk <span aria-hidden="true">→</span></a>
</article>