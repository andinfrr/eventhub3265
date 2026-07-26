<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'event_id'=>'required|exists:events,id',

            'rating'=>'required|integer|min:1|max:5',

            'review'=>'nullable|max:500'

        ]);

        Rating::updateOrCreate(

            [

                'user_id'=>auth()->id(),

                'event_id'=>$request->event_id

            ],

            [

                'rating'=>$request->rating,

                'review'=>$request->review

            ]

        );

        return back()->with(

            'success',

            'Terima kasih sudah memberikan rating.'

        );
    }
}