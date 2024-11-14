<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionItem;
use App\Models\Product;


class ManageTransactionController extends Controller
{
    public function index(Request $request)
{
    $query = Transaction::query();

    // If a date filter is provided, filter transactions by the date
    if ($request->filled('terminated_date')) {
        $query->whereDate('date', $request->terminated_date);
    }

    // Get the transactions
    $transactions = $query->get();

    return view('manageTransactions.index', compact('transactions'));
}


public function showMonthlyTransactions(Request $request)
{
    // Fetch transactions based on the selected month/year
    $transactionsQuery = Transaction::query();

    if ($request->filled('terminated_date')) {
        $terminatedDate = $request->get('terminated_date');
        $transactionsQuery->whereYear('date', substr($terminatedDate, 0, 4))
                          ->whereMonth('date', substr($terminatedDate, 5, 2));
    }

    // Group by month/year and calculate total sales for each month
    $groupedTransactions = $transactionsQuery->selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(price) as total_sales')
                                             ->groupBy('year', 'month')
                                             ->get();

    // Prepare data for the chart (months and total sales)
    $months = [];
    $totalSales = [];

    foreach ($groupedTransactions as $group) {
        $months[] = \Carbon\Carbon::create($group->year, $group->month, 1)->format('F Y');
        $totalSales[] = $group->total_sales;
    }

return view('manageTransactions.monthtransaction', compact('groupedTransactions', 'months', 'totalSales'));

}





public function create()
{
    $products = DB::table('products')->select('id', 'product_name', 'product_sku', 'product_price', 'product_cost')->get();

    if ($products->isEmpty()) {
        return redirect()->back()->with('message', 'No products available.');
    }

    return view('manageTransactions.create', compact('products'));
}




public function store(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'product_id' => 'required|array',
        'product_id.*' => 'exists:products,id',
        'quantity' => 'required|array',
        'quantity.*' => 'integer|min:1',
        'date' => 'required|date', // Validate the date
    ]);

    DB::beginTransaction();

    try {
        // Step 1: Create a new transaction
        $transaction = new Transaction();
        $transaction->date = $request->date; // Set the date from the form input
        $transaction->sku = ''; // Initialize the SKU as empty, will be updated later
        
        // Initialize placeholders for the total values
        $totalPrice = 0;
        $productNames = []; // This will store the names of the selected products
        $productSkus = [];  // This will store the SKUs of the selected products
        $productCosts = 0;  // To store total costs if needed

        // Handle transaction items here (adding products)
        foreach ($request->product_id as $index => $productId) {
            $quantity = $request->quantity[$index];
            $product = Product::find($productId); // Fetch the product from the DB

            // Add product name to the list
            $productNames[] = $product->product_name;

            // Add product SKU to the list
            $productSkus[] = $product->sku;  // Get SKU from the product table

            // Calculate total price for each product based on quantity
            $itemTotal = $product->product_price * $quantity;
            $totalPrice += $itemTotal;

            // Optionally, accumulate the total cost if needed
            $productCosts += $product->product_cost * $quantity;
        }

        // Combine product names into a single string (e.g., "Product A, Product B")
        $transaction->product_name = implode(', ', $productNames);

        // Combine product SKUs into a single string (e.g., "SKU_001, SKU_002")
        $transaction->sku = implode(', ', $productSkus);

        // Set total price and cost
        $transaction->price = $totalPrice; // Set total price
        $transaction->cost = $productCosts; // Set the total cost (optional)
        $transaction->total_transaction_sales = $totalPrice;
        $transaction->total_orders = count($request->product_id); // You can adjust this based on your needs
        $transaction->total_fulfillment_fees = 0; // Add any logic for fulfillment fees if needed

        // Save the transaction
        $transaction->save();

        DB::commit();

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully!');
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Failed to create transaction. Please try again.');
    }
}






    // Method to show the edit form
    public function edit($id)
    {
        // Find the transaction by its ID
        $transaction = Transaction::findOrFail($id);

        // Return the edit view with the transaction data
        return view('manageTransactions.edit', compact('transaction'));
    }

    // Method to update the transaction
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'date' => 'required|date',
        ]);

        // Find the transaction to update
        $transaction = Transaction::findOrFail($id);

        // Update the transaction data
        $transaction->date = $request->date;
        $transaction->sku = ''; // Optionally update SKU logic here
        $transaction->product_name = implode(', ', Product::whereIn('id', $request->product_id)->pluck('product_name')->toArray());
        $transaction->sku = implode(', ', Product::whereIn('id', $request->product_id)->pluck('sku')->toArray());
        $transaction->price = array_sum(array_map(function ($productId, $quantity) {
            $product = Product::find($productId);
            return $product->product_price * $quantity;
        }, $request->product_id, $request->quantity));

        // Save the updated transaction
        $transaction->save();

        // Redirect to the transactions index page with a success message
        return redirect()->route('manageTransactions.index')->with('success', 'Transaction updated successfully!');
    }


public function destroy($id)
{
    try {
        $transaction = Transaction::findOrFail($id);  // Find the transaction by its ID
        $transaction->delete();  // Delete the transaction

        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->route('transactions.index')->with('error', 'Failed to delete transaction. Please try again.');
    }
}



}
