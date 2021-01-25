<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    public function user()
    {
        // сайт привязывается к конкретному юзеру
        return $this->belongsTo(User::class);
    }

    public function hoster()
    {
        // сайт принадлежит определённому хосту
        return $this->belongsTo(Hoster::class);

    }

    public function campaign()
    {
        // у каждого сайта своя кампания
        return $this->belongsTo(Campaign::class);
    }
}
