<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService 
{
    public function store(array $request)
    {
        return User::create([
            'nickname' => $request['nickname'],
            'email'    => $request['email'],
            'password' => Hash::make($request['password']),
            'role'     => $request['role'],
        ]);
    }

    public function update(User $user, array $request)
    {
        $user->fill($request);

        if (!empty($request['password'])) {
            $user->password = Hash::make($request['password']);
        }

        return $user->save();
    }
}