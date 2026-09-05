<footer class="mt-20 border-t border-[var(--color-neutral-200)] bg-white">
    <div class="site-container grid gap-10 py-12 sm:grid-cols-2 lg:grid-cols-4">
        <div class="sm:col-span-2 lg:col-span-1">
            <a href="{{ route('home') }}" class="font-display text-xl font-extrabold text-[var(--color-primary-600)]">NEKAT <span class="text-[var(--color-accent-600)]">TEFA</span></a>
            <p class="mt-4 max-w-xs text-sm leading-6 text-[var(--color-neutral-500)]">Teaching Factory Katapang yang menghubungkan pembelajaran vokasi dengan standar kerja profesional.</p>
        </div>
        <div>
            <h2 class="text-sm font-bold text-[var(--color-neutral-900)]">Quick Links</h2>
            <div class="mt-4 space-y-3 text-sm text-[var(--color-neutral-500)]">
                <a href="{{ route('home') }}" class="block hover:text-[var(--color-primary-600)]">Home</a>
                <a href="{{ route('about') }}" class="block hover:text-[var(--color-primary-600)]">About</a>
                <a href="{{ route('product.index') }}" class="block hover:text-[var(--color-primary-600)]">Product</a>
                <a href="{{ route('contact') }}" class="block hover:text-[var(--color-primary-600)]">Contact Us</a>
            </div>
        </div>
        <div>
            <h2 class="text-sm font-bold text-[var(--color-neutral-900)]">Support</h2>
            <div class="mt-4 space-y-3 text-sm text-[var(--color-neutral-500)]">
                <a href="{{ route('contact') }}" class="block hover:text-[var(--color-primary-600)]">Contact</a>
                <a href="{{ route('login') }}" class="block hover:text-[var(--color-primary-600)]">Customer Login</a>
            </div>
        </div>
        <div>
            <h2 class="text-sm font-bold text-[var(--color-neutral-900)]">Contact Info</h2>
            <p class="mt-4 text-sm leading-6 text-[var(--color-neutral-500)]">SMK Negeri 1 Katapang<br>Bandung, Jawa Barat</p>
            <a href="mailto:info@nekatefa.com" class="mt-3 block text-sm text-[var(--color-primary-600)] hover:underline">info@nekatefa.com</a>
        </div>
    </div>
    <div class="border-t border-[var(--color-neutral-200)] py-5">
        <div class="site-container text-xs text-[var(--color-neutral-500)]">© {{ date('Y') }} NEKAT TEFA Teaching Factory. All rights reserved.</div>
    </div>
</footer>