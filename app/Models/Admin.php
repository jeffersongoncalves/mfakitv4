<?php

namespace App\Models;

use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthenticationRecovery;
use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use JeffersonGoncalves\Filament\Admin\Models\Admin as BaseAdmin;
use JeffersonGoncalves\Filament\MultiFactorPasskeys\Contracts\HasPasskeyAuthentication;
use JeffersonGoncalves\Filament\MultiFactorWhatsApp\Contracts\HasWhatsAppAuthentication;
use Spatie\LaravelPasskeys\Models\Concerns\InteractsWithPasskeys;

/**
 * Base columns, casts, factory, observer, admin guard, Filament panel access and avatar come from
 * jeffersongoncalves/laravel-admin + jeffersongoncalves/filament-admin.
 * Multi-factor authentication (app, email, WhatsApp, passkeys) lives here.
 *
 * @property string|null $phone
 * @property bool $has_whatsapp_authentication
 * @property string|null $app_authentication_secret
 * @property array<array-key, mixed>|null $app_authentication_recovery_codes
 * @property bool $has_email_authentication
 */
class Admin extends BaseAdmin implements HasAppAuthentication, HasAppAuthenticationRecovery, HasEmailAuthentication, HasPasskeyAuthentication, HasWhatsAppAuthentication
{
    use InteractsWithPasskeys;

    protected $fillable = [
        'status',
        'name',
        'email',
        'password',
        'avatar_url',
        'custom_fields',
        'locale',
        'theme_color',
        'phone',
        'has_whatsapp_authentication',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'app_authentication_secret',
        'app_authentication_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            ...parent::casts(),
            'has_whatsapp_authentication' => 'boolean',
            'app_authentication_secret' => 'encrypted',
            'app_authentication_recovery_codes' => 'encrypted:array',
            'has_email_authentication' => 'boolean',
        ];
    }

    public function hasPasskeyAuthentication(): bool
    {
        return $this->passkeys()->exists();
    }

    public function hasWhatsAppAuthentication(): bool
    {
        return $this->has_whatsapp_authentication;
    }

    public function toggleWhatsAppAuthentication(bool $condition): void
    {
        $this->has_whatsapp_authentication = $condition;
        $this->save();
    }

    public function getAppAuthenticationSecret(): ?string
    {
        return $this->app_authentication_secret;
    }

    public function saveAppAuthenticationSecret(?string $secret): void
    {
        $this->app_authentication_secret = $secret;
        $this->save();
    }

    public function getAppAuthenticationHolderName(): string
    {
        return $this->email;
    }

    public function getAppAuthenticationRecoveryCodes(): ?array
    {
        return $this->app_authentication_recovery_codes;
    }

    public function saveAppAuthenticationRecoveryCodes(?array $codes): void
    {
        $this->app_authentication_recovery_codes = $codes;
        $this->save();
    }

    public function hasEmailAuthentication(): bool
    {
        return $this->has_email_authentication;
    }

    public function toggleEmailAuthentication(bool $condition): void
    {
        $this->has_email_authentication = $condition;
        $this->save();
    }
}
