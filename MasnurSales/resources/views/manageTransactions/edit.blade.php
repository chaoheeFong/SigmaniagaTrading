@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Transaction</h1>

    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif

    <!-- Transaction edit form -->
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Transaction Date & SKU -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Transaction Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', $transaction->date) }}" required>
                            @error('date')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sku">Transaction SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku', $transaction->sku) }}" required readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Rows Section -->
        <div id="product-rows">
            @foreach($transaction->products as $index => $product)
            <div class="product-row card mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="product_id[]">Product</label>
                                <select name="product_id[]" class="form-control product-select" required onchange="updatePrice(this)">
                                    <option value="">Select a product</option>
                                    @foreach($products as $productItem)
                                        <option value="{{ $productItem->id }}" {{ $productItem->id == $product->id ? 'selected' : '' }} data-price="{{ $productItem->product_price }}">
                                            {{ $productItem->product_name }} (ID: {{ $productItem->id }}) - ${{ number_format($productItem->product_price, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('product_id.*')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quantity[]">Quantity</label>
                                <input type="number" name="quantity[]" class="form-control quantity-input" min="1" value="{{ old('quantity', $transaction->quantity) }}" required onchange="updatePrice(this)">
                                @error('quantity.*')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <!-- Remove Product Button -->
                            <button type="button" class="btn btn-danger remove-product-btn" onclick="confirmRemoveProductRow(this)">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_total[]">Total Price</label>
                                <input type="text" name="product_total[]" class="form-control product-total" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Add New Product Row Button -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-outline-secondary" onclick="addProductRow()">
                <i class="fas fa-plus"></i> Add Another Product
            </button>
        </div>

        <!-- Total Transaction Price -->
        <div class="form-group text-right">
            <h4>Total Transaction Price: $<span id="total-price">{{ number_format($transaction->price, 2) }}</span></h4>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-3">Update Transaction</button>
        </div>
    </form>
</div>

@endsection
