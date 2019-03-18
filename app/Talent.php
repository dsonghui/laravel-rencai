<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talent extends Model
{

    protected $table = 'talents';

    protected $fillable = [
        'user_id', 'name', 'nametype', 'sex',
        'birthday', 'phone',
        'email', 'edu', 'experience',
        'marriage', 'address', 'avatar'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (self::isHasTalent($company->user_id)) {
                \abort(400, '用户已存在关联的求职账号');
            }
        });
    }

    public static function isHasTalent($user_id)
    {
        return self::where('user_id', $user_id)->exists();
    }
}
