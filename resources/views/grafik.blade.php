<!DOCTYPE html>
<html>
<head>
    <title>Grafik Laravel</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div style="width:80%; margin:auto;">
    <canvas
        id="myChart"
        data-sales='@json($data)'>
    </canvas>
</div>

<script>
    const canvas = document.getElementById('myChart');

    // Ambil data dari HTML (AMAN)
    const dataSales = JSON.parse(canvas.dataset.sales);

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dataSales.map(item => item.bulan),
            datasets: [{
                label: 'Total Penjualan',
                data: dataSales.map(item => item.total_penjualan),
                backgroundColor: 'rgba(54,162,235,0.5)',
                borderColor: 'rgba(54,162,235,1)',
                borderWidth: 1
            }]
        }
    });
</script>

</body>
</html>
