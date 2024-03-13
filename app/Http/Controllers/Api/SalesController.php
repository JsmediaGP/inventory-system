<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        // Get all sales
        $sales = Sale::all();

        // Return response
        return response()->json(['sales' => $sales], 200);
    }


    public function bestSelling()
    {
        // Group sales by product ID and calculate total quantity sold
        $bestSellingProducts = Sale::groupBy('product_id')
            ->selectRaw('product_id, SUM(quantity) as total_quantity')
            ->orderByDesc('total_quantity')
            ->limit(5) // You can adjust the limit according to your needs
            ->get();

        // Return response
        return response()->json(['best_selling_products' => $bestSellingProducts], 200);
    }

    public function sell(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Find the product
        $product = Product::findOrFail($request->product_id);

        // Check if the requested quantity is available in stock
        if ($product->quantity < $request->quantity) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        // Calculate total price
        $totalPrice = $product->price * $request->quantity;

        // Deduct sold quantity from stock
        $product->decrement('quantity', $request->quantity);

        // Record the sale
        Sale::create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
        ]);

        // Return response
        return response()->json(['message' => 'Product sold successfully', 'total_price' => $totalPrice], 200);
    }




}
