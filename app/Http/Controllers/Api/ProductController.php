<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        // Get all products
        $products = Product::with('category')->get();

        // Return response
        return response()->json(['products' => $products], 200);
    }

     // app/Http/Controllers/ProductController.php

    public function store(Request $request)
    {

        
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|unique:products',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image'=>'required|string',
        ]);

        // Create new product
        $product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $request->image,
        ]);

        // Return response
        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    // app/Http/Controllers/ProductController.php

    public function show($id)
    {
        // Find the product by ID
        $product = Product::with('category')->findOrFail($id);

        // Return response
        return response()->json(['product' => $product], 200);
    }

    

    public function update(Request $request, $id)
    {
        
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Validate incoming request
        $request->validate([
            'name' => 'string|unique:products,name,' . $id,
            'category_id' => 'exists:categories,id',
            'price' => 'numeric|min:0',
            'quantity' => 'integer|min:0',
        ]);

        // Update product details
        $product->update($request->only(['name', 'category_id', 'price', 'quantity']));

        // Return response
        return response()->json(['message' => 'Product updated successfully'], 200);
    }

        public function destroy($id)
    {

        
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete the product
        $product->delete();

        // Return response
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }

    public function order(Request $request)
    {
        
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }

        $request->validate([
            'product_id'=>'required|exists:products,id',
            'quantity'=> 'required|integer|min:1'
        ]);
        $productID= $request->input('product_id');
        $quantity = $request->input('quantity');

        //check if the product already exists
        $product = Product::find($productID);
        if($product){
            $product ->quantity+=$quantity;
            $product->save();

            $order = Order::Create([
                'product_id'=> $productID,
                'quantity'=>$quantity,
            ]);

            return response()->json(
                [
                    'message'=> 'Product Order Successfully'
                ],200
            );
        }else{

            return response()->json(
                [
                    'message'=> 'Product Does not exist Create new product'
                ],200
            );

        }
        
       
    }

    



}
