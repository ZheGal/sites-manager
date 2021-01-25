<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'language', 'group'];

    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}
