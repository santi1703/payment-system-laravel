<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function locate(Request $request)
    {
        $title = 'Usuarios - Locación';
        $firstName = $request->first_name;
        $lastName = $request->last_name;
        $users = User::when($firstName, function ($query) use ($firstName) {
                return $query->where('first_name', 'like', "%$firstName%");
            })
            ->when($lastName, function ($query) use ($lastName) {
                return $query->where('last_name', 'like', "%$lastName%");
            })
            ->get();


        return view('locate')->with(
            compact('title', 'firstName', 'lastName', 'users')
        );
    }
}
