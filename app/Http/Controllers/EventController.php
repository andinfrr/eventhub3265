<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function event(Request $request)
    {
        $categories = Category::all();

        $events = Event::where('status', 'approved')
            ->when($request->category, function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->latest()
            ->get();

        return view('welcome', compact('events', 'categories'));
    }

    public function show($id)
    {
        $event = Event::whereHas('organization', function ($query) {
                $query->where('status', 'approved');
            })
            ->findOrFail($id);

        $categories = Category::all();

        // Ambil semua rating beserta user
        $ratings = $event->ratings()
            ->with('user')
            ->latest()
            ->get();

        // Hitung rata-rata rating
        $averageRating = $event->ratings()->avg('rating');

        return view('event-detail', compact(
            'event',
            'categories',
            'ratings',
            'averageRating'
        ));
    }

    public function checkout()
    {
        return view('checkout');
    }
}