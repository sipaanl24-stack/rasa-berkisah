<nav class="navbar">
    <div class="navbar-left">
        <div class="navbar-toggle-area">
            <button id="toggleSidebar" class="toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        @php
            $titles = [
                'dashboard.index'      => 'Dashboard',
                'inventory.index'      => 'Inventory',
                'menu.index'           => 'Menu',
                'karyawan.index'       => 'Karyawan',
                'request.index'        => 'Permintaan Barang',
                'supplier.index'       => 'Supplier',
                'transaction.index'    => 'Kasir',
                'transaction.edit'     => 'Kasir',
                'transaction.onhold'   => 'On Hold',
                'pesanan.index'        => 'Pesanan',
                'shift_karyawan.index' => 'Shift Karyawan',
                'kehadiran.index'      => 'Kehadiran',
                'jurnal.index'         => 'Jurnal',
            ];
        @endphp

        <div class="breadcrumb">
            <span>Rasa Berkisah</span>
            <span class="divider">/</span>
            <strong>{{ $titles[Route::currentRouteName()] ?? 'Dashboard' }}</strong>
        </div>
    </div>

    <div class="navbar-right">
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search..." >
        </div>
        <button id="themeToggle" class="theme-btn">
            <i class="fas fa-moon"></i>
        </button>
        <div class="notification">
            <button class="icon-btn notification-btn" id="notifBtn">
                <i class="fas fa-bell"></i>
                @if($notif > 0)
                    <span class="badge">
                        {{ $notif }}
                    </span>
                @endif
            </button>
        <div class="notification-dropdown" id="notifDropdown">
            <h4>Notifikasi</h4>
        @forelse($notifikasi as $n)
        <div class="notification-item">
            <div class="notif-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="notif-content">
                <div class="notif-header">
                    <h5>{{ $n->nama_bahan }}</h5>
                    <span class="notif-time">
                        Baru
                    </span>
                </div>
                <p>
                    Permintaan baru dengan kode
                    <strong>{{ $n->kode_request }}</strong>
                    telah dibuat oleh bagian Kitchen.
                </p>
            </div>
        </div>
        @empty

        <div class="notification-empty">
            <i class="fas fa-bell-slash"></i>
            <p>Tidak ada notifikasi baru.</p>
        </div>
        @endforelse
            </div>
        </div>
        <div class="user-profile">
            <img src="https://ui-avatars.com/api/?name=Admin&background=f6c453&color=111" alt="User"  >
            <div class="user-info">
                <strong>Admin</strong>
                <small>Administrator</small>
            </div>
            <i class="fas fa-chevron-down"></i>
        </div>
    </div>
</nav>