<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        // Get all products with their current stock levels
        $products = Product::with('category')->get();

        // Return response
        return response()->json(['products' => $products], 200);
    }

    
}
