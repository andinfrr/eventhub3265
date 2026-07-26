<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventApprovalController extends Controller
{
    public function index()
    {
        $events = Event::with('organization')
            ->latest()
            ->get();

        return view('admin.events.approval', compact('events'));
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);

        $event->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Event berhasil di-approve.');
    }

    public function reject($id)
    {
        $event = Event::findOrFail($id);

        $event->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Event berhasil ditolak.');
    }
}