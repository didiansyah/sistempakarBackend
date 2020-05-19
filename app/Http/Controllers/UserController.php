<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        sleep(1);
        $users = User::where('email','<>','admin@admin.com')->orderBy('fname','asc')->get();
        return UserResource::collection($users);

    }

    public function requestShit()
    {
        return [
            'fname' => request('fname'),
            'lname' => request('lname'),
            'phone' => request('phone'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ];
    }

    public function store() {
        $user = User::create($this->requestShit());

        return UserResource::make($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(User $user)
    {
        $user->update([
            'fname' => request('fname'),
            'lname' => request('lname'),
            'phone' => request('phone'),
            'email' => request('email'),
        ]);
        return response()->json(['message' => 'User was updated.']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User was deleted']);
    }
}
