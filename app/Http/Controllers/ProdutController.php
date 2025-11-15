<?php

namespace App\Http\Controllers;

use App\Models\Produt;
use App\Http\Requests\StoreProdutRequest;
use App\Http\Requests\UpdateProdutRequest;

class ProdutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Produt $produt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutRequest $request, Produt $produt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produt $produt)
    {
        //
    }
}
