<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('Store/Products', ['products' => Product::get(['id', 'name', 'price', 'image', 'stock']), 'orders' => $request->session()->get('orders')]);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $productName, Request $request)
    {

        $orderSession = $request->session()->get('orders');

        return Inertia::render('Store/Product', ['product' => Product::where('name', $productName)->get(['id', 'name', 'description', 'price', 'image', 'stock'])[0], 'orders' => $orderSession]);

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
