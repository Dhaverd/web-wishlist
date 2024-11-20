<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wish;
use App\Models\User;

class WishesController extends Controller
{
    public function getUserWishes(Request $request, string $user_id)
    {
        $result = [];
        $wishes = Wish::select('id', 'name', 'price', 'url', 'book_user_id')->where('user_id', '=', $user_id)->get();
        foreach ($wishes as $wish){
            $book_user_raw = User::find($wish['book_user_id']);
            $book_user = null;
            if (isset($book_user_raw)){
                $book_user = [
                    'id' => $book_user_raw['id'],
                    'name' => $book_user_raw['name']
                ];
            }
            $result[] = [
                'id' => $wish['id'],
                'name' => $wish['name'],
                'price' => $wish['price'],
                'url' => $wish['url'],
                'book_user' => $book_user
            ];
        }
        return $result;
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
