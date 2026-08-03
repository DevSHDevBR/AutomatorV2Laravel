<?php
namespace Posts\Database\Seeders;

use Illuminate\Database\Seeder;

class PostsDatabaseSeeder extends Seeder {
    public function run(): void {
        // Defina a ordem exata aqui
        $this->call([
            PostsSysRoutesSeeder::class,
            PostsSysMenusItemsSeeder::class,
            PostsSysFormsSeeder::class,
            PostsSysPaginationsSeeder::class,
            PostsCategorieSeeder::class,
            PostsSysViewsSeeder::class,
        ]);
    }
}