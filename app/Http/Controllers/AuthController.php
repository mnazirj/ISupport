<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Login(LoginRequest $request){
        $User = User::where([
            'email'=>$request->email,
            'password'=> md5($request->password),
        ])->first();
        if($User == NULL)
            return redirect()->back()->with('LoginError','Either email or password is incorrect please try again.');
        session()->put('UserId',$User->id);
        return redirect(route('dash.home'));

    }
}
