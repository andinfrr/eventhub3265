<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::latest()->get();

        return view('admin.organizations.index', compact('organizations'));
    }

    public function approve($id)
    {
        $organization = Organization::findOrFail($id);

        $organization->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Organisasi berhasil disetujui.');
    }

    public function reject($id)
    {
        $organization = Organization::findOrFail($id);

        $organization->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Organisasi berhasil ditolak.');
    }
}