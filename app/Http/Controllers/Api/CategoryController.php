<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        // Get all product categories
        $categories = Category::all();

        // Return response
        return response()->json(['categories' => $categories], 200);
    }

   

    public function store(Request $request)
    {
        
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        // Create new product category
        $category = Category::create([
            'name' => $request->name,
        ]);

        // Return response
        return response()->json(['message' => 'Product category created successfully', 'category' => $category], 201);
    }

    // app/Http/Controllers/CategoryController.php

    public function show($id)
    {
        // Find the product category by ID
        $category = Category::findOrFail($id);

        // Return response
        return response()->json(['category' => $category], 200);
    }

    // app/Http/Controllers/CategoryController.php

    public function update(Request $request, $id)
    {
        
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Find the product category by ID
        $category = Category::findOrFail($id);

        // Validate incoming request
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
        ]);

        // Update product category details
        $category->update(['name' => $request->name]);

        // Return response
        return response()->json(['message' => 'Product category updated successfully'], 200);
    }

    // app/Http/Controllers/CategoryController.php

    public function destroy($id)
    {
        
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Find the product category by ID
        $category = Category::findOrFail($id);

        // Delete the product category
        $category->delete();

        // Return response
        return response()->json(['message' => 'Product category deleted successfully'], 200);
    }




}
