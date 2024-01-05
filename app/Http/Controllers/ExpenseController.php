<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::query()
            ->when(!empty($request->description), function ($query) use ($request) {
                $query->where('description', 'like', "%{$request->description}%");
            })
            ->get();

        return response()->json($expenses);
    }

    public function show(Expense $expense)
    {
        return response()->json($expense);
    }

    public function store(ExpenseRequest $request)
    {
        $expense = Expense::create($request->all());

        return response()->json($expense, Response::HTTP_CREATED);
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
