<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CiudadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $this->call([
            \Database\Seeders\ciudades\AmazonasSeeder::class,
            \Database\Seeders\ciudades\AntioquiaSeeder::class,
            \Database\Seeders\ciudades\AraucaSeeder::class,
            \Database\Seeders\ciudades\AtlanticoSeeder::class, 
            \Database\Seeders\ciudades\BogotaSeeder::class,
            \Database\Seeders\ciudades\BolivarSeeder::class,
            \Database\Seeders\ciudades\BoyacaSeeder::class,
            \Database\Seeders\ciudades\CaldasSeeder::class,
            \Database\Seeders\ciudades\CaquetaSeeder::class,
            \Database\Seeders\ciudades\CasanareSeeder::class,
            \Database\Seeders\ciudades\CaucaSeeder::class,
            \Database\Seeders\ciudades\CesarSeeder::class,
            \Database\Seeders\ciudades\ChocoSeeder::class,
            \Database\Seeders\ciudades\CordobaSeeder::class,
            \Database\Seeders\ciudades\CundinamarcaSeeder::class,
            \Database\Seeders\ciudades\GuainiaSeeder::class,
            \Database\Seeders\ciudades\GuaviareSeeder::class,
            \Database\Seeders\ciudades\HuilaSeeder::class,
            \Database\Seeders\ciudades\LaGuajiraSeeder::class,
            \Database\Seeders\ciudades\MagdalenaSeeder::class,
            \Database\Seeders\ciudades\MetaSeeder::class,
            \Database\Seeders\ciudades\NarinoSeeder::class,
            \Database\Seeders\ciudades\NorteDeSantanderSeeder::class,
            \Database\Seeders\ciudades\PutumayoSeeder::class,
            \Database\Seeders\ciudades\QuindioSeeder::class,
            \Database\Seeders\ciudades\RisaraldaSeeder::class,
            \Database\Seeders\ciudades\SanAndresSeeder::class,
            \Database\Seeders\ciudades\SantanderSeeder::class,
            \Database\Seeders\ciudades\SucreSeeder::class,
            \Database\Seeders\ciudades\TolimaSeeder::class,
            \Database\Seeders\ciudades\ValleDelCaucaSeeder::class,
            \Database\Seeders\ciudades\VaupesSeeder::class,
            \Database\Seeders\ciudades\VichadaSeeder::class,
        ]);
        
    }
}
