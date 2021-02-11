<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\User;

class UsersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    //https://laravel-news.com/building-vue-spa-laravel-part-3
    public function index()
    {
        return UserResource::collection(User::paginate(10));
        //return User::paginate(10);

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
        ]);

        return new UserResource(User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user, Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->update($data);

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response(null, 204);
    }
}
