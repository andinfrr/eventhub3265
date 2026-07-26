<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterOrganizationController extends Controller
{
    public function create()
    {
        return view('auth.register-organization');
    }

    public function store(Request $request)
    {
        $request->validate([
            'organization_name' => 'required|max:255',
            'organization_email' => 'required|email|unique:organizations,email',

            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $organization = Organization::create([
            'name' => $request->organization_name,
            'slug' => Str::slug($request->organization_name),
            'email' => $request->organization_email,
            'status' => 'pending',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'organization_id' => $organization->id,
        ]);

        return redirect('/login')
            ->with('success', 'Registrasi berhasil. Tunggu approval Super Admin.');
    }
}