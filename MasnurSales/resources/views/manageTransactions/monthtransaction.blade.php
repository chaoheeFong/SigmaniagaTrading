@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Monthly Sales Analysis</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form to Filter by Month/Year -->
    <div class="row mb-4">
        <div class="col-md-4">
            <form action="{{ route('transactions.monthly') }}" method="GET">
                <div class="form-group">
                    <label for="terminated_date">Select Month/Year:</label>
                    <input type="month" name="terminated_date" class="form-control" value="{{ request('terminated_date') }}" required>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Filter</button>
            </form>
        </div>
    </div>

    <!-- Back Button to View All Transactions -->
    <div class="d-flex justify-content-end mb-2">
        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('transactions.index') }}'">
            Back to All Transactions
        </button>
    </div>

    <!-- Sales Chart -->
    <div class="mb-4">
        <canvas id="salesChart"></canvas>
    </div>

    <!-- Display Monthly Sales Data -->
    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groupedTransactions as $group)
                    <tr>
                        <td>{{ \Carbon\Carbon::create($group->year, $group->month, 1)->format('F Y') }}</td>
                        <td>${{ number_format($group->total_sales, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No sales data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare the chart data from Blade variables
    const months = @json($months);
    const totalSales = @json($totalSales);

    // Create the sales chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'line', // You can change this to 'bar' or other types
        data: {
            labels: months, // X-axis labels (Month/Year)
            datasets: [{
                label: 'Total Sales',
                data: totalSales, // Y-axis data (Total Sales)
                borderColor: '#4e73df', // Line color
                backgroundColor: 'rgba(78, 115, 223, 0.2)', // Area color
                fill: true,
                tension: 0.4, // Smooth curve
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString();
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return '$' + tooltipItem.raw.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
