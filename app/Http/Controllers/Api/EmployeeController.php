<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index()
    {

        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
       
        // Get all employees
        $employees = User::where('role', 'employee')->get();

        // Return response
        return response()->json(['employees' => $employees], 200);
    }


    public function show($id)
    {

        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Find the employee by ID
        $employee = User::findOrFail($id);

        // Check if the user is an employee
        if ($employee->role !== 'employee') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Return response
        return response()->json(['employee' => $employee], 200);
    }

    

    public function update(Request $request, $id)
    {
        if($request->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Find the employee by ID
        $employee = User::findOrFail($id);

        // Check if the user is an employee
        if ($employee->role !== 'employee') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate incoming request
        $request->validate([
            'name' => 'string',
            'email' => 'string|email|unique:users,email,' . $id,
            'password' => 'string|min:6',
        ]);

        // Update employee details
        $employee->update($request->only(['name', 'email', 'password']));
        if($request->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Return response
        return response()->json(['message' => 'Employee details updated successfully'], 200);
    }

    

    public function destroy($id)
    {
        if(\request()->user()->role!== 'manager') {
            return response()->json(['message' => 'You are not authorized to access this resource'], 401);
        }
        // Find the employee by ID
        $employee = User::findOrFail($id);

        // Check if the user is an employee
        if ($employee->role !== 'employee') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Delete the employee
        $employee->delete();

        // Return response
        return response()->json(['message' => 'Employee deleted successfully'], 200);
    }



}
