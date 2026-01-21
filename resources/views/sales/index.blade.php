<!DOCTYPE html>
<html>
<head>
    <title>Laravel Chart & CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Dashboard Penjualan</h2>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Grafik Penjualan Harian</div>
        <div class="card-body">
            <canvas id="salesChart" height="100"
    data-labels="{{ json_encode($labels) }}" 
    data-values="{{ json_encode($data) }}">
</canvas>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Tambah Data</div>
                <div class="card-body">
                    <form action="{{ route('sales.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Jumlah (Rp)</label>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Riwayat Transaksi</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
    @foreach($sales as $s)
    <tr>
        <td>{{ $s->transaction_date }}</td>
        
        <td>{{ $s->product_name }}</td>
        
        <td>Rp {{ number_format($s->amount) }}</td>
        
        <td>
            <a href="{{ route('sales.edit', $s->id) }}" class="btn btn-warning btn-sm">Edit</a>

            <form action="{{ route('sales.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Ambil elemen canvas dari HTML
    const canvas = document.getElementById('salesChart');

    // 2. Ambil data mentah dari atribut 'data-...' lalu ubah kembali jadi Array JS
    // dataset.labels otomatis mengambil isi dari data-labels
    const chartLabels = JSON.parse(canvas.dataset.labels);
    const chartData = JSON.parse(canvas.dataset.values);

    // 3. Buat Chart dengan data yang sudah bersih
    const ctx = canvas.getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels, 
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: chartData,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Opsi tambahan: Format angka jadi Rupiah di sumbu Y
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>