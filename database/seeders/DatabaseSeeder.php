<?php

  namespace Database\Seeders;

  use Illuminate\Database\Seeder;



  class DatabaseSeeder extends Seeder {
    


    /**
     * Seed the application's database.
     */
    public function run(): void {
    

      $this->call([

        SysFunctionsSeeder::class,
        SysTranslationsSeeder::class,
        SysConfigsSeeder::class,
        UsersTypesSeeder::class,
        UsersSeeder::class,
        UsersTypesRelsSeeder::class,
        SysFieldTypesGroupsSeeder::class,
        SysFieldTypesSeeder::class,
        SysRoutesSeeder::class,
        SysNavsSeeder::class,
        SysMenusSeeder::class,
        SysMenusItemsSeeder::class,
        SysFormsSeeder::class,
        SysShortcodesSeeder::class,
        SysPaginationsSeeder::class

      ]);

    
    }
  


  }
