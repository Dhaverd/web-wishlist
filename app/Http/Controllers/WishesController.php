<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;
use App\Models\User;

class WishesController extends Controller
{
    public function getUserWishes(Request $request, string $user_id)
    {
        return Wish::select('id', 'name', 'price', 'url')->where('user_id', '=', $user_id)->get();
    }

    public function getUsername(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        $username = ['username' => User::find($request->get('user_id'))['name']];
        return response()->json($username, 201);
    }

    public function getWishById(Request $request, string $id)
    {
        return Wish::select('id', 'name', 'price', 'url')->where('id', '=', $id)->get();
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

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:wishes,id',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:256',
            'price' => 'nullable|numeric',
            'url' => 'nullable|url',
        ]);
        $wish = Wish::find($request->get('id'));
        $wish->name = $request->get('name');
        $wish->price = $request->get('price');
        $wish->url = $request->get('url');
        $wish->save();
        return response()->json($wish);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:wishes,id',
        ]);
        // $wish->delete();
        Wish::destroy($request->get('id'));
        return response()->json(null, 204);
    }
}
