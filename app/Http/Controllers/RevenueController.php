<?php

namespace App\Http\Controllers;

use App\Models\Revenue;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Revenue::all());
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

        $revenue = Revenue::create($request->all());

        return response()->json($revenue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Revenue $revenue)
    {
        $this->validate($request, [
            'description' => 'required|string|min:5',
            'amount' => 'required|numeric|gte:1',
        ]);

        $revenue->update($request->all());

        return response()->json($revenue);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revenue $revenue)
    {
        $response = $revenue->delete();

        return response()->json($response);
    }
}
