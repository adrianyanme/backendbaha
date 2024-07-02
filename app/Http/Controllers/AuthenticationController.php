<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class AuthenticationController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'login' => 'required',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->login)
                ->orWhere('username', $request->login)
                ->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'login' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken('user login')->plainTextToken;
}

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public function me(Request $request)
    {
        return response()->json(Auth::user());
    }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email|unique:users',
    //         'username' => 'required',
    //         'firstname' => 'required',
    //         'lastname' => 'required',
    //         'password' => 'required|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $user = User::create([
    //         'email' => $request->email,
    //         'username' => $request->username,
    //         'firstname' => $request->firstname,
    //         'lastname' => $request->lastname,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     return new UserResource($user);
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'email' => $request->email,
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'password' => Hash::make($request->password),
        ]);

        Profile::create([
            'user_id' => $user->id,
            'username' => $request->username,
        ]);

        // Kirim email verifikasi
        Mail::to($user->email)->send(new VerifyEmail($user));



        return new UserResource($user);
    }


    public function verifyEmail($id)
    {
        $user = User::find($id);
    
        if ($user) {
            $user->email_verified_at = now();
            $user->verified = 'Yes';
            $user->save();
    
            return view('verify_success');
        }
    
        return response()->json(['message' => 'User not found.'], 404);
    }
    


}
