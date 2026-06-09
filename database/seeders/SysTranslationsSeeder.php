<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  use App\Models\SysTranslation;

  

  class SysTranslationsSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {
      

      SysTranslation::Create([

        'tbl_sys_translation_key'         => 'pt-br',
        'tbl_sys_translation_name'        => 'Português (Brasil)',
        'tbl_sys_translation_description' => 'Português do Brasil',
        'tbl_sys_translation_locked'      => true

      ]);


    }



  }
