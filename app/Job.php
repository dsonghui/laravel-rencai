<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $table = 'jobs';

    protected $guarded = ['banned_at', 'verified_at'];

    public static function boot()
    {
        parent::boot();

        static::updating(function ($job) {
            if (\array_has($job->getDirty(), 'company_id')) {
                abort(400,'非法请求，不能修改职位的所属企业！');
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
