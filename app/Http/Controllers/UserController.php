<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::all();
        return view("user-management.index", compact("users"));
    }
    //
    public function add(){
        $users = User::all();
        return view("user-management.add");
    }
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed', // Konfirmasi password
        ]);

        try {
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']), // Enkripsi password
            ]);

            return redirect()->route("user.management")->with('toast_success', 'User berhasil dibuat!');

        } catch (\Throwable $th) {
            return back()->with("toast_error", $th->getMessage());
        }
    }
}
