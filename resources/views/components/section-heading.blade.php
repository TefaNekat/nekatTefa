@props(['eyebrow' => null, 'title', 'description' => null, 'align' => 'left'])

<div class="{{ $align === 'center' ? 'mx-auto text-center' : '' }} max-w-2xl">
    @if ($eyebrow)
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[var(--color-primary-500)]">{{ $eyebrow }}</p>
    @endif
    <h2 class="mt-2 font-display text-2xl font-bold tracking-tight text-[var(--color-neutral-900)] sm:text-3xl">{{ $title }}</h2>
    @if ($description)
        <p class="mt-3 text-sm leading-7 text-[var(--color-neutral-500)]">{{ $description }}</p>
    @endif
</div>