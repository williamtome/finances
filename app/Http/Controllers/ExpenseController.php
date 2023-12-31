<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;

class ExpenseController extends Controller
{
    public function index()
    {
        return response()->json(Expense::all());
    }

    public function show(Expense $expense)
    {
        return response()->json($expense);
    }

    public function store(ExpenseRequest $request)
    {
        $expense = Expense::create($request->all());

        return response()->json($expense);
    }

    public function update(ExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());

        return response()->json($expense);
    }

    public function destroy(Expense $expense)
    {
        $response = $expense->delete();

        return response()->json($response);
    }
}
