<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjualan Modern</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --primary-color: #667eea;
            --bg-color: #f3f4f6;
            --card-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: #4a5568;
        }

        /* Navbar Styling */
        .navbar {
            background: var(--primary-gradient);
            box-shadow: 0 2px 10px rgba(118, 75, 162, 0.3);
            padding: 1rem 0;
        }
        .navbar-brand {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            background: #fff;
            transition: transform 0.2s;
            margin-bottom: 25px;
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            color: #2d3748;
            padding: 1.2rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header i {
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        /* Button Styling */
        .btn-primary-theme {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
        }
        .btn-primary-theme:hover {
            opacity: 0.9;
            color: white;
        }

        /* Table Styling */
        .table thead th {
            background-color: #f8f9fa;
            color: #718096;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        .table td {
            vertical-align: middle;
            color: #2d3748;
            padding: 1rem 0.75rem;
        }
        
        /* Form Inputs */
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #e2e8f0;
            background-color: #fcfcfc;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
            border-color: var(--primary-color);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark mb-5">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="bi bi-graph-up-arrow me-2"></i> SalesPanel
        </a>
        
        <div class="ms-auto">
            @auth
                <div class="d-flex align-items-center gap-3">
                    <span class="text-white fw-light">
                        Halo, <strong>{{ Auth::user()->name }}</strong>
                    </span>
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>

<div class="container pb-5">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark mb-1">Dashboard Overview</h2>
            <p class="text-muted">Pantau performa penjualan Anda hari ini.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart-fill"></i> Statistik Penjualan Harian
                </div>
                <div class="card-body p-4">
                    <canvas id="salesChart" height="80"
                        data-labels="{{ json_encode($labels) }}" 
                        data-values="{{ json_encode($data) }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @auth
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-plus-circle-fill"></i> Input Transaksi
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">NAMA PRODUK</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-box-seam"></i></span>
                                <input type="text" name="product_name" class="form-control border-start-0 ps-0" placeholder="Contoh: Kopi Susu" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">JUMLAH (RP)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">Rp</span>
                                <input type="number" name="amount" class="form-control border-start-0 ps-0" placeholder="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">TANGGAL</label>
                            <input type="date" name="transaction_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary-theme w-100 mt-2 shadow">
                            <i class="bi bi-save me-2"></i> Simpan Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endauth

        <div class="{{ Auth::check() ? 'col-md-8' : 'col-md-12' }}">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <span><i class="bi bi-clock-history"></i> Riwayat Transaksi Terakhir</span>
                    <span class="badge bg-light text-dark border">{{ count($sales) }} Data</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="ps-4">Tanggal</th>
                                    <th>Produk</th>
                                    <th>Total</th>
                                    @auth <th class="text-end pe-4">Aksi</th> @endauth
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sales as $s)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light p-2 rounded me-2 text-primary">
                                                <i class="bi bi-calendar-event"></i>
                                            </div>
                                            {{ date('d M Y', strtotime($s->transaction_date)) }}
                                        </div>
                                    </td>
                                    <td class="fw-medium">{{ $s->product_name }}</td>
                                    <td class="text-success fw-bold">
                                        Rp {{ number_format($s->amount, 0, ',', '.') }}
                                    </td>
                                    
                                    @auth
                                    <td class="text-end pe-4">
                                        <a href="{{ route('sales.edit', $s->id) }}" class="btn btn-light btn-sm text-warning border" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('sales.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm text-danger border ms-1" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endauth
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Belum ada data penjualan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const canvas = document.getElementById('salesChart');
    const ctx = canvas.getContext('2d');

    // Membuat Gradient Warna untuk Chart
    // Gradient dari Ungu (atas) ke Putih Transparan (bawah)
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)'); // Warna Atas
    gradient.addColorStop(1, 'rgba(118, 75, 162, 0.2)');  // Warna Bawah

    const chartLabels = JSON.parse(canvas.dataset.labels);
    const chartData = JSON.parse(canvas.dataset.values);

    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels, 
            datasets: [{
                label: 'Total Penjualan',
                data: chartData,
                backgroundColor: gradient,
                borderColor: '#667eea',
                borderWidth: 1,
                borderRadius: 5, // Membuat sudut batang melengkung
                barPercentage: 0.6, // Mengatur lebar batang
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Menyembunyikan legend default agar lebih bersih
                },
                tooltip: {
                    backgroundColor: '#1a202c',
                    padding: 12,
                    titleFont: { family: 'Poppins', size: 14 },
                    bodyFont: { family: 'Poppins', size: 13 },
                    callbacks: {
                        label: function(context) {
                            let value = context.raw;
                            return ' Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9', // Grid yang sangat halus
                        borderDash: [5, 5]
                    },
                    ticks: {
                        font: { family: 'Poppins' },
                        callback: function(value) {
                            // Format K (Ribuan) atau Juta agar sumbu Y tidak penuh
                            if (value >= 1000000) return (value/1000000) + 'Jt';
                            if (value >= 1000) return (value/1000) + 'Rb';
                            return value;
                        }
                    },
                    border: { display: false } // Hilangkan garis sumbu Y kiri
                },
                x: {
                    grid: { display: false },
                    ticks: { font: { family: 'Poppins' } }
                }
            }
        }
    });
</script>

</body>
</html>