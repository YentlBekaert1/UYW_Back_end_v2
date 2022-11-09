<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Mail\VerifyMail;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
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
            $frontendUrl = 'http://127.0.0.1:4200';
            return (new MailMessage)
                ->subject('Reset Password')
                ->view('mail.password_reset', [
                    'name' => $user->name,
                    'url' => sprintf('%s/password_reset/%s', $frontendUrl, $token)
            ]);
        });

        VerifyEmail::createUrlUsing(function ($notifiable) {
            $frontendUrl = 'http://127.0.0.1:4200/email/verify/';

            $verifyUrl = URL::temporarySignedRoute(
                'verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return $frontendUrl . urlencode($verifyUrl);
        });
    }
}
