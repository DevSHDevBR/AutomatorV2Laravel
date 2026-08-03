<?php


  namespace Posts\Database\Seeders;

  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\DB;



  class PostsSysMenusItemsSeeder extends Seeder {
    


    private function createModuloRel($table, $column, $value) {

      DB::table('tbl_sys_modulos_rels')->insert([
        'tbl_sys_modulo_rel_name'   => 'posts',
        'tbl_sys_modulo_rel_table'  => $table,
        'tbl_sys_modulo_rel_column' => $column,
        'tbl_sys_modulo_rel_value'  => $value,
      ]);

    }



    /**
     * Run the database seeds.
     */
    public function run(): void {
      
      $sidebar = [

          [

              'tbl_sys_menu_ID'             => 1,
              'tbl_sys_menu_item_index'     => '',
              'tbl_sys_menu_item_icon'      => 'copy',
              'tbl_sys_menu_item_class'     => 'sidebar-link',
              'tbl_sys_menu_item_title'     => 'Posts',
              'tbl_sys_menu_item_type'      => 'button',
              'tbl_sys_menu_item_link'      => '',
              'tbl_sys_menu_item_props'     => json_encode([
                  'data-sidebar-title' => 'Posts'
              ]),
              'tbl_sys_menu_item_status'    => 'ativo',
              'tbl_sys_menu_item_parent_id' => 0,
              'tbl_sys_menu_item_locked'    => false,
              'tbl_sys_menu_item_admin'     => true,
              'tbl_sys_menu_item_ordem'     => 7,
              'user_rules'                  => [1],
              'user_types'                  => [1, 2],
              'submenus' => [

                  [

                      'tbl_sys_menu_ID'             => 1,
                      'tbl_sys_menu_item_index'     => '',
                      'tbl_sys_menu_item_icon'      => '',
                      'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
                      'tbl_sys_menu_item_title'     => 'Categorias',
                      'tbl_sys_menu_item_type'      => 'route',

                      // CORRIGIDO
                      'tbl_sys_route_ID'            => 'admin-post-categories',

                      'tbl_sys_menu_item_link'      => '',
                      'tbl_sys_menu_item_props'     => '',
                      'tbl_sys_menu_item_status'    => 'ativo',
                      'tbl_sys_menu_item_locked'    => false,
                      'tbl_sys_menu_item_admin'     => true,
                      'tbl_sys_menu_item_ordem'     => 1,
                      'user_rules'                  => [1],
                      'user_types'                  => [1, 2]

                  ],

                  [

                      'tbl_sys_menu_ID'             => 1,
                      'tbl_sys_menu_item_index'     => '',
                      'tbl_sys_menu_item_icon'      => '',
                      'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
                      'tbl_sys_menu_item_title'     => 'Posts',
                      'tbl_sys_menu_item_type'      => 'route',
                      'tbl_sys_route_ID'            => 'admin-post',
                      'tbl_sys_menu_item_link'      => '',
                      'tbl_sys_menu_item_props'     => '',
                      'tbl_sys_menu_item_status'    => 'ativo',
                      'tbl_sys_menu_item_locked'    => false,
                      'tbl_sys_menu_item_admin'     => true,
                      'tbl_sys_menu_item_ordem'     => 2,
                      'user_rules'                  => [1],
                      'user_types'                  => [1, 2]

                  ]

              ]

          ]

      ];


      foreach ($sidebar as $item) {


          $usersRules = $item['user_rules'];
          $usersTypes = $item['user_types'];
          $submenus   = $item['submenus'];


          unset($item['user_rules']);
          unset($item['user_types']);
          unset($item['submenus']);

          if (isset($item['tbl_sys_route_ID'])) {

              $item['tbl_sys_route_ID'] = DB::table('tbl_sys_routes')
                  ->where('tbl_sys_route_name', $item['tbl_sys_route_ID'])
                  ->value('tbl_sys_route_ID');
          }


          /*
          |--------------------------------------------------------------------------
          | Criar item principal do menu
          |--------------------------------------------------------------------------
          */

          $sideItemID = DB::table('tbl_sys_menus_items')->insertGetId($item);

          $this->createModuloRel('tbl_sys_menus_items', 'tbl_sys_menu_item_ID', $sideItemID);



          /*
          |--------------------------------------------------------------------------
          | Permissões por tipo de usuário
          |--------------------------------------------------------------------------
          */

          foreach ($usersTypes as $userTypeID) {


              $userType = DB::table('tbl_sys_menus_access')->insertGetId([ 'tbl_users_type_ID' => $userTypeID, 'tbl_sys_menu_item_ID' => $sideItemID]);
            
              $this->createModuloRel('tbl_sys_menus_access', 'tbl_menus_access_ID', $userType);


          }



          /*
          |--------------------------------------------------------------------------
          | Regras de acesso
          |--------------------------------------------------------------------------
          */

          foreach ($usersRules as $userRuleID) {


              $userRule = DB::table('tbl_sys_menus_item_access')->insertGetId(['tbl_users_type_ID' => $userRuleID, 'tbl_sys_menu_item_ID' => $sideItemID]);

              $this->createModuloRel('tbl_sys_menus_item_access', 'tbl_menus_item_access_ID', $userRule);


          }




          /*
          |--------------------------------------------------------------------------
          | Criar submenus
          |--------------------------------------------------------------------------
          */

          foreach ($submenus as $submenu) {


              $SUBusersRules = $submenu['user_rules'];
              $SUBusersTypes = $submenu['user_types'];


              unset($submenu['user_rules']);
              unset($submenu['user_types']);



              /*
              |--------------------------------------------------------------------------
              | Buscar rota pelo nome
              |--------------------------------------------------------------------------
              */

              if(isset($submenu['tbl_sys_route_ID'])) {


                  $submenu['tbl_sys_route_ID'] = DB::table('tbl_sys_routes')
                      ->where(
                          'tbl_sys_route_name',
                          $submenu['tbl_sys_route_ID']
                      )
                      ->value('tbl_sys_route_ID');


              }



              /*
              |--------------------------------------------------------------------------
              | Definir pai do submenu
              |--------------------------------------------------------------------------
              */

              $submenu['tbl_sys_menu_item_parent_id'] = $sideItemID;



              /*
              |--------------------------------------------------------------------------
              | Criar submenu
              |--------------------------------------------------------------------------
              */

              $SUBsideItemID = DB::table('tbl_sys_menus_items')->insertGetId($submenu);

              $this->createModuloRel('tbl_sys_menus_items', 'tbl_sys_menu_item_ID', $SUBsideItemID);



              /*
              |--------------------------------------------------------------------------
              | Permissões do submenu
              |--------------------------------------------------------------------------
              */

              foreach ($SUBusersTypes as $SUBuserTypeID) {


                  $userType = DB::table('tbl_sys_menus_access')->insertGetId(['tbl_users_type_ID'    => $SUBuserTypeID, 'tbl_sys_menu_item_ID' => $SUBsideItemID]);

                  $this->createModuloRel('tbl_sys_menus_access', 'tbl_menus_access_ID', $userType);


              }



              foreach ($SUBusersRules as $SUBuserRuleID) {


                $userRule = DB::table('tbl_sys_menus_item_access')->insertGetId(['tbl_users_type_ID' => $SUBuserRuleID, 'tbl_sys_menu_item_ID' => $SUBsideItemID]);

                $this->createModuloRel('tbl_sys_menus_item_access', 'tbl_menus_item_access_ID', $userRule);


              }


          }


      }


    }



  }