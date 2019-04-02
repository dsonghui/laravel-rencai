<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{

    protected $table = 'jobs';

    protected $guarded = ['banned_at', 'verified_at', 'company_id'];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
