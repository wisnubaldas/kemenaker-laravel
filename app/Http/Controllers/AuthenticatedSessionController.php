<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
       
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (Auth::user() && Auth::user()->role != '6') {
                return Redirect::route('dashboard');
            } else {
                Auth::guard('web')->logout();
                return redirect()->route('login');
            }
        } else {
            // Login gagal, simpan pesan error ke dalam sesi
           // $request->session()->flash('error', 'Kombinasi username dan password salah.');
            return redirect()->route('login')->with('error', 'Kombinasi username dan password salah.');;
        }
        
    }
   

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
