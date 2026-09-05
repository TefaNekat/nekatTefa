<header class="sticky top-0 z-50 border-b border-[var(--color-neutral-200)] bg-white/95 backdrop-blur">
    <nav class="site-container flex h-16 items-center justify-between" aria-label="Navigasi utama">
        <a href="{{ route('home') }}" class="font-display text-lg font-extrabold tracking-tight text-[var(--color-primary-600)] focus-ring sm:text-xl">
            NEKAT <span class="text-[var(--color-accent-600)]">TEFA</span>
        </a>

        <div class="hidden items-center gap-7 md:flex">
            @foreach ([['home', 'Home'], ['about', 'About'], ['product.index', 'Product'], ['contact', 'Contact Us']] as [$route, $label])
                <a href="{{ route($route) }}" class="focus-ring relative py-5 text-sm font-semibold transition duration-150 {{ request()->routeIs($route === 'product.index' ? 'product.*' : $route) ? 'text-[var(--color-primary-600)] after:absolute after:inset-x-0 after:bottom-0 after:h-0.5 after:bg-[var(--color-accent-500)]' : 'text-[var(--color-neutral-700)] hover:text-[var(--color-primary-600)]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-3 md:flex">
            <form action="{{ route('product.index') }}" method="GET" class="relative">
                <label for="nav-search" class="sr-only">Cari produk</label>
                <input id="nav-search" name="q" type="search" value="{{ request('q') }}" placeholder="Cari produk" class="h-9 w-36 rounded-full border border-[var(--color-neutral-200)] bg-[var(--color-neutral-50)] px-4 pr-9 text-xs focus:border-[var(--color-primary-500)] focus:ring-[var(--color-primary-500)]">
                <span class="pointer-events-none absolute right-3 top-2.5 text-[var(--color-neutral-400)]" aria-hidden="true">⌕</span>
            </form>
            @auth
                <a href="{{ route('dashboard') }}" class="focus-ring inline-flex h-9 items-center rounded-lg bg-[var(--color-primary-500)] px-4 text-xs font-bold text-white transition hover:bg-[var(--color-primary-600)]">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="focus-ring inline-flex h-9 items-center rounded-lg bg-[var(--color-primary-500)] px-4 text-xs font-bold text-white transition hover:bg-[var(--color-primary-600)]">Login</a>
            @endauth
        </div>

        <button type="button" data-mobile-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="Buka menu navigasi" class="focus-ring inline-flex h-10 w-10 items-center justify-center rounded-lg border border-[var(--color-neutral-200)] text-lg text-[var(--color-primary-600)] md:hidden">
            <span data-menu-open aria-hidden="true">☰</span>
            <span data-menu-close class="hidden" aria-hidden="true">×</span>
        </button>
    </nav>

    <div id="mobile-menu" class="hidden border-t border-[var(--color-neutral-200)] bg-white md:hidden">
        <div class="site-container space-y-1 py-4">
            <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-[var(--color-neutral-700)]">Home</a>
            <a href="{{ route('about') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-[var(--color-neutral-700)]">About</a>
            <a href="{{ route('product.index') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-[var(--color-neutral-700)]">Product</a>
            <a href="{{ route('contact') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-[var(--color-neutral-700)]">Contact Us</a>
            @auth
                <a href="{{ route('dashboard') }}" class="mt-2 block rounded-lg bg-[var(--color-primary-500)] px-3 py-2 text-center text-sm font-bold text-white">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="mt-2 block rounded-lg bg-[var(--color-primary-500)] px-3 py-2 text-center text-sm font-bold text-white">Login</a>
            @endauth
        </div>
    </div>
</header>