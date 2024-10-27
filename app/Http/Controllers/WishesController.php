<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;

class WishesController extends Controller
{
    public function getUserWishes(Request $request, string $user_id)
    {
        return Wish::where('user_id', '=', $user_id)->get();
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:256',
            'price' => 'nullable|numeric',
            'url' => 'nullable|url',
        ]);

        $wish = Wish::create($request->all());
        return response()->json($wish, 201);
    }

    public function update(Request $request, Wish $wish)
    {
        $request->validate([
            'name' => 'required|string|max:256',
            'price' => 'nullable|numeric',
            'url' => 'nullable|url',
        ]);

        $wish->update($request->all());
        return response()->json($wish);
    }

    public function destroy(Wish $wish)
    {
        $wish->delete();
        return response()->json(null, 204);
    }
}
