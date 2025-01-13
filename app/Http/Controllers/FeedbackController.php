<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'text' => 'required|string|max:256'
        ]);

        $wish = Feedback::create($request->all());
        return response()->json($wish, 201);
    }
}
