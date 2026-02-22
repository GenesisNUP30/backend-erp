<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin1234'),
            'dni' => '22636097A',
            'telefono' => '600000000',
            'rol' => 'administrador',
            'fecha_alta' => '2024-01-11',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        User::create([
            'name' => 'Manuel García López',
            'username' => 'manugarcia',
            'email' => 'manuelgl94@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('encargado1234'),
            'dni' => '80270811Y',
            'telefono' => '635184792',
            'rol' => 'encargado',
            'fecha_alta' => '2024-02-05',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        // Recolectores
        User::create([
            'name' => 'Juan Pérez Martínez',
            'username' => 'juanperez',
            'email' => 'juanperez@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('juan1234'),
            'dni' => '78572852E',
            'telefono' => '634567890',
            'rol' => 'recolector',
            'fecha_alta' => '2024-02-21',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        User::create([
            'name' => 'Ana Martínez Fernández',
            'username' => 'anamartinez',
            'email' => 'anamarfer00@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('ana1234'),
            'dni' => '80851996G',
            'telefono' => '645678901',
            'rol' => 'recolector',
            'fecha_alta' => '2024-04-05',
            'fecha_baja' => '2025-01-20',
            'remember_token' => Str::random(20),
        ]);

        User::create([
            'name' => 'Luis Fernández Gómez',
            'username' => 'luisfernandez',
            'email' => 'luisfernandez47@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('luis1234'),
            'dni' => '12344458J',
            'telefono' => '659647012',
            'rol' => 'recolector',
            'fecha_alta' => '2024-06-18',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        User::create([
            'name' => 'Laura Gómez Ruiz',
            'username' => 'lauragr',
            'email' => 'lauragomez@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('laura1234'),
            'dni' => '48873334J',
            'telefono' => '667890123',
            'rol' => 'recolector',
            'fecha_alta' => '2024-07-30',
            'fecha_baja' => null,
            'remember_token' => Str::random(20),
        ]);

        User::create([
            'name' => 'Daniel Sánchez Díaz',
            'username' => 'danisanchez',
            'email' => 'danielsanchez@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('daniel1234'),
            'dni' => '08337620M',
            'telefono' => '654871234',
            'rol' => 'recolector',
            'fecha_alta' => '2024-01-10',
            'fecha_baja' => '2025-02-15',
            'remember_token' => Str::random(20),
        ]);
    }
}
