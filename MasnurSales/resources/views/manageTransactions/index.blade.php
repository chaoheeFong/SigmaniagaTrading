@extends('layouts.app')

@section('content')

<style>
    tr:hover {
        background-color: #F8FAFD;
    }
</style>

<body>
<div class="container">
    <div class="row justify-content-center">

        <div class="header">
            <div class="centered-header">Masnur Sales Analysis</div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header centered-text">Search Date</div>
                <div class="card-body">
                    <form action="{{ route('transactions.index') }}" method="GET">
                        @csrf
                        <div class="body-header">
                            <div class="item">
                                <label class="header">Date</label>
                                <input type="date" id="terminated_date" name="terminated_date" class="form-control" required placeholder="Select date">
                                @error('terminated_date')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="centered-text mt-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>            
            </div>

            <div class="d-flex justify-content-end mb-2">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" onclick="window.location.href='/transactions/create'">
                    Add Transaction
                </button>
            </div>

            <div class="table-container">
                <table id="on-going-transaction-table" class="table table-hover centered-table">
                    <thead>
                        <tr>
                            <th colspan="7" style="background-color:#DAF5FF">Masnur Sales Analysis</th>
                        </tr>
                        <tr>
                            <th style="background-color:#B0DAFF">Date</th>
                            <th style="background-color:#B0DAFF">Product Name</th>
                            <th style="background-color:#B0DAFF">Product SKU</th>
                            <th style="background-color:#B0DAFF">Product Price</th>
                            <th style="background-color:#B0DAFF">Product Cost</th>
                            <th style="background-color:#B0DAFF">Sales Count</th>
                            <th style="background-color:#B0DAFF">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction) <!-- Loop through the transactions -->
                            <tr>
                                <td>{{ $transaction->date }}</td>
                                <td>{{ $transaction->product_name }}</td>
                                <td>{{ $transaction->product_sku }}</td>
                                <td>${{ number_format($transaction->product_price, 2) }}</td>
                                <td>${{ number_format($transaction->product_cost, 2) }}</td>
                                <td>{{ $transaction->sales_count }}</td>
                                <td>${{ number_format($transaction->total_sales, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
@endsection
