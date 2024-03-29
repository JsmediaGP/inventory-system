<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
