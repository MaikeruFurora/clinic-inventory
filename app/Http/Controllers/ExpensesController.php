<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function expenses(){
        return view('administrator/expenses/index');
    }
    
    public function expensesList(){
        return response()->json([
            "data"=> Expenses::all()
        ]);
    }
}
