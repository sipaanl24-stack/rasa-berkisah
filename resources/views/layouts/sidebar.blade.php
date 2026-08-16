<!-- Sidebar -->
<aside id="sidebar" class="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="logo-icon">
            ☕
        </div>
        <div class="logo-text">
            <h2>Rasa Berkisah</h2>
            <span>Coffee Point</span>
        </div>
    </div>

    <!-- Menu -->
    <div class="sidebar-menu">
    <a href="{{ route('dashboard.index') }}"
        class="menu-item {{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
        <i class="fas fa-house"></i>
        <span>Dashboard</span>
    </a>

        <a href="/inventory"
            class="menu-item {{ request()->is('inventory') ? 'active' : '' }}">
            <i class="fas fa-boxes"></i>
            <span>Inventory</span>
        </a>

        <a href="/suplai"
            class="menu-item {{ request()->is('suplai') ? 'active' : '' }}">
            <i class="fas fa-truck"></i>
            <span>Supplier</span>
        </a>

        <a href="/menu"
            class="menu-item {{ request()->is('menu') ? 'active' : '' }}">
            <i class="fas fa-utensils"></i>
            <span>Menu Makanan</span>
        </a>

        <a href="{{ route('jurnal.index') }}"
        class="menu-item {{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i>
            <span>Jurnal Umum</span>
        </a>

        @php
            $employeeOpen =
                request()->is('karyawan*') ||
                request()->is('kehadiran*') ||
                request()->routeIs('shift_karyawan.*');
        @endphp

        <div class="menu-dropdown {{ $employeeOpen ? 'open' : '' }}">
            <div class="menu-item dropdown-toggle">
                <div class="menu-left">
                    <i class="fas fa-users"></i>
                    <span>Employee</span>
                </div>
            </div>
            <div class="submenu">
                <a href="/karyawan"
                    class="submenu-item {{ request()->is('karyawan*') ? 'active' : '' }}">
                    Karyawan
                </a>

                <a href="{{ route('shift_karyawan.index') }}"
                    class="submenu-item {{ request()->routeIs('shift_karyawan.*') ? 'active' : '' }}">
                    Shift Karyawan
                </a>

                <a href="/kehadiran"
                    class="submenu-item {{ request()->is('kehadiran*') ? 'active' : '' }}">
                    Kehadiran
                </a>
            </div>
        </div>

        <a href="{{ route('transaction.index') }}"
            class="menu-item {{
                request()->routeIs('transaction.index') ||
                request()->routeIs('transaction.edit')
                    ? 'active'
                    : ''
            }}">
            <i class="fas fa-cash-register"></i>
            <span>Transaction</span>
        </a>

        <a href="{{ route('pos.index') }}"
            class="menu-item {{
                request()->routeIs('pos.*')
                    ? 'active'
                    : ''
            }}">
            <i class="fas fa-table"></i>
            <span>Meja</span>
        </a>

        <a href="{{ route('transaction.onhold') }}"
            class="menu-item {{
                request()->routeIs('transaction.onhold')
                    ? 'active'
                    : ''
            }}">
            <i class="fas fa-clock"></i>
            <span>On Hold</span>
        </a>

        <a href="/request"
            class="menu-item {{ request()->is('request') ? 'active' : '' }}">
            <i class="fas fa-file-signature"></i>
            <span>Request</span>
        </a>

        <a href="{{ route('pesanan.index') }}"
            class="menu-item {{ request()->is('pesanan') ? 'active' : '' }}">
            <i class="fas fa-kitchen-set"></i>
            <span>Pesanan</span>
        </a>
    </div>

    <!-- Logout -->
    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn">
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