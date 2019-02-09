<?php

namespace App\Providers;

use App\Validators\HashValidator;
use App\Validators\IdNumberValidator;
use App\Validators\KeepWordValidator;
use App\Validators\PhoneValidator;
use App\Validators\PolyExistsValidator;
use App\Validators\UsernameValidator;
use App\Validators\UserUniqueContentValidator;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    protected $validators = [
        'poly_exists' => PolyExistsValidator::class,
        'phone' => PhoneValidator::class,
        'id_no' => IdNumberValidator::class,
        'keep_word' => KeepWordValidator::class,
        'hash' => HashValidator::class,
        'username' => UsernameValidator::class,
        'user_unique_content' => UserUniqueContentValidator::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Resource::withoutWrapping();

        Carbon::setLocale('zh');

        //User::observe(UserObserver::class);
        //Thread::observe(ThreadObserver::class);
        //Comment::observe(CommentObserver::class);

        $this->registerValidators();

    }

    /**
     * Register validators.
     */
    protected function registerValidators()
    {
        foreach ($this->validators as $rule => $validator) {
            Validator::extend($rule, "{$validator}@validate");
        }
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
