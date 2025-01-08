<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutentikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateLogin($request);

    // if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
    //     $user = Auth::user();

    //     if ($user->hasRole('owner')) {
    //         return redirect()->route('owner.dashboard');
    //     } elseif ($user->hasRole('manager')) {
    //         return redirect()->route('branch.dashboard', ['branchId' => $user->id_cabang]);
    //     } elseif ($user->hasRole('supervisor')) {
    //         return redirect()->route('branch.stock', ['branchId' => $user->id_cabang]);
    //     } elseif ($user->hasRole('cashier')) {
    //         return redirect()->route('branch.transaction', ['branchId' => $user->id_cabang]);
    //     } elseif ($user->hasRole('warehouse')) {
    //         return redirect()->route('branch.inventory', ['branchId' => $user->id_cabang]);
    //     }

    //     return redirect('/dashboard');
    // }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
