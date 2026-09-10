<aside class="sidebar">
    <div class="sidebar-top">
        <div class="sidebar-logo">
            <div class="sidebar-logo-mark">PW</div>
            <div class="sidebar-logo-text">
                <h3>Pendataan Penduduk</h3>
                <span>Data Warga</span>
            </div>
        </div>

        <nav class="sidebar-menu" aria-label="Main navigation">
            <a href="{{ url('/') }}" class="sidebar-item {{ request()->is('/') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V10Z"/><path d="M9 21v-6h6v6"/>
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('citizens.index') }}" class="sidebar-item {{ request()->routeIs('citizens.index') && !request()->is('/') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>Data Penduduk</span>
            </a>

            <a href="{{ route('citizens.create') }}" class="sidebar-item {{ request()->routeIs('citizens.create') ? 'active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/><path d="M12 8v8M8 12h8"/>
                </svg>
                <span>Tambah Penduduk</span>
            </a>
        </nav>
    </div>
</aside>
