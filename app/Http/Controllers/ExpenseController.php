<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Expense::all());
    }

    public function show(Expense $expense)
    {
        return response()->json($expense);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string|min:5',
            'amount' => 'required|numeric|gte:1',
        ]);

        $expense = Expense::create($request->all());

        return response()->json($expense);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $this->validate($request, [
            'description' => 'required|string|min:5',
            'amount' => 'required|numeric|gte:1',
        ]);

        $expense->update($request->all());

        return response()->json($expense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $response = $expense->delete();

        return response()->json($response);
    }
}
