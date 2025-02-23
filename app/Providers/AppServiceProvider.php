<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Email Anda')
                ->greeting('Halo ' . $notifiable->username . ',')
                ->line('Terima kasih telah mendaftar! Sebelum Anda dapat menggunakan akun Anda, kami perlu memastikan bahwa email ini benar-benar milik Anda.')
                ->line('Silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:')
                ->action('Verifikasi Email', $url)
                ->line('Jika Anda tidak merasa mendaftar di aplikasi kami, abaikan email ini.')
                ->salutation('Salam, Tim Kami');
        });
    }
}
