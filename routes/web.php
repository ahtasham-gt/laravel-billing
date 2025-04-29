<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;

// Simple test route
Route::get('/test', function() {
    return 'Test route is working!';
});

// Direct login routes without a controller
Route::get('/login', function() {
    // If already logged in, redirect to invoices page
    if (Session::has('user_authenticated') && Session::get('user_authenticated') === true) {
        return redirect()->route('invoices.index');
    }
    
    return view('auth.login');
})->name('login');

Route::post('/login', function(Request $request) {
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);
    
    // Check if credentials match our fixed user
    if ($credentials['username'] === 'sumana' && $credentials['password'] === 'collection') {
        Session::put('user_authenticated', true);
        Session::put('username', 'sumana');
        
        return redirect()->route('invoices.index')
            ->with('success', 'Successfully logged in!');
    }
    
    return back()->withErrors([
        'login_failed' => 'The provided credentials do not match our records.',
    ]);
})->name('login.submit');

Route::get('/logout', function() {
    Session::forget('user_authenticated');
    Session::forget('username');
    
    return redirect()->route('login')
        ->with('success', 'Successfully logged out!');
})->name('logout');

// Main routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Resource routes
Route::resource('customers', CustomerController::class);
Route::resource('invoices', InvoiceController::class);
Route::get('/invoices/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.download-pdf'); 