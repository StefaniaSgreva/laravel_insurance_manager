<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Policy;
use Illuminate\Http\Request;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return response()->json(Policy::with('client')->get());
        $perPage = $request->get('per_page', 10);
        $policies = Policy::with('client')->paginate($perPage);
        return response()->json($policies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'policy_number' => 'required|string|unique:policies',
            'type' => 'required|in:auto,home,life,health',
            'premium' => 'required|numeric|min:0',
            'coverage_amount' => 'required|numeric|min:0',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'status' => 'sometimes|in:active,expired,cancelled,pending'
        ]);

        $policy = Policy::create($validated);

        return response()->json($policy->load('client'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Policy $policy)
    {
        return response()->json($policy->load('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Policy $policy)
    {
        $validated = $request->validate([
            'client_id' => 'sometimes|exists:clients,id',
            'policy_number' => 'sometimes|string|unique:policies,policy_number,' . $policy->id,
            'type' => 'required|in:auto,home,life,health',
            'premium' => 'required|numeric|min:0',
            'coverage_amount' => 'required|numeric|min:0',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_date',
            'status' => 'sometimes|in:active,expired,cancelled,pending'
        ]);

        $policy->update($validated);

        return response()->json($policy->load('client'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Policy $policy)
    {
        $policy->delete();

        return response()->json(null, 204);
    }
}
