<?php



  namespace Database\Seeders;


  use Illuminate\Database\Seeder;

  use App\Models\SysShortcode;



  class SysShortcodesSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {
      

      $shortcodes = [

        [

          'tbl_sys_shortcode_code'        => 'automator',
          'tbl_sys_shortcode_title'       => 'Automator',
          'tbl_sys_shortcode_description' => 'Função nativa do sistema para gerar e carregar de forma dinamica as ações do sistema.',
          'tbl_sys_shortcode_class'       => 'AutomatorController',
          'tbl_sys_shortcode_method'      => 'getFunction',
          'tbl_sys_shortcode_params'      => json_encode([

            "function" => true,
            "name"     => false,
            "form"     => false,
            "table"    => false,
            "index"    => false,

          ]),
          'tbl_sys_shortcode_locked'      => true,

        ],

        [

          'tbl_sys_shortcode_code'        => 'system-pages',
          'tbl_sys_shortcode_title'       => 'Carregador de view',
          'tbl_sys_shortcode_description' => 'Função nativa do sistema para carregar de forma dinamica as views dentro do sistema.',
          'tbl_sys_shortcode_class'       => 'SystemController',
          'tbl_sys_shortcode_method'      => 'SystemLoadPageContent',
          'tbl_sys_shortcode_params'      => json_encode([

            "view" => true,
            "vars" => false,
            "args" => false,
            
          ]),
          'tbl_sys_shortcode_locked'      => true,

        ],

        [

          'tbl_sys_shortcode_code'        => 'system-form',
          'tbl_sys_shortcode_title'       => 'Formulário do sistema',
          'tbl_sys_shortcode_description' => 'Função nativa do sistema para gerar e renderizar de forma dinamica os formulários registrados no sistema.',
          'tbl_sys_shortcode_class'       => 'SysAutomator',
          'tbl_sys_shortcode_method'      => 'SysAutomatorRenderFormByID',
          'tbl_sys_shortcode_params'      => json_encode([

            "form" => true,
            "vars" => false,

          ]),
          'tbl_sys_shortcode_locked'      => true,

        ],

      ];


      foreach ($shortcodes as $shortcode) {

        SysShortcode::Create($shortcode);
        
      }


    }



  }
