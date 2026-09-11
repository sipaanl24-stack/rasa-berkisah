<!-- Sidebar -->
<aside id="sidebar" class="sidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="logo-icon">☕</div>
        <div class="logo-text">
            <h2>Rasa Berkisah</h2>
            <span>Coffee Point</span>
        </div>
    </div>

    <!-- Menu -->
    <div class="sidebar-menu">

        {{-- ==================== ADMIN ==================== --}}
        @if(session('role') === 'admin')

            {{-- Dashboard --}}
            <a href="{{ route('dashboard.index') }}" class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i class="fas fa-house"></i>
                <span>Dashboard</span>
            </a>

            {{-- Persediaan Bahan --}}
            <a href="{{ route('inventory.index') }}" class="menu-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                <span>Persediaan Bahan</span>
            </a>

            {{-- Persetujuan Bahan --}}
            <a href="{{ route('supplier.index') }}" class="menu-item {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
                <i class="fas fa-truck"></i>
                <span>Persetujuan Bahan</span>
            </a>

            {{-- Menu & Harga --}}
            <a href="{{ route('menu.index') }}" class="menu-item {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                <i class="fas fa-utensils"></i>
                <span>Menu & Harga</span>
            </a>

            {{-- Keuangan --}}
            <a href="{{ route('jurnal.index') }}" class="menu-item {{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
                <i class="fas fa-book"></i>
                <span>Jurnal</span>
            </a>

            {{-- Karyawan --}}
            @php
                $employeeOpen = request()->is('karyawan*') ||
                                request()->is('kehadiran*') ||
                                request()->routeIs('shift_karyawan.*');
            @endphp

            <div class="menu-dropdown {{ $employeeOpen ? 'open' : '' }}">

                <div class="menu-item dropdown-toggle">
                    <div class="menu-left">
                        <i class="fas fa-users"></i>
                        <span>Karyawan</span>
                    </div>
                </div>

                <div class="submenu">

                    {{-- Data Karyawan --}}
                    <a href="{{ route('karyawan.index') }}" class="submenu-item {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                        Data Karyawan
                    </a>

                    {{-- Jadwal Kerja --}}
                    <a href="{{ route('shift_karyawan.index') }}" class="submenu-item {{ request()->routeIs('shift_karyawan.*') ? 'active' : '' }}">
                        Jadwal Kerja
                    </a>

                    {{-- Kehadiran --}}
                    <a href="{{ route('kehadiran.index') }}" class="submenu-item {{ request()->routeIs('kehadiran.*') ? 'active' : '' }}">
                        Kehadiran
                    </a>

                </div>
            </div>

        @endif


        {{-- ==================== KASIR ==================== --}}
        @if(session('role') === 'kasir')

            {{-- Transaksi --}}
            <a href="{{ route('transaction.index') }}" class="menu-item {{ request()->routeIs('transaction.index', 'transaction.edit') ? 'active' : '' }}">
                <i class="fas fa-cash-register"></i>
                <span>Transaksi</span>
            </a>

            <!-- {{-- Meja --}}
            <a href="{{ route('pos.index') }}" class="menu-item {{ request()->routeIs('pos.*') ? 'active' : '' }}">
                <i class="fas fa-table"></i>
                <span>Meja</span>
            </a>

            {{-- Ditangguhkan --}}
            <a href="{{ route('transaction.onhold') }}" class="menu-item {{ request()->routeIs('transaction.onhold') ? 'active' : '' }}">
                <i class="fas fa-clock"></i>
                <span>Ditangguhkan</span>
            </a> -->

        @endif


        {{-- ==================== KITCHEN ==================== --}}
        @if(session('role') === 'kitchen')

            {{-- Pesanan --}}
            <a href="{{ route('pesanan.index') }}" class="menu-item {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                <i class="fas fa-kitchen-set"></i>
                <span>Pesanan</span>
            </a>

            {{-- Pengajuan Bahan --}}
            <a href="{{ route('request.index') }}" class="menu-item {{ request()->routeIs('request.*') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i>
                <span>Pengajuan Bahan</span>
            </a>

        @endif

    </div>


<!-- Logout -->
<div class="sidebar-footer">
    <form action="{{ route('logout') }}" method="POST"
          onsubmit="return confirm('Apakah kamu yakin ingin logout?');">
        @csrf

        <button type="submit" class="logout-btn">
            <i class="fas fa-right-from-bracket"></i>
            <span>Logout</span>
        </button>
    </form>
</div>


</aside>


<script>
    document.querySelectorAll('.dropdown-toggle').forEach(item => {
        item.addEventListener('click', function () {
            this.parentElement.classList.toggle('open');
        });
    });
</script>