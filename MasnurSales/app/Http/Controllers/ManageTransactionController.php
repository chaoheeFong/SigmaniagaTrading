<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageTransactionController extends Controller
{
    public function index()
    {
        return view('manageTransactions.index');
    }
}
