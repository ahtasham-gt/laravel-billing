<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function __construct()
    {
        // No middleware here - we'll do the check in each method
    }

    private function checkAuthentication()
    {
        if (!Session::has('user_authenticated') || Session::get('user_authenticated') !== true) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }
        return null;
    }
    
    /**
     * Display a listing of the customers.
     */
    public function index()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        $customers = Customer::latest()->paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create()
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        return view('customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'gstin' => 'nullable|string|max:15',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'gstin' => 'nullable|string|max:15',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $authCheck = $this->checkAuthentication();
        if ($authCheck) return $authCheck;
        
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
} 