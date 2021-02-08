<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiController extends \App\Http\Controllers\Controller
{
    public function update()
    {
        $script = "cd " . base_path() . " && git pull";
        $exec = exec($script);
        return [
            'command' => strval($script),
            'message' => strval($exec)
        ];
    }
}
