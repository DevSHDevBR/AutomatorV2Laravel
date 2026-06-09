<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  use App\Models\SysNav;



  class SysNavsSeeder extends Seeder {
      


    /**
     * Run the database seeds.
     */
    public function run(): void {


      SysNav::Create([

        'tbl_sys_nav_name'   => 'admin-sidebar',
        'tbl_sys_nav_title'  => 'Sidebar Painel Administrativo',
        'tbl_sys_nav_admin'  => true,
        'tbl_sys_nav_locked' => true,

      ]);


      SysNav::Create([

        'tbl_sys_nav_name'   => 'admin-header',
        'tbl_sys_nav_title'  => 'Header Menu Painel Administrativo',
        'tbl_sys_nav_admin'  => true,
        'tbl_sys_nav_locked' => true,

      ]);

      
    }



  }
