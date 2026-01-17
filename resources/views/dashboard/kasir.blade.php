<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Inventaris</title>

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


        footer {
            background: rgba(0, 0, 0, 0.3); 
            color: white; 
            padding: 20px 0; 
            margin-top: 40px; 
            text-align: center; 
        }

       
    @media print {
        body * {
            visibility: hidden;
        }
        #area-cetak, #area-cetak * {
            visibility: visible;
        }
        #area-cetak {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        .d-print-none {
            display: none !important;
        }
        .table {
            border: 1px solid #000 !important;
        }
        .table th, .table td {
            border: 1px solid #000 !important;
        }
    }
    </style>
</head>
<body>

    <div class="wrapper">
        
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

        <nav class="navbar-card mb-4">
            <div class="d-flex gap-1">
                <a href="{{ route('kasir.beranda') }}" class="nav-link-item {{ request()->routeIs('kasir.beranda') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('kasir.barang') }}" class="nav-link-item {{ request()->routeIs('kasir.barang') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> Barang
                </a>
                <a href="{{ route('kasir.penjualan') }}" class="nav-link-item {{ request()->routeIs('kasir.penjualan') ? 'active' : '' }}">
                    <i class="fa-solid fa-money-bill-wave"></i> Transaksi
                </a>
                <a href="{{ route('kasir.riwayat') }}" class="nav-link-item {{ request()->routeIs('kasir.riwayat') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i> Riwayat Transaksi
                </a>
                <a href="{{ route('kasir.laporan') }}" class="nav-link-item {{ request()->routeIs('kasir.laporan') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice"></i> Laporan
                </a>
            </div>
            
            <div class="d-flex align-items-center gap-3">

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
                @if(request()->is('kasir/beranda'))
                    <div class="row g-4 mb-4">
                        <div class="col-md-3">
                            <a href="{{ route('kasir.barang') }}" class="text-decoration-none text-reset">
                                <div class="stat-card d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small fw-bold mb-1">DATA BARANG</p>
                                        <h3 class="fw-bold m-0">{{ $total_barang ?? 0 }}</h3>
                                    </div>
                                    <div class="icon-box bg-primary-subtle text-primary">
                                        <i class="fa-solid fa-laptop"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('kasir.barang') }}" class="text-decoration-none text-reset">
                                <div class="stat-card d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small fw-bold mb-1">TOTAL SUPPLIER</p>
                                        <h3 class="fw-bold m-0">{{ $total_supplier ?? 0 }}</h3>
                                    </div>
                                    <div class="icon-box bg-success-subtle text-success">
                                        <i class="fa-solid fa-truck"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('kasir.riwayat') }}" class="text-decoration-none text-reset">
                                <div class="stat-card d-flex justify-content-between">
                                    <div>
                                        <p class="text-muted small fw-bold mb-1">VOLUME TERJUAL</p>
                                        <h3 class="fw-bold m-0 text-info">{{ $total_terjual ?? 0 }}</h3>
                                    </div>
                                    <div class="icon-box bg-info-subtle text-info">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="{{ route('kasir.barang', ['status' => 'kritis']) }}" class="text-decoration-none text-reset">
                                <div class="stat-card d-flex justify-content-between border-start border-4 border-danger">
                                    <div>
                                        <p class="text-muted small fw-bold mb-1">STOK KRITIS</p>
                                        <h3 class="fw-bold m-0 text-danger">{{ $rusak ?? 0 }}</h3>
                                    </div>
                                    <div class="icon-box bg-danger-subtle text-danger">
                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                    </div>
                                </div>
                            </a>
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
            @if(request()->is('kasir/barang*'))
                
                {{-- HEADER CARD --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary-subtle p-3 rounded-circle me-3 text-primary">
                                    <i class="fa-solid fa-box-archive fs-4"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1">
                                        @if(request('status') == 'kritis')
                                            Stok Hampir Habis
                                        @else
                                            {{ request('supplier_id') ? ($data_barang->first()?->supplier?->nama_supplier ?? 'Detail Barang') : 'Pilih Supplier' }}
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="height: 4px; background: linear-gradient(to right, #0d6efd, #6610f2);"></div>
                </div>

                {{-- KONDISI 1: TAMPILAN STOK KRITIS --}}
                @if(request('status') == 'kritis')
                    <div class="mb-3">
                        <a href="{{ url('kasir/barang') }}" class="btn btn-sm btn-primary border rounded-pill px-3">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Menu Utama
                        </a>
                    </div>
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="card-header bg-white py-3">
                            <h5 class="fw-bold mb-0 text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Daftar Stok Hampir Habis</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="ps-4">Nama Barang</th>
                                            <th>Stok Tersisa</th>
                                            <th>Supplier</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_barang as $item)
                                            <tr>
                                                <td class="ps-4 fw-semibold">{{ $item->nama_barang }}</td>
                                                <td><span class="badge bg-danger px-3 py-2 rounded-pill">{{ $item->stok }} Unit</span></td>
                                                <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                {{-- KONDISI 2: TAMPILAN KOTAK SUPPLIER (Jika belum pilih supplier) --}}
                @elseif(!request('supplier_id'))
                    <div class="row g-3">
                        @foreach($suppliers as $s)
                        <div class="col-md-4">
                            <a href="{{ url('kasir/barang?supplier_id='.$s->id) }}" class="text-decoration-none">
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

                {{-- KONDISI 3: TAMPILAN TABEL BARANG (Jika sudah pilih supplier) --}}
                @else
                    <div class="mb-3">
                        <a href="{{ url('kasir/barang') }}" class="btn btn-sm btn-primary border rounded-pill px-3">
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
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5">Supplier ini belum memiliki data barang.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            @endif
            
            <!-- Transaksi -->
            @if(request()->is('kasir/penjualan'))
                <div class="content-card mt-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">Form Transaksi Penjualan</h4>
                            <p class="text-muted small mb-0">Input data pembeli dan barang untuk mencatat transaksi baru</p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('penjualan.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="nama_pembeli" class="form-label fw-semibold">Nama Pembeli</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                        <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control @error('nama_pembeli') is-invalid @enderror" placeholder="Nama Pelanggan" value="{{ old('nama_pembeli') }}" required>
                                    </div>
                                    @error('nama_pembeli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="barang_id" class="form-label fw-semibold">Pilih Barang</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-box"></i></span>
                                        <select name="barang_id" id="barang_id" class="form-select @error('barang_id') is-invalid @enderror" required>
                                            <option value="" selected disabled>-- Pilih Barang --</option>
                                            @foreach($barangs as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->nama_barang }} (Stok: {{ $item->stok }} | Rp {{ number_format($item->harga_jual) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('barang_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label fw-semibold">Jumlah</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" name="jumlah" id="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', 1) }}" min="1" required>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fa-solid fa-cart-plus"></i> Simpan
                                        </button>
                                    </div>
                                    @error('jumlah')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Riwayat Transaksi -->
            @if(request()->is('kasir/riwayat'))

                <div class="content-card"> 
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold mb-1 text-dark">Monitoring Riwayat Penjualan</h4>
                                <p class="text-muted small mb-0">
                                    Daftar seluruh transaksi yang telah tercatat dalam sistem
                                </p>
                            </div>
                            <div class="d-flex gap-2">

                                <div class="d-flex gap-2">
                                    <a href="{{ route('kasir.export', request()->all()) }}" class="btn btn-success rounded-pill px-3 py-2 shadow-sm">
                                        <i class="fa-solid fa-file-excel me-1"></i> Export Excel
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>No. Nota</th>
                                        <th>Nama Pembeli</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Nama Barang</th>
                                        <th class="text-center">Qty</th>
                                        <th>Harga Satuan</th>
                                        <th>Subtotal</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if(isset($transaksis) && $transaksis->count() > 0)
                                        @foreach($transaksis as $trx)
                                            <tr>
                                                <td class="fw-bold text-dark">#TRX-{{ $trx->penjualan_id }}</td>
                                                <td class="text-dark fw-semibold">
                                                    {{ $trx->penjualan->nama_pembeli ?? 'Umum' }}
                                                </td>
                                                <td class="text-secondary small">
                                                    {{ date('d M Y, H:i', strtotime($trx->created_at)) }}
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-dark">
                                                        {{ $trx->barang->nama_barang ?? 'Produk Dihapus' }}
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-dark border px-3">
                                                        {{ $trx->qty }}
                                                    </span>
                                                </td>
                                                <td class="text-secondary">
                                                    Rp {{ number_format($trx->harga, 0, ',', '.') }}
                                                </td>
                                                <td class="fw-bold text-primary">
                                                    Rp {{ number_format($trx->subtotal, 0, ',', '.') }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3">
                                                        <i class="fa-solid fa-check-double me-1 small"></i> Selesai
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center py-5">
                                                <i class="fa-solid fa-receipt fa-3x text-light mb-3"></i>
                                                <p class="text-muted">Belum ada riwayat transaksi yang tercatat.</p>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                </div>
            @endif

            <!-- Laporan -->
            @if(request()->is('kasir/laporan'))
                <div class="container-fluid py-4">
                    <div class="row mb-4 d-print-none">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm p-3">
                                <form action="{{ route('kasir.laporan') }}" method="GET" class="row g-3 align-items-end">
                                    <div class="col-md-5">
                                        <label class="form-label fw-bold small">Filter Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" value="{{ $tanggal }}">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fa-solid fa-magnifying-glass me-1"></i> Filter
                                        </button>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('kasir.laporan') }}" class="btn btn-outline-secondary w-100">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-primary text-white shadow-sm border-0 h-100 d-flex justify-content-center">
                                <div class="card-body py-2">
                                    <h6 class="text-uppercase x-small fw-bold opacity-75">Pendapatan Hari Ini</h6>
                                    <h3 class="mb-0">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-card shadow-sm p-4" id="area-cetak">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h4 class="fw-bold text-dark mb-1">Rincian Transaksi Kasir</h4>
                                <p class="text-muted small mb-0">Tanggal: {{ date('d M Y', strtotime($tanggal)) }} | Kasir: {{ auth()->user()->name }}</p>
                            </div>
                            <button onclick="window.print()" class="btn btn-success d-print-none">
                                <i class="fa-solid fa-print me-1"></i> Cetak Tabel
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Waktu</th>
                                        <th>No. Nota</th>
                                        <th>Barang</th>
                                        <th class="text-center">Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($laporan_hari_ini as $item)
                                    <tr>
                                        <td class="small">{{ $item->created_at->format('H:i') }}</td>
                                        <td class="fw-bold">#{{ $item->penjualan->kode_transaksi }}</td>
                                        <td>{{ $item->barang->nama_barang }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-folder-open fa-3x mb-3 opacity-25"></i>
                                            <p>Tidak ada transaksi pada tanggal {{ date('d/m/Y', strtotime($tanggal)) }}</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if($laporan_hari_ini->count() > 0)
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end py-3">TOTAL PENDAPATAN</th>
                                        <th class="text-primary py-3">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</th>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                        
                        <div class="d-none d-print-block mt-5">
                            <div class="row">
                                <div class="col-8"></div>
                                <div class="col-4 text-center">
                                    <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
                                    <br><br><br>
                                    <p class="fw-bold">( {{ auth()->user()->name }} )</p>
                                    <p class="small">Kasir</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </main>

    </div>


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
    };
</script>

</body>
</html>