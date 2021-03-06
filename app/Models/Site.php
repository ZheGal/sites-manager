<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain',
        'user_id',
        'campaign_id',
        'hoster_id',
        'hoster_id_domain',
        'ftp_host',
        'ftp_user',
        'ftp_pass',
        'yandex',
        'facebook',
        'cloakit',
        'status',
        'additional',
        'type',
        'relink',
        'pid',
        'last_test',
        'last_check',
        'available',
        'test_result'
    ];

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

    public function hoster_domain()
    {
        return $this->belongsTo(Hoster::class, 'hoster_id_domain');
    }

    public function creator()
    {
        // какой пользователь создавал сайт
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function updator()
    {
        // какой пользователь обновлял сайт
        return $this->belongsTo(User::class, 'updator_id');
    }
}
