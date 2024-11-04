<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ManageTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all(); // Assuming you have a Transaction model
        return view('manageTransactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('manageTransactions.create'); // view for creating a transaction
    }

public function store(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric',
        'description' => 'required|string|max:255',
        // Add other validations as needed
    ]);

    Transaction::create($request->all()); // Create the transaction
    return redirect()->route('transactions.index')->with('success', 'Transaction added successfully.');
}


public function edit($id)
{
    $transaction = Transaction::findOrFail($id);
    return view('manageTransactions.edit', compact('transaction')); // view for editing a transaction
}

public function update(Request $request, $id)
{
    $request->validate([
        'amount' => 'required|numeric',
        'description' => 'required|string|max:255',
        // Add other validations as needed
    ]);

    $transaction = Transaction::findOrFail($id);
    $transaction->update($request->all()); // Update the transaction
    return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
}


public function destroy($id)
{
    $transaction = Transaction::findOrFail($id);
    $transaction->delete(); // Delete the transaction
    return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
}


}
