<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function cleaned()
    {
        return view('clean');
    }

    public function is_banned()
    {
        if (Auth::user()->role == 0) {
            return true;
        }
    }

    public function register()
    {
        return view('auth.register');
    }
}
