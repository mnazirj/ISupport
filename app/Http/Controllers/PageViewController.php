<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PageViewController extends Controller
{
    public function LoginIndex(){
        return view('Auth.login')->with('PageTitle','Login');
    }

    
}
