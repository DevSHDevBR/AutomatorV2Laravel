<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;

  use App\Helpers\SysAutomator;
  use App\Models\SysRoute;
  use App\Models\SysNav;
  use App\Models\SysMenu;
  use App\Models\SysMenusItem;
  use App\Models\SysMenusItemsAccess;
  use App\Models\UsersType;
  use App\Models\User;



  class MenusController extends Controller {



    public function index(Request $request) {


      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);


      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first()->toArray();

      if(!Auth::check()) {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('page.admin-login')->with('status', 'Sessão expirada!');

      } else {

        // $_user = Auth::user();

        // $currentUser = [

        //   'tbl_user_ID'    => $_user->tbl_user_ID,
        //   'tbl_user_name'  => $_user->tbl_user_name,
        //   'tbl_user_email' => $_user->tbl_user_email,
        
        // ];

        $navs  = SysNav::get()->toArray();
        $menus = SysMenu::get()->toArray();

        // unset(session('currentMenu'));
        // $currentMenu = ( (isset(session('currentMenu'))) ? ( (session('currentMenu') != '') ? ( (session('currentMenu') != null) ? session('currentMenu') : array_key_first($menus) ) : array_key_first($menus) ) : array_key_first($menus) );
        if(session('currentMenu') !== null) {

          $currentMenu = session('currentMenu');

        } else {

          $currentMenu = $menus[0]['tbl_sys_menu_ID'];
          session(['currentMenu' => $currentMenu]);

        }


        $paginas = [];
        $pages   = [];
        
        $allPages = SysRoute::all()->keyBy('tbl_pagina_ID');
        $avaliblePages = SysRoute::where('tbl_sys_route_api', false)->get();

        foreach($avaliblePages as $page) {

          if(!in_array($page->tbl_sys_route_ID, $pages)) {

            $pages[]   = $page->tbl_sys_route_ID;
            $paginas[] = $page;

          }

        }

        $user = Auth::user();

        $userTypesIDs = [];

        if ($user !== null && method_exists($user, 'UserGetTypesIDs')) {

          $userTypesIDs = $user->UserGetTypesIDs();

        }


        $variaveis = [

          'adminMenuPage' => [

            'currentMenu' => $currentMenu,
            'routes'      => [

              'select'      => SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-menus-select', true),
              'menu-update' => SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-menus-update', true)

            ],
            // 'usersTypes'  => UsersType::where('tbl_users_type_status', 'ativo')->get()->toArray(),
            'usersTypes'  => UsersType::where('tbl_users_type_status', 'ativo')->pluck('tbl_users_type_name', 'tbl_users_type_ID')->toArray(),
            'user'        => [

              'tbl_user_ID' => $user->tbl_user_ID,
              'tbl_user_types_IDs' => $userTypesIDs

            ],

            'navs'        => $navs,
            'menus'       => $menus,
            'paginas'     => $paginas,
            'textos'      => [
              
              'create-new-menu'             => 'Criar novo menu',
              'select-menu'                 => 'Selecionar Menu',
              'menu-name'                   => 'Nome do menu',
              'menu-id'                     => 'ID do Menu',
              'menu-class'                  => 'Classes do Menu',
              'menu-nav'                    => 'Posição Atual',
              'save-data'                   => 'Salvar Alterações',
              'add-menu-item'               => 'Adicionar Item',
              'status-ativo'                => 'ativo',
              'status-inativo'              => 'inativo',
              'edit-menu'                   => 'Editar menu',
              'add-submenu-item'            => 'Adicionar submenu',
              'collapse-menu'               => 'Expandir / Recolher',
              'no-submenus'                 => 'Sem submenu(s)',
              'remove-menu'                 => 'Remover menu',
              'remove-menu-off'             => 'Você não tem autorização para realizar esta ação',
              'menu-rotulo'                 => 'Rótulo de Navegação',
              'menu-status'                 => 'Status',
              'menu-item-id'                => 'ID do Item',
              'menu-item-classes'           => 'Classes do Item',
              'menu-item-type'              => 'Tipo do Item',
              'page'                        => 'Página',
              'link'                        => 'Link',
              'button'                      => 'Botão',
              'divider'                     => 'Divisor',
              'select'                      => 'Selecione',
              'icon'                        => 'Ícone',
              'icon-search'                 => 'Pesquisar ícone...',
              'admin-area'                  => 'Área Administrativa',
              'admin-locked'                => 'Exclusão Proibida',
              'yes'                         => 'Sim',
              'no'                          => 'Não',
              'permissions'                 => 'Permissões de acesso',
              'selected'                    => 'Selecionado(s)',
              'no-props-found-in-menu-item' => 'Nenhuma propriedade registrada!',
              'props'                       => 'Propriedades',
              'add-prop'                    => 'Adicionar Propriedade',
              'menu-prop-name'              => 'Nome da propriedade',
              'menu-prop-value'             => 'Valor da propriedade',
              'menu-prop-remove'            => 'Remover Propriedade',
              // 'menu-name'                   => ,

            ]

          ]

        ];

        // $textos['']
        // SysAutomator::SysAutomatorGetTranslateWord

        return SysAutomator::SysAutomatoRenderRouteContent2($slug, $variaveis, 'restrict');

      }

    }



    public function selectMenu(Request $request) {


      $ok = false;

      $menu = $request->input('menu');

      if(isset($menu)) {

        if($menu !== null) {

          if($menu != '') {

            $_menu = SysMenu::where('tbl_sys_menu_ID', $menu)->first();
            if($_menu) {

              if(session('currentMenu') !== null) {

                if(session('currentMenu') != $menu) {

                  session(['currentMenu' => $menu]);
                  $ok = true;

                } else {

                  $response['message'] = "O menu selecionado não foi alterado!";

                }

              } else {

                session(['currentMenu' => $menu]);
                $ok = true;

              }

            } else {

              $response['message'] = "Falha ao localizar menu";

            }

          }

        }

      }


      if($ok == true) {

        $response = [

          'status'       => true,
          'title'        => 'Sucesso',
          'message'      => 'Novo menu selecionado com sucesso',
          'redirect_url' => SysAutomator::SysAutomatorGetRouteLinkByName('admin-menus', true)

        ];

        $status = 200;

      } else {

        $response = [

          'status'  => false,
          'title'   => 'Erro',
          'message' => 'Falha ao selecionar menu'

        ];

        $status = 403;

      }


      return response()->json($response, $status);


    }



  }