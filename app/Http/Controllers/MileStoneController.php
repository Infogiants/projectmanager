<?php

namespace App\Http\Controllers;

use App\MileStone;
use Illuminate\Http\Request;

class MileStoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('milestones.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MileStone  $mileStone
     * @return \Illuminate\Http\Response
     */
    public function show(MileStone $mileStone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MileStone  $mileStone
     * @return \Illuminate\Http\Response
     */
    public function edit(MileStone $mileStone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MileStone  $mileStone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MileStone $mileStone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MileStone  $mileStone
     * @return \Illuminate\Http\Response
     */
    public function destroy(MileStone $mileStone)
    {
        //
    }
}
