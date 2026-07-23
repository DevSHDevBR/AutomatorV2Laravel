<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  use App\Models\SysMenusItemsAccess;
  use App\Models\SysMenusItemAccess;
  use App\Models\SysMenusItem;
  use App\Models\SysRoute;



  class SysMenusItemsSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {


      // [
      //   'tbl_sys_menu_ID' => '',
      //   'tbl_sys_menu_item_index' => '',
      //   'tbl_sys_menu_item_icon' => '',
      //   'tbl_sys_menu_item_class' => '',
      //   'tbl_sys_menu_item_title' => '',
      //   'tbl_sys_menu_item_type' => '',
      //   'tbl_sys_route_ID' => '',
      //   'tbl_sys_menu_item_link' => '',
      //   'tbl_sys_menu_item_props' => '',
      //   'tbl_sys_menu_item_status' => '',
      //   'tbl_sys_menu_item_parent_id' => '',
      //   'tbl_sys_menu_item_ordem' => ''
      // ]

      $sidebar = [

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'gauge',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Dashboard',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-dashboard'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Dashboard'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 1,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2, 3, 4]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'bell',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Notificações',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-notificacoes'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Notificações'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_ordem'     => 2,
          'user_rules'                  => [1, 2],
          'user_types'                  => [1, 2, 3, 4]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'user',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Minha Conta',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-minha-conta'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Minha Conta'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_ordem'     => 3,
          'user_rules'                  => [1, 2],
          'user_types'                  => [1, 2, 3, 4]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'image',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Galeria',
          'tbl_sys_menu_item_type'      => 'button',
          // 'tbl_sys_route_ID'            => '',
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Galeria'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 4,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Tipos de Midia',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-galeria-uploads-types'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 4,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 5,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Uploads',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-galeria-uploads'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 4,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 6,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'shield-halved',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Administração',
          'tbl_sys_menu_item_type'      => 'button',
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Administração'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 7,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Rotas de API',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-routes-apis'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 7,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 8,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Páginas',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-routes'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 7,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 9,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Navegação',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-navs'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 7,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 10,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Menus',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-menus'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 7,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 11,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'users',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Usuários',
          'tbl_sys_menu_item_type'      => 'button',
          // 'tbl_sys_route_ID'            => '',
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Usuários'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 12,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Tipos de Usuários',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-users-types'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 12,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 13,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Usuários',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-users'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 12,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 14,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],
        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Notificações',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-notifications'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 12,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 15,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'language',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Idiomas',
          'tbl_sys_menu_item_type'      => 'button',
          // 'tbl_sys_route_ID'            => '',
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Idiomas'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 16,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Idiomas',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-languages'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 16,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 17,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Traduções',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-languages-words'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 16,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 18,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'layer-group',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Automator',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-automator'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Automator'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 19,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],


        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Campos',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-fields'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 19,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 20,
          'user_rules'                  => [1],
          'user_types'                  => [1]

        ],


        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Módulos',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-modulos'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 19,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 21,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Formulários',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-forms'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 19,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 22,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Paginações',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-paginations'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 19,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 23,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],


        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Shortcodes',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-shortcodes'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 19,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 24,
          'user_rules'                  => [1],
          'user_types'                  => [1]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
          'tbl_sys_menu_item_title'     => 'Funções',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-functions'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 19,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 25,
          'user_rules'                  => [1],
          'user_types'                  => [1]

        ],


        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'cog',
          'tbl_sys_menu_item_class'     => 'sidebar-link',
          'tbl_sys_menu_item_title'     => 'Configurações',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-configs'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => json_encode([
            'data-sidebar-title' => 'Configurações'
          ]),
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 26,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2]

        ],

        [
          
          'tbl_sys_menu_ID'             => 1,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => 'right-from-bracket',
          'tbl_sys_menu_item_class'     => 'sidebar-btn',
          'tbl_sys_menu_item_title'     => 'Sair',
          'tbl_sys_menu_item_type'      => 'button',
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '{"class": "btn-logout-system sidebar-link", "data-sidebar-title": "Sair"}',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 27,
          'user_rules'                  => [1, 2],
          'user_types'                  => [1, 2, 3, 4]

        ],

      ];


      $header = [

        [
          
          'tbl_sys_menu_ID'             => 2,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'dropdown-item py-2',
          'tbl_sys_menu_item_title'     => 'Minha Conta',
          'tbl_sys_menu_item_type'      => 'route',
          'tbl_sys_route_ID'            => SysRoute::getRouteIDByName('admin-minha-conta'),
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 1,
          'user_rules'                  => [1, 2],
          'user_types'                  => [1, 2, 3, 4]

        ],
        [
          
          'tbl_sys_menu_ID'             => 2,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => '',
          'tbl_sys_menu_item_title'     => 'Divisor',
          'tbl_sys_menu_item_type'      => 'divider',
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => false,
          'tbl_sys_menu_item_admin'     => false,
          'tbl_sys_menu_item_ordem'     => 2,
          'user_rules'                  => [1, 2],
          'user_types'                  => [1, 2, 3, 4]

        ],
        [
          
          'tbl_sys_menu_ID'             => 2,
          'tbl_sys_menu_item_index'     => '',
          'tbl_sys_menu_item_icon'      => '',
          'tbl_sys_menu_item_class'     => 'dropdown-item p-0',
          'tbl_sys_menu_item_title'     => 'Sair',
          'tbl_sys_menu_item_type'      => 'button',
          // 'tbl_sys_route_ID'            => '',
          'tbl_sys_menu_item_link'      => '',
          'tbl_sys_menu_item_props'     => '{"class": "btn-logout-system btn-header-painel p-2"}',
          'tbl_sys_menu_item_status'    => 'ativo',
          'tbl_sys_menu_item_parent_id' => 0,
          'tbl_sys_menu_item_locked'    => true,
          'tbl_sys_menu_item_admin'     => true,
          'tbl_sys_menu_item_ordem'     => 3,
          'user_rules'                  => [1],
          'user_types'                  => [1, 2, 3, 4]

        ],

      ];


      foreach ($sidebar as $item) {

        $users_rules = $item['user_rules'];
        $users_types = $item['user_types'];
        unset($item['user_rules']);
        unset($item['user_types']);
        
        $sideItem = SysMenusItem::create($item);

        $sideItemID = $sideItem->getKey();

        foreach ($users_types as $userTypeID) {

          SysMenusItemsAccess::create([

            'tbl_users_type_ID'     => $userTypeID,
            'tbl_sys_menu_item_ID'  => $sideItemID,

          ]);
          
        }


        foreach ($users_rules as $userRuleID) {

          SysMenusItemAccess::create([

            'tbl_users_type_ID'     => $userRuleID,
            'tbl_sys_menu_item_ID'  => $sideItemID,

          ]);
          
        }

      }


      foreach ($header as $item2) {

        $users_rules = $item2['user_rules'];
        $users_types = $item2['user_types'];
        unset($item2['user_rules']);
        unset($item2['user_types']);
        

        $headerItem = SysMenusItem::create($item2);

        $headerItemID = $headerItem->getKey();

        foreach ($users_types as $userTypeID) {

          SysMenusItemsAccess::create([

            'tbl_users_type_ID'     => $userTypeID,
            'tbl_sys_menu_item_ID'  => $headerItemID,

          ]);
          
        }
        

        foreach ($users_rules as $userRuleID) {

          SysMenusItemAccess::create([

            'tbl_users_type_ID'     => $userRuleID,
            'tbl_sys_menu_item_ID'  => $headerItemID,

          ]);
          
        }

      }

      // SysMenusItem::Create([

      //   'tbl_sys_nav_ID'      => 1,
      //   'tbl_sys_menu_title'  => 'Sidebar Painel Administrativo',
      //   'tbl_sys_menu_index'  => '',
      //   'tbl_sys_menu_class'  => 'app-sidebar-menu',
      //   'tbl_sys_menu_locked' => true,

      // ]);


    }



  }
