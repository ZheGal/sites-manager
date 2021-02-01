<?php

namespace App\Helpers;

class UserHelper
{
    public static function checkBanned($auth)
    {
        if ($auth->role == 3) {
            return true;
        }
        return false;
    }
}