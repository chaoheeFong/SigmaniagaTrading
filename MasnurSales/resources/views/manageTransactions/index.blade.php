@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Masnur Sales Analysis</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-end mb-2">
        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('transactions.create') }}'">
            Add Transaction
        </button>

        <!-- Button to navigate to the monthly sales analysis page -->
        <button type="button" class="btn btn-info ml-2" onclick="window.location.href='{{ route('transactions.monthly') }}'">
            View Monthly Sales
        </button>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Date</th>
                    <th>Product Name</th>
                    <th>Product SKU</th>
                    <th>Product Price</th>
                    <th>Total Sales</th>
                    <th>Actions</th> <!-- Column for Actions (Edit/Delete) -->
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td> <!-- Displaying the Transaction ID -->
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->product_name }}</td>
                        <td>{{ $transaction->sku }}</td>
                        <td>${{ number_format($transaction->price, 2) }}</td>
                        <td>${{ number_format($transaction->total_transaction_sales, 2) }}</td>
                        <td>
                            <!-- Edit button -->
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">
                                Edit
                            </a>

                            <!-- Delete button -->
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this transaction?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No transactions found.</td> <!-- Adjusted colspan to 7 -->
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
