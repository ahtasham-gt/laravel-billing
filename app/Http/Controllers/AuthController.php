<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        // If already logged in, redirect to invoices page
        if (Session::has('user_authenticated') && Session::get('user_authenticated') === true) {
            return redirect()->route('invoices.index');
        }
        
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
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
    }
    
    public function logout()
    {
        Session::forget('user_authenticated');
        Session::forget('username');
        
        return redirect()->route('login')
            ->with('success', 'Successfully logged out!');
    }
} 