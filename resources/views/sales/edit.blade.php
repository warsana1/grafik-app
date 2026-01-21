<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Edit Transaksi</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                        @csrf
                        @method('PUT') 

                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" name="product_name" class="form-control" 
                                   value="{{ old('product_name', $sale->product_name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Jumlah (Rp)</label>
                            <input type="number" name="amount" class="form-control" 
                                   value="{{ old('amount', $sale->amount) }}" required>
                        </div>

                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" name="transaction_date" class="form-control" 
                                   value="{{ old('transaction_date', $sale->transaction_date) }}" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Update Data</button>
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>