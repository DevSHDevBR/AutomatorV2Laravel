<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\DB;
  // use App\Models\SysMenusItemsAccess;
  // use App\Models\SysMenusItemAccess;
  // use App\Models\SysMenusItem;
  // use App\Models\SysRoute;



  class SysMenusItemsSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {
      
      $sidebar = [
        
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
            'tbl_sys_route_ID'            => 'admin-posts-categories',
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

          ],
        ]

      ];


      foreach ($sidebar as $item) {


          $usersRules = $item['user_rules'];
          $usersTypes = $item['user_types'];
          $submenus   = $item['submenus'];


          unset($item['user_rules']);
          unset($item['user_types']);
          unset($item['submenus']);



          /*
          |--------------------------------------------------------------------------
          | Criar item principal do menu
          |--------------------------------------------------------------------------
          */

          $sideItemID = DB::table('tbl_sys_menu_items')
              ->insertGetId($item);



          /*
          |--------------------------------------------------------------------------
          | Permissões por tipo de usuário
          |--------------------------------------------------------------------------
          */

          foreach ($usersTypes as $userTypeID) {


              DB::table('tbl_sys_menus_items_access')
                  ->insert([

                      'tbl_users_type_ID'    => $userTypeID,
                      'tbl_sys_menu_item_ID' => $sideItemID,

                  ]);


          }



          /*
          |--------------------------------------------------------------------------
          | Regras de acesso
          |--------------------------------------------------------------------------
          */

          foreach ($usersRules as $userRuleID) {


              DB::table('tbl_sys_menu_item_access')
                  ->insert([

                      'tbl_users_type_ID'    => $userRuleID,
                      'tbl_sys_menu_item_ID' => $sideItemID,

                  ]);


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

              $SUBsideItemID = DB::table('tbl_sys_menu_items')
                  ->insertGetId($submenu);




              /*
              |--------------------------------------------------------------------------
              | Permissões do submenu
              |--------------------------------------------------------------------------
              */

              foreach ($SUBusersTypes as $SUBuserTypeID) {


                  DB::table('tbl_sys_menus_items_access')
                      ->insert([

                          'tbl_users_type_ID'    => $SUBuserTypeID,
                          'tbl_sys_menu_item_ID' => $SUBsideItemID,

                      ]);


              }



              foreach ($SUBusersRules as $SUBuserRuleID) {


                  DB::table('tbl_sys_menu_item_access')
                      ->insert([

                          'tbl_users_type_ID'    => $SUBuserRuleID,
                          'tbl_sys_menu_item_ID' => $SUBsideItemID,

                      ]);


              }


          }


      }
      // foreach ($sidebar as $item) {

      //   $users_rules = $item['user_rules'];
      //   $users_types = $item['user_types'];
      //   $submenus    = $item['submenus'];
      //   unset($item['user_rules']);
      //   unset($item['user_types']);
      //   unset($item['submenus']);
        
      //   $sideItem = SysMenusItem::create($item);

      //   $sideItemID = $sideItem->getKey();

      //   foreach ($users_types as $userTypeID) {

      //     SysMenusItemsAccess::create([

      //       'tbl_users_type_ID'     => $userTypeID,
      //       'tbl_sys_menu_item_ID'  => $sideItemID,

      //     ]);
          
      //   }


      //   foreach ($users_rules as $userRuleID) {

      //     SysMenusItemAccess::create([

      //       'tbl_users_type_ID'     => $userRuleID,
      //       'tbl_sys_menu_item_ID'  => $sideItemID,

      //     ]);
          
      //   }


      //   foreach ($submenus as $submenu) {
          
      //     $SUBusers_rules = $submenu['user_rules'];
      //     $SUBusers_types = $submenu['user_types'];
      //     unset($submenu['user_rules']);
      //     unset($submenu['user_types']);

      //     $submenu['tbl_sys_menu_item_parent_id'] = $sideItemID;
          
      //     $SUBsideItem = SysMenusItem::create($submenu);

      //     $SUBsideItemID = $SUBsideItem->getKey();

      //     foreach ($SUBusers_types as $SUBuserTypeID) {

      //       SysMenusItemsAccess::create([

      //         'tbl_users_type_ID'     => $SUBuserTypeID,
      //         'tbl_sys_menu_item_ID'  => $SUBsideItemID,

      //       ]);
            
      //     }


      //     foreach ($SUBusers_rules as $SUBuserRuleID) {

      //       SysMenusItemAccess::create([

      //         'tbl_users_type_ID'     => $SUBuserRuleID,
      //         'tbl_sys_menu_item_ID'  => $SUBsideItemID,

      //       ]);
            
      //     }

      //   }

      // }


    }



  }