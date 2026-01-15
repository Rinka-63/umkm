<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>InvenTech - Dashboard Utama</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
        
        <style>
            :root { 
                --primary-color: #0d6efd; 
                --glass-bg: rgba(255, 255, 255, 0.94); 
            }
            
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                            url('https://i.imgur.com/1mw6KSb.jpeg') no-repeat center center fixed;
                background-size: cover; 
                min-height: 100vh; 
                display: flex; 
                flex-direction: column;
            }

            .wrapper { 
                flex: 1 0 auto; 
                padding: 25px; 
                width: 100%; }

            .navbar-card {
                background: var(--glass-bg); 
                backdrop-filter: blur(15px); 
                border-radius: 16px;
                padding: 12px 20px; 
                display: flex; 
                align-items: center; 
                justify-content: space-between;
                box-shadow: 0 8px 32px rgba(0,0,0,0.2); 
                border: 1px solid rgba(255,255,255,0.3);
            }
            .nav-link-item {
                color: #4b5563; 
                text-decoration: none; 
                padding: 10px 18px; 
                border-radius: 12px;
                font-weight: 600; 
                display: inline-flex; 
                align-items: center; 
                gap: 8px; 
                transition: 0.3s;
            }
            .nav-link-item:hover {
                background: rgba(13, 110, 253, 0.1);
                color: var(--primary-color);
            }
            .nav-link-item.active { 
                background: var(--primary-color); 
                color: white !important; 
                box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
            }


            .stat-card { 
                background: white; 
                border-radius: 20px; 
                padding: 25px; 
                border: none; 
                height: 100%; 
                transition: 0.3s; 
                box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            }
            .stat-card:hover { 
                transform: translateY(-5px); 
            }
            .icon-box { 
                width: 50px; 
                height: 50px; 
                border-radius: 14px; 
                display: flex; 
                align-items: center; 
                justify-content: center; 
                font-size: 1.3rem; 
            }

            .hover-card { transition: all 0.3s ease; }
            .hover-card:hover { transform: translateY(-5px); border: 1px solid #0d6efd !important; }

            .content-card { 
                background: white; 
                border-radius: 20px; 
                padding: 30px; 
                border: none; 
                box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            }

            .table thead th {
                background-color: #f8f9fa;
                color: #6c757d;
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 1px;
                padding: 15px;
                border: none;
            }

            .table tbody td { padding: 18px 15px; border-bottom: 1px solid #f1f1f1; }

            .notif-pulse {
                position: absolute; 
                top: 0; right: 0; 
                height: 10px; 
                width: 10px;
                background-color: #ef4444; 
                border-radius: 50%; 
                border: 2px solid white;
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
                70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
                100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
            }

            footer {
                background: rgba(0, 0, 0, 0.3); 
                color: white; 
                padding: 20px 0; 
                margin-top: 40px; 
                text-align: center; 
            }

            @media print {
                .btn, header, .navbar, .d-print-none {
                    display: none !important;
                }
                .main-content, main, .container-fluid, .content-wrapper {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100% !important;
                    position: absolute;
                    left: 0;
                    top: 0;
                }
                .tab-pane {
                    display: none !important;
                }
                .tab-pane.active {
                    display: block !important;
                }
                .table-bordered th, .table-bordered td {
                    border: 1px solid #000 !important;
                }
                .stat-card {
                    box-shadow: none !important;
                    border: none !important;
                }
            }
        </style>
    </head>
    <body>

        <div class="wrapper">

            <!-- Header -->
            <header class="d-flex justify-content-between align-items-center mb-4 px-2 text-white">
                <div class="d-flex align-items-center gap-3">
                    <i class="fa-solid fa-boxes-stacked fa-2x bg-primary p-2 rounded-3 text-white"></i>
                    <div>
                        <h3 class="fw-bold m-0 text-white">InvenTech</h3>
                        <small class="opacity-75">Sistem Inventaris Elektronika</small>
                    </div>
                </div>
                <div class="text-end d-none d-md-block">
                    <div id="clock" class="fw-bold fs-5"></div>
                    <div class="small opacity-75">{{ date('l, d F Y') }}</div>
                </div>
            </header>

            <!-- Navbar -->
            <nav class="navbar-card mb-4">
                <div class="d-flex gap-1">
                    <a href="{{ route('admin.beranda') }}" class="nav-link-item {{ request()->routeIs('admin.beranda') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i> Beranda
                    </a>
                    <a href="{{ route('admin.barang') }}" class="nav-link-item {{ request()->routeIs('admin.barang*') ? 'active' : '' }}">
                        <i class="fa-solid fa-box"></i> Barang
                    </a>
                    <a href="{{ route('admin.supplier') }}" class="nav-link-item {{ request()->routeIs('admin.supplier*') ? 'active' : '' }}">
                        <i class="fa-solid fa-truck"></i> Supplier
                    </a>
                    <a href="{{ route('admin.riwayat') }}" class="nav-link-item {{ request()->routeIs('admin.riwayat*') ? 'active' : '' }}">
                        <i class="fa-solid fa-money-bill-wave"></i> Transaksi
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="nav-link-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                        <i class="fa-solid fa-file-invoice"></i> Laporan
                    </a>
                </div>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <div class="position-relative cursor-pointer" 
                            id="bellIcon" 
                            data-bs-toggle="dropdown" 
                            onclick="hilangkanAngka()" 
                            style="cursor: pointer;">
                            <i class="fa-solid fa-bell fs-4 text-secondary"></i>
                            @if($notif_count > 0)
                                <span id="badge-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    {{ $notif_count }}
                                </span>
                            @endif
                        </div>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-0" style="width: 320px; border-radius: 12px;">
                            <li class="bg-primary p-3 rounded-top text-white">
                                <h6 class="mb-0">Pemberitahuan Stok</h6>
                            </li>
                            <div style="max-height: 300px; overflow-y: auto;">
                                @forelse($notif_list as $n)
                                    <li class="p-3 border-bottom">
                                        {{-- Pastikan menggunakan $n->barang->nama_barang --}}
                                        <div class="fw-bold small text-dark">
                                            {{ $n->barang->nama_barang ?? 'Barang Tidak Ditemukan' }}
                                        </div>
                                        <div class="text-muted small">
                                            Stok tersisa: <span class="text-danger fw-bold">{{ $n->stok_sekarang }}</span>
                                        </div>
                                        <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small>
                                    </li>
                                @empty
                                    <li class="p-4 text-center text-muted small">Semua stok aman</li>
                                @endforelse
                            </div>
                        </ul>
                    </div>



                    <div class="ps-3 border-start d-flex align-items-center gap-3">
                        <div class="text-end d-none d-sm-block">
                            <div class="fw-bold small text-dark">{{ auth()->user()->username }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">{{ strtoupper(auth()->user()->role) }}</div>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger border-0 rounded-circle p-2" title="Logout">
                                <i class="fa-solid fa-power-off"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <main>

                <!-- Beranda -->
                @if(request()->is('admin/beranda'))
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <div class="stat-card d-flex justify-content-between">
                                <div><p class="text-muted small fw-bold mb-1">DATA BARANG</p><h3 class="fw-bold m-0">{{ $total_barang ?? 0 }}</h3></div>
                                <div class="icon-box bg-primary-subtle text-primary"><i class="fa-solid fa-laptop"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card d-flex justify-content-between">
                                <div><p class="text-muted small fw-bold mb-1">TOTAL SUPPLIER</p><h3 class="fw-bold m-0">{{ $total_supplier ?? 0 }}</h3></div>
                                <div class="icon-box bg-success-subtle text-success"><i class="fa-solid fa-truck"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card d-flex justify-content-between">
                                <div><p class="text-muted small fw-bold mb-1">VOLUME TERJUAL</p><h3 class="fw-bold m-0 text-info">{{ $total_terjual ?? 0 }}</h3></div>
                                <div class="icon-box bg-info-subtle text-info"><i class="fa-solid fa-cart-shopping"></i></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-card d-flex justify-content-between border-start border-4 border-danger">
                                <div><p class="text-muted small fw-bold mb-1">STOK KRITIS</p><h3 class="fw-bold m-0 text-danger">{{ $rusak ?? 0 }}</h3></div>
                                <div class="icon-box bg-danger-subtle text-danger"><i class="fa-solid fa-triangle-exclamation"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="stat-card">
                                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-chart-column text-primary"></i> Stok Barang Terbanyak (Top 5)
                                </h5>
                                <div style="height: 300px;"><canvas id="chartStok"></canvas></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="stat-card text-center">
                                <h5 class="fw-bold mb-4">Status Persediaan</h5>
                                <div style="height: 250px;"><canvas id="chartKondisi"></canvas></div>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Barang -->
                @if(request()->is('admin/barang*'))
                    
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary-subtle p-3 rounded-circle me-3 text-primary">
                                        <i class="fa-solid fa-box-archive fs-4"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold text-dark mb-0">
                                            {{ request('supplier_id') ? ($data_barang->first()?->supplier?->nama_supplier ?? 'Detail Barang') : 'Pilih Supplier' }}
                                        </h4>
                                        <p class="text-muted small mb-0">Pantau stok berdasarkan sumber pengiriman barang</p>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    @if(request('supplier_id'))
                                    @else
                                        {{-- Tombol Tambah Barang HANYA muncul di halaman pertama (Pilih Supplier) --}}
                                        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                            <i class="fa-solid fa-plus me-2"></i>Tambah Barang
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div style="height: 4px; background: linear-gradient(to right, #0d6efd, #6610f2);"></div>
                    </div>
                

                    {{-- KONDISI 1: TAMPILAN KOTAK SUPPLIER (Jika belum pilih supplier) --}}
                    @if(!request('supplier_id'))
                        <div class="row g-3">
                            @foreach($suppliers as $s)
                            <div class="col-md-4">
                                <a href="{{ url('admin/barang?supplier_id='.$s->id) }}" class="text-decoration-none">
                                    <div class="card border-0 shadow-sm h-100 hover-card p-3" style="border-radius: 15px;">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary-subtle p-3 rounded-4 me-3 text-primary">
                                                <i class="fa-solid fa-truck-ramp-box fs-3"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0 text-dark">{{ $s->nama_supplier }}</h5>
                                                <span class="badge bg-light text-dark border mt-1">
                                                    {{ $s->barangs_count }} Jenis Barang
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>

                    {{-- KONDISI 2: TAMPILAN TABEL BARANG (Jika sudah pilih supplier) --}}
                    @else
                    <div class="mb-3">
                        <a href="{{ url('admin/barang') }}" class="btn btn-sm btn-primary border rounded-pill px-3">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Supplier
                        </a>
                    </div>

                    <div class="stat-card border-0 shadow-sm p-4 bg-white rounded-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="py-3 ps-4 border-0">ID</th>
                                        <th class="py-3 border-0">Nama Barang</th>
                                        <th class="py-3 border-0">Stok</th>
                                        <th class="py-3 border-0">Harga Jual</th>
                                        <th class="py-3 border-0">Status</th>
                                        <th class="py-3 border-0 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_barang as $barang)
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">#{{ $barang->id }}</td>
                                        <td class="fw-semibold">{{ $barang->nama_barang }}</td>
                                        <td>
                                            <span class="fw-bold {{ $barang->stok <= 5 ? 'text-danger' : 'text-dark' }}">
                                                {{ $barang->stok }} <small class="text-muted">Unit</small>
                                            </span>
                                        </td>
                                        <td class="text-success fw-bold">Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                        <td>
                                            @if($barang->stok <= 5)
                                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">Kritis</span>
                                            @else
                                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">Aman</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary border-0 rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $barang->id }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <form action="{{ url('admin/barang/hapus/'.$barang->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- MODAL EDIT BARANG (Diletakkan di dalam loop agar ID unik) --}}
                                    @push('modals')
                                    <div class="modal fade" id="modalEdit{{ $barang->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="fw-bold">Edit Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ url('admin/barang/update/'.$barang->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body text-start">
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Nama Barang</label>
                                                            <input type="text" name="nama_barang" class="form-control rounded-3" value="{{ $barang->nama_barang }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Supplier</label>
                                                            <select name="supplier_id" class="form-select rounded-3" required>
                                                                @foreach($data_supplier as $s)
                                                                    <option value="{{ $s->id }}" {{ $barang->supplier_id == $s->id ? 'selected' : '' }}>
                                                                        {{ $s->nama_supplier }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label small fw-bold">Stok</label>
                                                                <input type="number" name="stok" class="form-control rounded-3" value="{{ $barang->stok }}" required>
                                                            </div>
                                                            <div class="col-6 mb-3">
                                                                <label class="form-label small fw-bold">Harga Jual</label>
                                                                <input type="number" name="harga_jual" class="form-control rounded-3" value="{{ $barang->harga_jual }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 pt-0">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary rounded-pill px-4">Update Barang</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endpush
                                    @empty
                                    <tr><td colspan="6" class="text-center py-5">Supplier ini belum memiliki data barang.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                                <div class="modal-header border-0"><h5 class="fw-bold">Tambah Barang</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <form action="{{ url('admin/barang/simpan') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3"><label class="form-label small fw-bold">Nama Barang</label><input type="text" name="nama_barang" class="form-control rounded-3" placeholder="..." required></div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Pilih Supplier</label>
                                            <select name="supplier_id" class="form-select rounded-3" required>
                                                <option value="">-- Pilih Supplier --</option>
                                                @foreach($data_supplier as $s)
                                                    <option value="{{ $s->id }}">{{ $s->nama_supplier }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3"><label class="form-label small fw-bold">Stok</label><input type="number" name="stok" class="form-control rounded-3" required></div>
                                            <div class="col-6 mb-3"><label class="form-label small fw-bold">Harga Jual</label><input type="number" name="harga_jual" class="form-control rounded-3" required></div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0 text-center">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Barang</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Supplier -->
                @if(request()->is('admin/supplier*')) 
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="stat-card border-0 shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold m-0 text-dark">Data Supplier</h4>
                                <p class="text-muted small m-0">Kelola daftar pemasok komponen elektronika</p>
                            </div>
                            <button class="btn btn-success rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahSupplier">
                                <i class="fa-solid fa-plus me-2"></i>Tambah Supplier
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-3 ps-4 border-0 rounded-start">ID</th>
                                        <th class="py-3 border-0">Nama Supplier</th>
                                        <th class="py-3 border-0">Kontak / No. HP</th>
                                        <th class="py-3 border-0">Alamat</th>
                                        <th class="py-3 border-0 text-center rounded-end">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data_supplier as $s)
                                    <tr>
                                        <td class="ps-4 text-muted">#{{ $s->id }}</td>
                                        <td><div class="fw-bold">{{ $s->nama_supplier }}</div></td>
                                        <td>{{ $s->no_hp }}</td>
                                        <td>{{ $s->alamat }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary border-0 rounded-circle" data-bs-toggle="modal" data-bs-target="#modalEditSupplier{{ $s->id }}">
                                                    <i class="fa-solid fa-pen"></i>
                                                </button>
                                                <form action="{{ url('admin/supplier/hapus/'.$s->id) }}" method="POST" onsubmit="return confirm('Hapus supplier ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    @push('modals')
                                    <div class="modal fade" id="modalEditSupplier{{ $s->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered text-start">
                                            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="fw-bold">Edit Supplier</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ url('admin/supplier/update/'.$s->id) }}" method="POST">
                                                    @csrf @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Nama Supplier</label>
                                                            <input type="text" name="nama_supplier" class="form-control rounded-3" value="{{ $s->nama_supplier }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Kontak</label>
                                                            <input type="text" name="no_hp" class="form-control rounded-3" value="{{ $s->kontak }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label small fw-bold">Alamat</label>
                                                            <textarea name="alamat" class="form-control rounded-3" rows="2" required>{{ $s->alamat }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0">
                                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success rounded-pill px-4">Update Data</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endpush
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data supplier.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="modalTambahSupplier" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="fw-bold text-success">Tambah Supplier Baru</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ url('admin/supplier/simpan') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Nama Supplier</label>
                                            <input type="text" name="nama_supplier" class="form-control rounded-3" placeholder="Contoh: PT. Elektro Jaya" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Kontak / No. HP</label>
                                            <input type="text" name="no_hp" class="form-control rounded-3" placeholder="0812..." required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold">Alamat</label>
                                            <textarea name="alamat" class="form-control rounded-3" rows="2" placeholder="Alamat lengkap supplier..." required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success rounded-pill px-4">Simpan Supplier</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>   
                @endif

                <!-- Transaksi -->
                @if(request()->is('admin/riwayat'))
                    <div class="content-card">
                        <h4 class="fw-bold text-dark mb-4">Laporan Seluruh Penjualan</h4>
                        
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No. Nota</th>
                                        <th>User</th> 
                                        <th>Nama Pembeli</th>
                                        <th>Barang</th>
                                        <th class="text-center">Qty</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaksis as $trx)
                                    <tr>
                                        <td><span class="badge bg-secondary">#{{ $trx->penjualan->kode_transaksi }}</span></td>
                                        <td><span class="text-primary fw-bold">{{ $trx->penjualan->user->name ?? 'Sistem' }}</span></td>
                                        <td>{{ $trx->penjualan->nama_pembeli }}</td>
                                        <td>{{ $trx->barang->nama_barang }}</td>
                                        <td class="text-center">{{ $trx->qty }}</td>
                                        <td class="fw-bold">Rp {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                                        <td class="small">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <div class="mt-3">
                                {{ $transaksis->links() }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Laporan -->
                @if(request()->is('admin/laporan*'))
                    <div class="stat-card border-0 shadow-sm mb-4">

                        <!-- HEADER CETAK -->
                        <div class="d-none d-print-block text-center mb-4">
                            <h3 class="fw-bold m-0">LAPORAN INVENTARIS UMKM</h3>
                            <p class="m-0">InvenTech Elektronika</p>
                            <hr style="border:1px solid #000; opacity:1;">
                        </div>

                        <!-- HEADER LAYAR -->
                        <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
                            <div>
                                <h4 class="fw-bold m-0 text-dark">Laporan Inventaris</h4>
                                <p class="text-muted small m-0">
                                    Rekap stok & mutasi barang
                                </p>
                            </div>
                            <button onclick="window.print()" class="btn btn-danger rounded-pill px-4 shadow-sm">
                                <i class="fa-solid fa-print me-2"></i>Cetak Laporan
                            </button>
                        </div>

                        <!-- TAB -->
                        <ul class="nav nav-pills mb-4 d-print-none">
                            <li class="nav-item">
                                <button class="nav-link {{ !request('bulan') ? 'active' : '' }} rounded-pill px-4"
                                    data-bs-toggle="pill"
                                    data-bs-target="#laporan-stok">
                                    Rekap Inventaris
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link {{ request('bulan') ? 'active' : '' }} rounded-pill px-4"
                                    data-bs-toggle="pill"
                                    data-bs-target="#laporan-mutasi">
                                    Mutasi Stok
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">
                                <!-- ================= TAB 1 : REKAP INVENTARIS ================= -->
                        <div class="tab-pane fade {{ !request('bulan') ? 'show active' : '' }}" id="laporan-stok">
                            @isset($barangs)

                            <div class="summary-box mb-4">
                                <div class="row text-center">
                                    <div class="col-md-4 border-end">
                                        <small class="text-muted d-block">Total Jenis Barang</small>
                                        <h3 class="fw-bold text-dark">{{ $barangs->count() }} Item</h3>
                                    </div>
                                    <div class="col-md-4 border-end">
                                        <small class="text-muted d-block">Total Stok Tersedia</small>
                                        <h3 class="fw-bold text-primary">{{ $barangs->sum('stok') }} Unit</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted d-block">Total Nilai Aset</small>
                                        <h3 class="fw-bold text-success">
                                            Rp {{ number_format($total_aset, 0, ',', '.') }}
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Kode</th>
                                            <th>Nama Barang</th>
                                            <th>Supplier</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Nilai</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($barangs as $i => $b)
                                        <tr>
                                            <td class="text-center">{{ $i + 1 }}</td>
                                            <td class="text-center">#BRG-{{ $b->id }}</td>
                                            <td>{{ $b->nama_barang }}</td>
                                            <td>{{ $b->supplier->nama_supplier ?? '-' }}</td>
                                            <td>Rp {{ number_format($b->harga_jual,0,',','.') }}</td>
                                            <td class="text-center fw-bold">{{ $b->stok }}</td>
                                            <td class="fw-bold text-primary">
                                                Rp {{ number_format($b->stok * $b->harga_jual,0,',','.') }}
                                            </td>
                                            <td class="text-center">
                                                @if($b->stok <= 5)
                                                    <span class="badge bg-danger">Menipis</span>
                                                @else
                                                    <span class="badge bg-success">Aman</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @endisset
                        </div>


                            <!-- ================= TAB 2 : MUTASI STOK ================= -->
                            <div class="tab-pane fade {{ request('bulan') ? 'show active' : '' }}" id="laporan-mutasi">

                                <div class="filter-section no-print mb-4">
                                    <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end">
                                        <div class="col-md-3">
                                            <label class="form-label fw-bold small text-muted">Bulan</label>
                                            <div class="input-group shadow-sm">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="fa-solid fa-calendar-day text-primary"></i>
                                                </span>
                                                <select name="bulan" class="form-select border-start-0 ps-0">
                                                    @for($m=1; $m<=12; $m++)
                                                        <option value="{{ $m }}" {{ request('bulan', date('m')) == $m ? 'selected' : '' }}>
                                                            {{ Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="form-label fw-bold small text-muted">Tahun</label>
                                            <div class="input-group shadow-sm">
                                                <span class="input-group-text bg-white border-end-0">
                                                    <i class="fa-solid fa-calendar text-primary"></i>
                                                </span>
                                                <select name="tahun" class="form-select border-start-0 ps-0">
                                                    @for($y=date('Y'); $y>=date('Y')-5; $y--)
                                                        <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>
                                                            {{ $y }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary px-4 shadow-sm d-flex align-items-center">
                                                <i class="fa-solid fa-filter me-2"></i> Terapkan Filter
                                            </button>
                                            <a href="{{ route('admin.laporan') }}" class="btn btn-light border px-4 shadow-sm d-flex align-items-center">
                                                <i class="fa-solid fa-rotate-left me-2"></i> Reset
                                            </a>
                                        </div>
                                    </form>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-light text-center">
                                            <tr>
                                                <th rowspan="2">Nama Barang</th>
                                                <th rowspan="2">Stok Awal</th>
                                                <th colspan="2">Mutasi</th>
                                                <th rowspan="2">Stok Akhir</th>
                                                <th colspan="2">Harga</th>
                                            </tr>
                                            <tr>
                                                <th>Masuk</th>
                                                <th>Keluar</th>
                                                <th>Satuan</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($laporans as $log)
                                            <tr>
                                                <td>{{ $log->nama_barang }}</td>
                                                <td class="text-center">{{ $log->stok_awal }}</td>
                                                <td class="text-center text-success fw-bold">{{ $log->qty_masuk ?? 0 }}</td>
                                                <td class="text-center text-danger fw-bold">{{ $log->qty_keluar ?? 0 }}</td>
                                                <td class="text-center fw-bold bg-light">{{ $log->stok_akhir }}</td>
                                                <td>Rp {{ number_format($log->harga, 0, ',', '.') }}</td>
                                                <td class="fw-bold">
                                                    Rp {{ number_format($log->stok_akhir * $log->harga, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                @endif

            </main>
        </div>

        <!-- Footer -->
        <footer>
            <div class="container">
                <strong>InvenTech</strong> &copy; {{ date('Y') }} - Sistem Inventaris Elektronika Berbasis Laravel
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // Gunakan window.onload untuk memastikan Bootstrap sudah inisialisasi sempurna
            window.onload = function() {
                
                // --- Logic Realtime Clock ---
                function updateClock() {
                    const clockEl = document.getElementById('clock');
                    if (clockEl) {
                        const now = new Date();
                        const options = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
                        clockEl.textContent = now.toLocaleTimeString('id-ID', options);
                    }
                }
                setInterval(updateClock, 1000); 
                updateClock();

                // --- Logic Chart Stok ---
                const ctxBar = document.getElementById('chartStok');
                if (ctxBar) {
                    new Chart(ctxBar, {
                        type: 'bar',
                        data: {
                            labels: {!! json_encode(isset($grafik) ? $grafik->pluck('nama_barang') : []) !!},
                            datasets: [{ 
                                label: 'Jumlah Unit', 
                                data: {!! json_encode(isset($grafik) ? $grafik->pluck('stok') : []) !!}, 
                                backgroundColor: '#0d6efd', 
                                borderRadius: 10,
                                barThickness: 30
                            }]
                        },
                        options: { 
                            responsive: true, 
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } }
                        }
                    });
                }

                // --- Logic Chart Kondisi ---
                const ctxPie = document.getElementById('chartKondisi');
                if (ctxPie) {
                    new Chart(ctxPie, {
                        type: 'doughnut',
                        data: {
                            labels: ['Stok Aman', 'Stok Kritis'],
                            datasets: [{ 
                                data: [{{ $baik ?? 0 }}, {{ $rusak ?? 0 }}], 
                                backgroundColor: ['#198754', '#ef4444'],
                                borderWidth: 0
                            }]
                        },
                        options: { 
                            responsive: true, 
                            maintainAspectRatio: false,
                            cutout: '70%'
                        }
                    });
                }

                // Script agar tab tetap aktif setelah reload halaman
                document.addEventListener("DOMContentLoaded", function() {
                    var urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('bulan')) {
                        var triggerEl = document.querySelector('#laporan-mutasi-tab'); // Sesuaikan ID Tab Anda
                        if(triggerEl) {
                            var tab = new bootstrap.Tab(triggerEl);
                            tab.show();
                        }
                    }
                });


                function hilangkanAngka() {
    // 1. Hilangkan badge di tampilan secara instan
    const badge = document.getElementById('badge-count');
    if (badge) badge.style.display = 'none';

    // 2. Kirim perintah ke server untuk update is_read = true
    fetch("{{ route('notif.markRead') }}")
        .then(response => response.json())
        .then(data => console.log("Notif ditandai dibaca"));
}
                            };
        </script>
    @stack('modals')
    </body>
</html>