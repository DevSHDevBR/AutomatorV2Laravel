<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  use App\Models\SysMenu;



  class SysMenusSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {
      

      SysMenu::Create([

        'tbl_sys_nav_ID'      => 1,
        'tbl_sys_menu_title'  => 'Sidebar Menu Painel Administrativo',
        'tbl_sys_menu_index'  => '',
        'tbl_sys_menu_class'  => 'app-sidebar-menu',
        'tbl_sys_menu_locked' => true,

      ]);


      SysMenu::Create([

        'tbl_sys_nav_ID'      => 2,
        'tbl_sys_menu_title'  => 'Header Menu Painel Administrativo',
        'tbl_sys_menu_index'  => '',
        'tbl_sys_menu_class'  => 'dropdown-menu dropdown-menu-end shadow',
        'tbl_sys_menu_locked' => true,

      ]);


    }



  }
