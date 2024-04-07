<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function register(RegisterRequest $req)
    {
        $user = (new User())->registerUser($req);
        $token = $user->createToken("name : $user->name")->plainTextToken;

        // Send the welcome email
        Mail::to($user->email)->send(new WelcomeEmail($user));

        return $this->successResponse(201, [
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Registration successful. Please check your email for activation');
    }

    public function login(LoginRequest $req)
    {
        $user = User::where('email', $req->email)->first();
        if (!$user || !Hash::check($req->password, $user->password)) {
            return $this->errorResponse(422, 'اطلاعات وارد شده صحیح نمی باشد');
        }
        $token = $user->createToken("myApp")->plainTextToken;
        return $this->successResponse(200, [
            'user' => new UserResource($user),
            'token' => $token,
        ], "User successfully logged in");
    }


    public function emailVerify()
    {
        session()->flash('registerSuccessful', 'ایمیل شما با موفقیت تایید شد');
        return $this->successResponse(200, 'successfully', 'user email has been successfully verified');
    }


    public function logout(Request $req)
    {
        $user = $req->user();
//      $user->currentAccessToken()->delete();  //Remove current token
        $user->tokens()->delete();  //Revoke all tokens before user
        return $this->successResponse(200, "logout", "User logged out successfully");
    }

}
