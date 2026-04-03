<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function mount(): void
    {
        parent::mount();

        if (session()->has('registro_pendiente')) {
            Notification::make()
                ->title('Solicitud enviada exitosamente')
                ->body(session()->pull('registro_pendiente'))
                ->success()
                ->persistent()
                ->send();
        }
    }

    public function authenticate(): ?LoginResponse
    {
        // Verificar si el usuario tiene credenciales válidas pero la cuenta está inactiva
        $email    = $this->data['email'] ?? null;
        $password = $this->data['password'] ?? null;

        if ($email && $password) {
            $user = User::where('email', $email)->first();

            if ($user && ! $user->activo && Hash::check($password, $user->password)) {
                $mensaje = $user->roles->isEmpty()
                    ? 'Tu cuenta está pendiente de aprobación por un administrador.'
                    : 'Tu cuenta ha sido desactivada. Contacta al administrador para reactivarla.';

                throw ValidationException::withMessages([
                    'data.email' => $mensaje,
                ]);
            }
        }

        return parent::authenticate();
    }
}
