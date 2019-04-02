<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companys';
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'shortname', 'hy',
        'pr', 'mun',
        'provinceid', 'cityid', 'three_cityid',
        'address', 'linkman', 'linkphone', 'linkmail',
        'lat', 'lnt'
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($company) {
            if (Company::isHasCompany($company->user_id)) {
                \abort(400, '用户已存在关联的企业');
            }
        });
    }

    public static function isHasCompany($user_id)
    {
        return self::where('user_id', $user_id)->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
