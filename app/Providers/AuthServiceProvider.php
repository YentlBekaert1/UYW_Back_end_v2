<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Mail\VerifyMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        VerifyEmail::toMailUsing(function ($notifiable, $url){
            return new VerifyMail($notifiable, $url);
        });

        ResetPassword::toMailUsing(function($user, string $token) {
            return (new MailMessage)
                ->subject('Reset Password')
                ->view('email.password_reset', [
                    'user' => $user,
                    'url' => sprintf('%s/users/password_reset/%s', config('app.url'), $token)
            ]);
        });

//        VerifyEmail::createUrlUsing(function (){
//            // logic here
//        });
    }
}
