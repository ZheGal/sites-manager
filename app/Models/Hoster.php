<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hoster extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'username', 'password'];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
