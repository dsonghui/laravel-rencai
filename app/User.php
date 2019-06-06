<?php

namespace App;

use function abort;
use App\Traits\WithDiffForHumanTimes;
use function array_has;
use function ends_with;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, WithDiffForHumanTimes;

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'phone',
        'is_admin', 'cache',
        'last_active_at', 'banned_at', 'activated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    const SENSITIVE_FIELDS = [
        'last_active_at', 'banned_at', 'phone',
    ];
    const UPDATE_SENSITIVE_FIELDS = [
        'activated_at', 'banned_at',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (User::isUsernameExists($user->name)) {
                abort(400, '用户名已经存在');
            }
        });

        static::saving(function ($user) {
            if (Hash::needsRehash($user->password)) {
                $user->password = \bcrypt($user->password);
            }

            if (array_has($user->getDirty(), self::UPDATE_SENSITIVE_FIELDS) && !\request()->user()->is_admin) {
                abort(400, '非法请求！');
            }

            foreach ($user->getDirty() as $field => $value) {
                if (ends_with($field, '_at')) {
                    $user->$field = $value ? now() : null;
                }
            }
        });
    }

    /**
     * Find the user identified by the given $identifier.
     * @param $identifier email|phone
     * @return mixed
     */
    public function findForPassport($identifier)
    {
        return self::orWhere('name', $identifier)->orWhere('phone', $identifier)->first();
    }

    public static function isUsernameExists(string $username)
    {
        return self::whereRaw(\sprintf('lower(name) = "%s" ', \strtolower($username)))->exists();
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    public function talent()
    {
        return $this->hasOne(Talent::class, 'user_id', 'id');
    }
}
