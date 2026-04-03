<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================================
        // USUARIO PROTEGIDO - Administrador Principal
        // ============================================================
        $admin = User::firstOrCreate(
            ['email' => 'joseforozco@gmail.com'],
            [
                'name' => 'José Francisco Orozco',
                'password' => Hash::make('Digital2019**'), // Cambiar en producción
                'celular' => '3025987676',
                'cargo' => 'Administrador del Sistema',
                'activo' => true,
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('administrador');
        $this->command->info("Usuario protegido creado: {$admin->email}");

        // ============================================================
        // USUARIOS DE PRUEBA
        // ============================================================

        // Auxiliar
        $auxiliar = User::firstOrCreate(
            ['email' => 'auxiliar@sigainv.test'],
            [
                'name' => 'Usuario Auxiliar',
                'password' => Hash::make('password'),
                'celular' => '3001111111',
                'cargo' => 'Auxiliar Administrativo',
                'activo' => true,
                'email_verified_at' => now(),
            ]
        );
        $auxiliar->assignRole('auxiliar');
        $this->command->info("Usuario auxiliar creado: {$auxiliar->email}");

        // Contador
        $contador = User::firstOrCreate(
            ['email' => 'contador@sigainv.test'],
            [
                'name' => 'Usuario Contador',
                'password' => Hash::make('password'),
                'celular' => '3002222222',
                'cargo' => 'Contador',
                'activo' => true,
                'email_verified_at' => now(),
            ]
        );
        $contador->assignRole('contador');
        $this->command->info("Usuario contador creado: {$contador->email}");

        // Vendedor
        $vendedor = User::firstOrCreate(
            ['email' => 'vendedor@sigainv.test'],
            [
                'name' => 'Usuario Vendedor',
                'password' => Hash::make('password'),
                'celular' => '3003333333',
                'cargo' => 'Vendedor',
                'activo' => true,
                'email_verified_at' => now(),
            ]
        );
        $vendedor->assignRole('vendedor');
        $this->command->info("Usuario vendedor creado: {$vendedor->email}");

        // Cliente de prueba
        $cliente = User::firstOrCreate(
            ['email' => 'cliente@sigainv.test'],
            [
                'name' => 'Cliente de Prueba',
                'password' => Hash::make('password'),
                'celular' => '3004444444',
                'cargo' => null,
                'activo' => true,
                'email_verified_at' => now(),
            ]
        );
        $cliente->assignRole('cliente');
        $this->command->info("Usuario cliente creado: {$cliente->email}");

        $this->command->info('Usuarios de prueba creados correctamente.');
        $this->command->warn('Contraseña por defecto para todos: "password"');
    }
}
