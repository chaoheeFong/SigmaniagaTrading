@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Create New Transaction</h1>

    <!-- Display any session messages (success, error) -->
    @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
    @endif

    <!-- Back Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i> Back
        </button>
    </div>

    <!-- Transaction creation form -->
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <!-- Transaction Date & SKU -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Transaction Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', now()->toDateString()) }}" required>
                            @error('date')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sku">Transaction SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" required>
                            @error('sku')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Rows Section -->
        <div id="product-rows">
            <!-- Product Selection Row Template -->
            <div class="product-row card mb-3">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="product_id[]">Product</label>
                                <select name="product_id[]" class="form-control product-select" required onchange="updatePrice(this)">
                                    <option value="">Select a product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->product_price }}">
                                            {{ $product->product_name }} (ID: {{ $product->id }}) - ${{ number_format($product->product_price, 2) }}
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
                                <input type="number" name="quantity[]" class="form-control quantity-input" min="1" value="1" required onchange="updatePrice(this)">
                                @error('quantity.*')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <!-- Remove Product Button with Icon -->
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
        </div>

        <!-- Add New Product Row Button -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-outline-secondary" onclick="addProductRow()">
                <i class="fas fa-plus"></i> Add Another Product
            </button>
        </div>

        <!-- Total Transaction Price -->
        <div class="form-group text-right">
            <h4>Total Transaction Price: $<span id="total-price">0.00</span></h4>
        </div>

        <!-- Submit Button -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary mt-3">Create Transaction</button>
        </div>
    </form>
</div>

<!-- JavaScript for dynamically adding/removing product rows and calculating totals -->
<script>
    // Function to update price and total
    function updatePrice(inputElement) {
        const productRow = inputElement.closest('.product-row');
        const productSelect = productRow.querySelector('.product-select');
        const quantityInput = productRow.querySelector('.quantity-input');
        const totalInput = productRow.querySelector('.product-total');
        
        const productPrice = parseFloat(productSelect.options[productSelect.selectedIndex].getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityInput.value) || 1;

        const totalPrice = productPrice * quantity;
        totalInput.value = totalPrice.toFixed(2);
        
        updateTotalTransactionPrice();
    }

    // Function to update the total transaction price
    function updateTotalTransactionPrice() {
        let totalTransactionPrice = 0;
        const totalElements = document.querySelectorAll('.product-total');
        
        totalElements.forEach(function(totalElement) {
            totalTransactionPrice += parseFloat(totalElement.value) || 0;
        });

        document.getElementById('total-price').innerText = totalTransactionPrice.toFixed(2);
    }

    // Function to add a new product row
    function addProductRow() {
        // Clone the first product row
        const firstRow = document.querySelector('.product-row');
        const newRow = firstRow.cloneNode(true);

        // Clear the selected value and quantity input in the cloned row
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.quantity-input').value = 1;
        newRow.querySelector('.product-total').value = '';

        // Append the cloned row to the product rows container
        document.getElementById('product-rows').appendChild(newRow);
        updateTotalTransactionPrice();
    }

    // Function to show a confirmation dialog before removing a product row
    function confirmRemoveProductRow(button) {
        if (confirm('Are you sure you want to remove this product?')) {
            removeProductRow(button);
        }
    }

    // Function to remove a product row
    function removeProductRow(button) {
        const productRows = document.getElementById('product-rows');

        // Remove the product row only if there are more than one row remaining
        if (productRows.children.length > 1) {
            button.closest('.product-row').remove();
        } else {
            alert('At least one product must be selected.');
        }

        updateTotalTransactionPrice();
    }
</script>
@endsection
