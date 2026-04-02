<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        // Batasi hanya user
        if (Auth::user()->role != 'user') {
            abort(403);
        }

        return view('profile.index');
    }

    public function edit()
    {
        if (Auth::user()->role != 'user') {
            abort(403);
        }

        return view('profile.edit');
    }

    public function update(Request $request)
    {
        if (Auth::user()->role != 'user') {
            abort(403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile')->with('success', 'Profile berhasil diupdate');
    }
}