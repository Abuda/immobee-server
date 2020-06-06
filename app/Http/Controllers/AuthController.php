<?php

namespace App\Http\Controllers;

ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');
ini_set('memory_limit', '100M');

use App\Helpers\Constants;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // helper function to return the current logged in user as the correct type
    // to prevent intelephense complaining about missing function
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed|min:' . Constants::MIN_PASS_LENGTH
        ]);


        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['user' => $user, 'access_token' => $accessToken], Constants::codes()::OK);
    }

    public function login(Request $request)
    {
        // return status code 422 on fail
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Invalid Credentials'], Constants::codes()::UNAUTHORIZED);
        }
        $accessToken = Constants::user()->createToken('authToken')->accessToken;
        return response()->json(['user' => Constants::user(), 'access_token' => $accessToken], Constants::codes()::OK);
    }

    public function update(Request $request)
    {
        // validate input
        $validatedData = $request->validate([
            'name' => 'nullable',
            'password' => 'nullable|confirmed|min:' . Constants::MIN_PASS_LENGTH,
            'phone' => 'nullable',
            'photo' => 'nullable|mimes:jpeg,jpg,bmp,png'
        ]);
        // only encrypt password if present, otherwise, make sure it's deleted
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($request->password);
        } else {
            unset($validatedData['password']);
        }
        // save new info to user
        Constants::user()->fill($validatedData)->save();

        return response()->json(['message' => 'User info updated successfully', 'user' => Constants::user()], Constants::codes()::OK);
    }
}
