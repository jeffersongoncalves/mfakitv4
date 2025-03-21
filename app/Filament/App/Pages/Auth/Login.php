<?php

namespace App\Filament\App\Pages\Auth;

class Login extends \Filament\Pages\Auth\Login
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => true,
        ];
    }
}
