<?php


  namespace Database\Seeders;

  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;

  use App\Models\SysFieldTypesGroup;



  class SysFieldTypesGroupsSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {
      

      $grupos = [
        
        [

          'tbl_sys_field_type_group_name'   => 'basic',
          'tbl_sys_field_type_group_title'  => 'Básico',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 1,
        
        ],

        [

          'tbl_sys_field_type_group_name'   => 'content',
          'tbl_sys_field_type_group_title'  => 'Conteúdo',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 2,
        
        ],

        [

          'tbl_sys_field_type_group_name'   => 'choose',
          'tbl_sys_field_type_group_title'  => 'Escolha',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 3,
        
        ],

        [

          'tbl_sys_field_type_group_name'   => 'relations',
          'tbl_sys_field_type_group_title'  => 'Relacional',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 4,
        
        ],

        [

          'tbl_sys_field_type_group_name'   => 'layout',
          'tbl_sys_field_type_group_title'  => 'Layout',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 5,
        
        ],

        [

          'tbl_sys_field_type_group_name'   => 'advanced',
          'tbl_sys_field_type_group_title'  => 'Avançado',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 7,
        
        ],

        [

          'tbl_sys_field_type_group_name'   => 'automator',
          'tbl_sys_field_type_group_title'  => 'Automator',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 8,
        
        ],

        [

          'tbl_sys_field_type_group_name'   => 'card',
          'tbl_sys_field_type_group_title'  => 'Card',
          'tbl_sys_field_type_group_locked' => true,
          'tbl_sys_field_type_group_ordem'  => 6,
        
        ],

      ];


      foreach ($grupos as $grupo) {
        
        SysFieldTypesGroup::Create($grupo);

      }


    }



  }
