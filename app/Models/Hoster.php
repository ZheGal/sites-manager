<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoster extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'username',
        'password',
        'multihost'
    ];

    public function sites()
    {
        // Если не админ или модератор, то выводить только те сайты, которые принадлежат юзеру
        $user = \Illuminate\Support\Facades\Auth::user();
        $role = $user->role;

        if ($role == 1 || $role == 2) {
            return $this->hasMany(Site::class);
        }
        return $this->hasMany(Site::class)->where('user_id', '=', $user->id);
    }
}
