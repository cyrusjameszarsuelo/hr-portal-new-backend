<?php

namespace App\Http\Controllers;

use App\Models\PositionTitle;
use Illuminate\Http\Request;

class PositionTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $position_titles = PositionTitle::orderBy('position', 'ASC')->get();

        return response()->json($position_titles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $position_title = PositionTitle::create([
            'position_title' => $request->input('position_title'),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
