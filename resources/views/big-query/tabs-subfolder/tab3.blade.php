<div>
<h3>Views per Product</h3>
    <canvas id="viewsChart" width="600" height="300"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('viewsChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),  // Product names
            datasets: [{
                label: 'Number of Views',
                data: @json($values),  // View counts
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>