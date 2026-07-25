<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Schema;
  use Illuminate\Support\Facades\Log;

  use App\Helpers\SysAutomator;
  use App\Models\SysRoute;
  use App\Models\SysNav;
  use App\Models\SysMenu;
  use App\Models\SysMenusItem;
  use App\Models\SysMenusItemsAccess;
  use App\Models\SysMenusItemAccess;
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



    // private function menuEditorDeleteItem(
    //   SysMenusItem $menuItem
    // ) {


    //   $menuItemID =

    //     $menuItem->tbl_sys_menu_item_ID;


    //   SysMenusItemsAccess::where(

    //     'tbl_sys_menu_item_ID',

    //     $menuItemID

    //   )->delete();


    //   SysMenusItemAccess::where(

    //     'tbl_sys_menu_item_ID',

    //     $menuItemID

    //   )->delete();


    //   $menuItem->delete();


    //   return true;


    // }



    private function menuEditorBoolean(
      $value
    ) {


      return in_array(

        $value,

        [

          true,
          1,
          '1',
          'true',
          'TRUE',
          'sim',
          'SIM',

        ],

        true

      );


    }


    private function menuEditorNormalizeItemID(
      $value
    ) {


      if(

        $value === null ||

        $value === ''

      ) {

        return null;

      }


      if(

        is_int($value) ||

        (

          is_string($value) &&

          ctype_digit(

            trim(

              $value

            )

          )

        )

      ) {


        $value = (int) $value;


        if($value > 0) {

          return $value;

        }


      }


      return null;


    }


    private function menuEditorNormalizeAccess(
      $access
    ) {


      if(

        $access === null ||

        $access === ''

      ) {

        return [];

      }


      if(!is_array($access)) {

        $access = [

          $access

        ];

      }


      $normalized = [];


      foreach($access as $usersTypeID) {


        $usersTypeID =

          $this->menuEditorNormalizeItemID(

            $usersTypeID

          );


        if($usersTypeID === null) {

          continue;

        }


        if(

          !UsersType::where(

            'tbl_users_type_ID',

            $usersTypeID

          )->exists()

        ) {

          continue;

        }


        if(

          !in_array(

            $usersTypeID,

            $normalized,

            true

          )

        ) {

          $normalized[] =

            $usersTypeID;

        }


      }


      return $normalized;


    }


    private function menuEditorNormalizeProps(
      $props
    ) {


      if(

        $props === null ||

        $props === ''

      ) {

        return '';

      }


      if(is_object($props)) {

        $props = (array) $props;

      }


      if(is_string($props)) {


        $decodedProps = json_decode(

          $props,

          true

        );


        if(is_array($decodedProps)) {

          $props = $decodedProps;

        } else {

          return '';

        }


      }


      if(!is_array($props)) {

        return '';

      }


      $normalizedProps = [];


      foreach($props as $propName => $propValue) {


        $propName = trim(

          (string) $propName

        );


        if($propName === '') {

          continue;

        }


        if(

          is_array($propValue) ||

          is_object($propValue)

        ) {


          $propValue = json_encode(

            $propValue,

            JSON_UNESCAPED_UNICODE |

            JSON_UNESCAPED_SLASHES

          );


        } elseif($propValue === null) {


          $propValue = '';


        } else {


          $propValue =

            (string) $propValue;


        }


        $normalizedProps[$propName] =

          $propValue;


      }


      if(count($normalizedProps) <= 0) {

        return '';

      }


      return json_encode(

        $normalizedProps,

        JSON_UNESCAPED_UNICODE |

        JSON_UNESCAPED_SLASHES

      );


    }


    private function menuEditorGetUserTypesIDs()
    {


      $user = Auth::user();


      if($user === null) {

        return [];

      }


      if(

        !method_exists(

          $user,

          'UserGetTypesIDs'

        )

      ) {

        return [];

      }


      $usersTypesIDs =

        $user->UserGetTypesIDs();


      if(!is_array($usersTypesIDs)) {

        $usersTypesIDs = [];

      }


      return array_values(

        array_unique(

          array_map(

            'intval',

            $usersTypesIDs

          )

        )

      );


    }


    private function menuEditorCanDeleteItem(
      $menuItemID,
      array $usersTypesIDs
    ) {


      if(

        $menuItemID === null ||

        $menuItemID === '' ||

        count($usersTypesIDs) <= 0

      ) {

        return false;

      }


      return SysMenusItemAccess::where(

        'tbl_sys_menu_item_ID',

        $menuItemID

      )
        ->whereIn(

          'tbl_users_type_ID',

          $usersTypesIDs

        )
        ->exists();


    }


    private function menuEditorUserIsDeveloper()
    {


      $usersTypesIDs =

        $this->menuEditorGetUserTypesIDs();


      if(count($usersTypesIDs) <= 0) {

        return false;

      }


      return UsersType::whereIn(

        'tbl_users_type_ID',

        $usersTypesIDs

      )
        ->whereRaw(

          'LOWER(TRIM(tbl_users_type_name)) = ?',

          [

            'desenvolvedor',

          ]

        )
        ->exists();


    }



    private function menuEditorAssignItemData(
      SysMenusItem $menuItem,
      array $itemData,
      $menuID
    ) {


      $itemType = trim(

        (string) (

          $itemData['tbl_sys_menu_item_type']

          ?? 'route'

        )

      );


      if(

        !in_array(

          $itemType,

          [

            'route',
            'link',
            'button',
            'divider',

          ],

          true

        )

      ) {

        $itemType = 'route';

      }


      $itemStatus = trim(

        (string) (

          $itemData['tbl_sys_menu_item_status']

          ?? 'ativo'

        )

      );


      if(

        !in_array(

          $itemStatus,

          [

            'ativo',
            'inativo',

          ],

          true

        )

      ) {

        $itemStatus = 'ativo';

      }


      $routeID =

        $this->menuEditorNormalizeItemID(

          $itemData['tbl_sys_route_ID']

          ?? null

        );


      if(

        $itemType !== 'route' ||

        $routeID === null ||

        !SysRoute::where(

          'tbl_sys_route_ID',

          $routeID

        )->exists()

      ) {

        $routeID = null;

      }


      $menuItem->tbl_sys_menu_ID =

        $menuID;


      $menuItem->tbl_sys_menu_item_index = trim(

        (string) (

          $itemData['tbl_sys_menu_item_index']

          ?? ''

        )

      );


      $menuItem->tbl_sys_menu_item_icon = trim(

        (string) (

          $itemData['tbl_sys_menu_item_icon']

          ?? ''

        )

      );


      $menuItem->tbl_sys_menu_item_class = trim(

        (string) (

          $itemData['tbl_sys_menu_item_class']

          ?? ''

        )

      );


      $menuItem->tbl_sys_menu_item_title = trim(

        (string) (

          $itemData['tbl_sys_menu_item_title']

          ?? ''

        )

      );


      $menuItem->tbl_sys_menu_item_type =

        $itemType;


      $menuItem->tbl_sys_route_ID =

        $routeID;


      $menuItem->tbl_sys_menu_item_link =

        $itemType === 'link'

          ? trim(

              (string) (

                $itemData['tbl_sys_menu_item_link']

                ?? ''

              )

            )

          : '';


      $menuItem->tbl_sys_menu_item_props =

        $this->menuEditorNormalizeProps(

          $itemData['tbl_sys_menu_item_props']

          ?? []

        );


      $menuItem->tbl_sys_menu_item_status =

        $itemStatus;


      $menuItem->tbl_sys_menu_item_admin =

        $this->menuEditorBoolean(

          $itemData['tbl_sys_menu_item_admin']

          ?? false

        );


      $menuItem->tbl_sys_menu_item_ordem = max(

        1,

        (int) (

          $itemData['tbl_sys_menu_item_ordem']

          ?? 1

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Exclusão proibida
      |--------------------------------------------------------------------------
      |
      | Somente usuários desenvolvedores podem alterar esta propriedade.
      |
      | Para usuários não desenvolvedores:
      |
      | - itens existentes preservam o valor salvo;
      | - itens novos recebem false.
      |
      */

      if(

        $this->menuEditorUserIsDeveloper() ===

        true

      ) {


        if(

          array_key_exists(

            'tbl_sys_menu_item_locked',

            $itemData

          )

        ) {


          $menuItem->tbl_sys_menu_item_locked =

            $this->menuEditorBoolean(

              $itemData['tbl_sys_menu_item_locked']

            );


        } elseif(!$menuItem->exists) {


          $menuItem->tbl_sys_menu_item_locked =

            false;


        }


      } elseif(!$menuItem->exists) {


        $menuItem->tbl_sys_menu_item_locked =

          false;


      }


      return $menuItem;


    }
    


    private function menuEditorSyncItemAccess(
      $menuItemID,
      array $access
    ) {


      SysMenusItemsAccess::where(

        'tbl_sys_menu_item_ID',

        $menuItemID

      )->delete();


      foreach($access as $usersTypeID) {


        SysMenusItemsAccess::create([

          'tbl_users_type_ID'    =>

            $usersTypeID,

          'tbl_sys_menu_item_ID' =>

            $menuItemID,

        ]);


      }


      return true;


    }


    private function menuEditorCreateDeleteAccess(
      $menuItemID,
      array $usersTypesIDs
    ) {


      foreach($usersTypesIDs as $usersTypeID) {


        if(

          SysMenusItemAccess::where(

            'tbl_sys_menu_item_ID',

            $menuItemID

          )
            ->where(

              'tbl_users_type_ID',

              $usersTypeID

            )
            ->exists()

        ) {

          continue;

        }


        SysMenusItemAccess::create([

          'tbl_users_type_ID'    =>

            $usersTypeID,

          'tbl_sys_menu_item_ID' =>

            $menuItemID,

        ]);


      }


      return true;


    }


    private function menuEditorDeleteItem(
      SysMenusItem $menuItem
    ) {


      $menuItemID =

        $menuItem->tbl_sys_menu_item_ID;


      $children =

        $this->menuEditorGetItemChildren(

          $menuItemID,

          $menuItem->tbl_sys_menu_ID

        );


      foreach($children as $child) {


        $this->menuEditorDeleteItem(

          $child

        );


      }


      SysMenusItemsAccess::where(

        'tbl_sys_menu_item_ID',

        $menuItemID

      )->delete();


      SysMenusItemAccess::where(

        'tbl_sys_menu_item_ID',

        $menuItemID

      )->delete();


      $menuItem->delete();


      return true;


    }

    // private function menuEditorDeleteItem(
    //   SysMenusItem $menuItem
    // ) {


    //   $menuItemID =

    //     $menuItem->tbl_sys_menu_item_ID;


    //   SysMenusItemsAccess::where(

    //     'tbl_sys_menu_item_ID',

    //     $menuItemID

    //   )->delete();


    //   SysMenusItemAccess::where(

    //     'tbl_sys_menu_item_ID',

    //     $menuItemID

    //   )->delete();


    //   $menuItem->delete();


    //   return true;


    // }


    private function menuEditorAssignMenuData(
      SysMenu $menu,
      array $menuData
    ) {


      $navID =

        $this->menuEditorNormalizeItemID(

          $menuData['tbl_sys_nav_ID']

          ?? null

        );


      // if(

      //   $navID === null ||

      //   !SysNav::where(

      //     'tbl_sys_nav_ID',

      //     $navID

      //   )->exists()

      // ) {


      //   throw ValidationException::withMessages([

      //     'tbl_sys_nav_ID' =>

      //       'A posição de navegação selecionada não foi localizada.',

      //   ]);


      // }


      $menuTitle = trim(

        (string) (

          $menuData['tbl_sys_menu_title']

          ?? ''

        )

      );


      if($menuTitle === '') {


        throw ValidationException::withMessages([

          'tbl_sys_menu_title' =>

            'O nome do menu é obrigatório.',

        ]);


      }


      $menu->tbl_sys_nav_ID =

        $navID;


      $menu->tbl_sys_menu_title =

        $menuTitle;


      $menu->tbl_sys_menu_index = trim(

        (string) (

          $menuData['tbl_sys_menu_index']

          ?? ''

        )

      );


      $menu->tbl_sys_menu_class = trim(

        (string) (

          $menuData['tbl_sys_menu_class']

          ?? ''

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Menu bloqueado
      |--------------------------------------------------------------------------
      |
      | O editor atual não envia tbl_sys_menu_locked.
      |
      | Portanto, o valor já existente no banco é preservado.
      |
      */

      return $menu;


    }


    private function menuEditorNavIsAdmin(
      $navID
    ) {


      $navID =

        $this->menuEditorNormalizeItemID(

          $navID

        );


      if($navID === null) {

        return false;

      }


      $nav = SysNav::where(

        'tbl_sys_nav_ID',

        $navID

      )->first();


      if($nav === null) {

        return false;

      }


      return $this->menuEditorBoolean(

        $nav->tbl_sys_nav_admin

      );


    }



    private function menuEditorValidateItemData(
      array $itemData
    ) {


      $itemTitle = trim(

        (string) (

          $itemData['tbl_sys_menu_item_title']

          ?? ''

        )

      );


      if($itemTitle === '') {


        throw ValidationException::withMessages([

          'items' =>

            'Todos os itens precisam possuir um rótulo de navegação.',

        ]);


      }


      $itemType = trim(

        (string) (

          $itemData['tbl_sys_menu_item_type']

          ?? 'route'

        )

      );


      if(

        !in_array(

          $itemType,

          [

            'route',
            'link',
            'button',
            'divider',

          ],

          true

        )

      ) {


        throw ValidationException::withMessages([

          'items' =>

            'Um dos itens enviados possui um tipo inválido.',

        ]);


      }


      if($itemType === 'route') {


        $routeID =

          $this->menuEditorNormalizeItemID(

            $itemData['tbl_sys_route_ID']

            ?? null

          );


        if(

          $routeID === null ||

          !SysRoute::where(

            'tbl_sys_route_ID',

            $routeID

          )->exists()

        ) {


          throw ValidationException::withMessages([

            'items' =>

              'Todos os itens do tipo página precisam possuir uma página válida.',

          ]);


        }


      }


      return true;


    }


    private function menuEditorPrepareItemData(
      array $itemData,
      $navIsAdmin,
      $isSubmenu
    ) {


      $itemIndex = trim(

        (string) (

          $itemData['tbl_sys_menu_item_index']

          ?? ''

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Área administrativa
      |--------------------------------------------------------------------------
      |
      | O item é administrativo quando:
      |
      | - o nav selecionado é administrativo; ou
      | - o item possui um índice interno.
      |
      | Essa regra também é aplicada no backend para impedir alterações manuais
      | do JSON enviado pelo navegador.
      |
      */

      if(

        $navIsAdmin === true ||

        $itemIndex !== ''

      ) {


        $itemData['tbl_sys_menu_item_admin'] =

          true;


      }


      /*
      |--------------------------------------------------------------------------
      | Submenu sem ícone
      |--------------------------------------------------------------------------
      |
      | A interface atual não disponibiliza ícone para submenus.
      |
      */

      if($isSubmenu === true) {


        $itemData['tbl_sys_menu_item_icon'] =

          '';


      }


      return $itemData;


    }


    private function menuEditorGetItemChildren(
      $menuItemID,
      $menuID
    ) {


      return SysMenusItem::where(

        'tbl_sys_menu_ID',

        $menuID

      )
        ->where(

          'tbl_sys_menu_item_parent_id',

          $menuItemID

        )
        ->orderBy(

          'tbl_sys_menu_item_ordem',

          'desc'

        )
        ->get();


    }


    private function menuEditorCanDeleteItemTree(
      SysMenusItem $menuItem,
      array $usersTypesIDs
    ) {


      if(

        $this->menuEditorBoolean(

          $menuItem->tbl_sys_menu_item_locked

        ) === true

      ) {

        return false;

      }


      if(

        $this->menuEditorCanDeleteItem(

          $menuItem->tbl_sys_menu_item_ID,

          $usersTypesIDs

        ) !== true

      ) {

        return false;

      }


      $children =

        $this->menuEditorGetItemChildren(

          $menuItem->tbl_sys_menu_item_ID,

          $menuItem->tbl_sys_menu_ID

        );


      foreach($children as $child) {


        if(

          $this->menuEditorCanDeleteItemTree(

            $child,

            $usersTypesIDs

          ) !== true

        ) {

          return false;

        }


      }


      return true;


    }


    private function menuEditorSyncItems(
      SysMenu $menu,
      array $items
    ) {


      $menuID =

        $menu->tbl_sys_menu_ID;


      $usersTypesIDs =

        $this->menuEditorGetUserTypesIDs();


      $navIsAdmin =

        $this->menuEditorNavIsAdmin(

          $menu->tbl_sys_nav_ID

        );


      $existingItems =

        SysMenusItem::where(

          'tbl_sys_menu_ID',

          $menuID

        )
          ->get()
          ->keyBy(

            'tbl_sys_menu_item_ID'

          );


      $submittedDatabaseIDs = [];

      $clientDatabaseMap = [];

      $savedItems = [];

      $normalizedItems = [];


      /*
      |--------------------------------------------------------------------------
      | Primeira passagem
      |--------------------------------------------------------------------------
      |
      | Cria ou atualiza todos os itens antes de definir os pais.
      |
      | Assim, menus e submenus novos já possuem seus IDs reais no banco antes
      | da resolução de tbl_sys_menu_item_parent_id.
      |
      */

      foreach($items as $itemPosition => $itemData) {


        if(!is_array($itemData)) {

          continue;

        }


        $this->menuEditorValidateItemData(

          $itemData

        );


        $clientID = trim(

          (string) (

            $itemData['client_id']

            ?? $itemData['tbl_sys_menu_item_ID']

            ?? ''

          )

        );


        if($clientID === '') {


          throw ValidationException::withMessages([

            'items' =>

              'Um dos itens enviados não possui identificação válida.',

          ]);


        }


        if(isset($clientDatabaseMap[$clientID])) {


          throw ValidationException::withMessages([

            'items' =>

              'Foram encontrados itens duplicados na estrutura enviada.',

          ]);


        }


        $databaseID =

          $this->menuEditorNormalizeItemID(

            $itemData['database_id']

            ?? null

          );


        $menuItem = null;


        if($databaseID !== null) {


          if(!$existingItems->has($databaseID)) {


            throw ValidationException::withMessages([

              'items' =>

                'Um dos itens informados não pertence ao menu selecionado.',

            ]);


          }


          $menuItem =

            $existingItems->get(

              $databaseID

            );


          $submittedDatabaseIDs[] =

            $databaseID;


        } else {


          $menuItem =

            new SysMenusItem();


        }


        $parentClientID =

          $itemData['parent_client_id']

          ?? null;


        $isSubmenu = !(

          $parentClientID === null ||

          $parentClientID === '' ||

          $parentClientID === 0 ||

          $parentClientID === '0'

        );


        $itemData =

          $this->menuEditorPrepareItemData(

            $itemData,

            $navIsAdmin,

            $isSubmenu

          );


        /*
        |--------------------------------------------------------------------------
        | Ordem normalizada
        |--------------------------------------------------------------------------
        */

        $itemData['tbl_sys_menu_item_ordem'] =

          max(

            1,

            (int) (

              $itemData['tbl_sys_menu_item_ordem']

              ?? ($itemPosition + 1)

            )

          );


        $this->menuEditorAssignItemData(

          $menuItem,

          $itemData,

          $menuID

        );


        /*
        |--------------------------------------------------------------------------
        | O parent é resolvido na segunda passagem
        |--------------------------------------------------------------------------
        */

        $menuItem->tbl_sys_menu_item_parent_id =

          0;


        $menuItem->save();


        $menuItemID =

          $menuItem->tbl_sys_menu_item_ID;


        $clientDatabaseMap[$clientID] =

          $menuItemID;


        $savedItems[$clientID] =

          $menuItem;


        $normalizedItems[$clientID] = [

          'data' =>

            $itemData,

          'parent_client_id' =>

            $parentClientID,

        ];


        /*
        |--------------------------------------------------------------------------
        | Permissões de visualização
        |--------------------------------------------------------------------------
        */

        $itemAdmin =

          $this->menuEditorBoolean(

            $menuItem->tbl_sys_menu_item_admin

          );


        $access = [];


        if($itemAdmin === true) {


          $access =

            $this->menuEditorNormalizeAccess(

              $itemData['tbl_sys_menu_item_access']

              ?? []

            );


        }


        $this->menuEditorSyncItemAccess(

          $menuItemID,

          $access

        );


        /*
        |--------------------------------------------------------------------------
        | Permissões de exclusão para novos itens
        |--------------------------------------------------------------------------
        |
        | O usuário que criou o item poderá removê-lo posteriormente através
        | dos tipos de usuário que possui no momento da criação.
        |
        */

        if($databaseID === null) {


          $this->menuEditorCreateDeleteAccess(

            $menuItemID,

            $usersTypesIDs

          );


        }


      }


      /*
      |--------------------------------------------------------------------------
      | Segunda passagem
      |--------------------------------------------------------------------------
      |
      | Resolve os pais usando o mapa client_id => ID real.
      |
      */

      foreach($normalizedItems as $clientID => $normalizedItem) {


        $menuItem =

          $savedItems[$clientID];


        $parentClientID =

          $normalizedItem['parent_client_id'];


        if(

          $parentClientID === null ||

          $parentClientID === '' ||

          $parentClientID === 0 ||

          $parentClientID === '0'

        ) {


          $menuItem->tbl_sys_menu_item_parent_id =

            0;


          $menuItem->save();


          continue;

        }


        $parentClientID = trim(

          (string) $parentClientID

        );


        if(

          !isset(

            $clientDatabaseMap[$parentClientID]

          )

        ) {


          throw ValidationException::withMessages([

            'items' =>

              'Não foi possível localizar o menu pai de um dos submenus enviados.',

          ]);


        }


        $parentDatabaseID =

          $clientDatabaseMap[$parentClientID];


        if(

          $parentDatabaseID ===

          $menuItem->tbl_sys_menu_item_ID

        ) {


          throw ValidationException::withMessages([

            'items' =>

              'Um item não pode ser definido como submenu dele mesmo.',

          ]);


        }


        $parentItem =

          $savedItems[$parentClientID];


        /*
        |--------------------------------------------------------------------------
        | Limite atual de dois níveis
        |--------------------------------------------------------------------------
        */

        if(

          (int) $parentItem->tbl_sys_menu_item_parent_id !==

          0

        ) {


          throw ValidationException::withMessages([

            'items' =>

              'O editor de menus permite somente um nível de submenu.',

          ]);


        }


        if(

          in_array(

            $parentItem->tbl_sys_menu_item_type,

            [

              'link',
              'divider',

            ],

            true

          )

        ) {


          throw ValidationException::withMessages([

            'items' =>

              'Itens do tipo link ou divisor não podem possuir submenus.',

          ]);


        }


        $menuItem->tbl_sys_menu_item_parent_id =

          $parentDatabaseID;


        $menuItem->tbl_sys_menu_item_icon =

          '';


        $menuItem->save();


      }


      /*
      |--------------------------------------------------------------------------
      | Exclusão dos itens removidos da tela
      |--------------------------------------------------------------------------
      |
      | Apenas itens:
      |
      | - não enviados;
      | - não bloqueados;
      | - e que o usuário pode excluir
      |
      | serão realmente removidos.
      |
      | A exclusão da árvore só acontece quando todos os descendentes também
      | puderem ser excluídos, evitando filhos órfãos.
      |
      */

      $itemsToDelete =

        $existingItems
          ->filter(

            function($existingItem) use (

              $submittedDatabaseIDs

            ) {


              return !in_array(

                $existingItem->tbl_sys_menu_item_ID,

                $submittedDatabaseIDs,

                true

              );


            }

          )
          ->sortByDesc(

            'tbl_sys_menu_item_ordem'

          );


      foreach($itemsToDelete as $itemToDelete) {


        /*
        |--------------------------------------------------------------------------
        | O item pode já ter sido removido junto com o pai
        |--------------------------------------------------------------------------
        */

        $currentItem =

          SysMenusItem::where(

            'tbl_sys_menu_item_ID',

            $itemToDelete->tbl_sys_menu_item_ID

          )
            ->where(

              'tbl_sys_menu_ID',

              $menuID

            )
            ->first();


        if($currentItem === null) {

          continue;

        }


        if(

          $this->menuEditorCanDeleteItemTree(

            $currentItem,

            $usersTypesIDs

          ) !== true

        ) {

          continue;

        }


        $this->menuEditorDeleteItem(

          $currentItem

        );


      }


      return [

        'total' =>

          count($savedItems),

        'ids' =>

          $clientDatabaseMap,

      ];


    }


    public function updateMenu(
      Request $request
    ) {


      if(!Auth::check()) {


        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'title'           => 'Sessão expirada',
          'message'         => 'Sua sessão expirou. Entre novamente para continuar.',

        ], 401);


      }


      try {


        $menuData =

          $request->input(

            'menu',

            []

          );


        $items =

          $request->input(

            'items',

            []

          );


        if(!is_array($menuData)) {


          throw ValidationException::withMessages([

            'menu' =>

              'Os dados do menu não foram enviados corretamente.',

          ]);


        }


        if(!is_array($items)) {


          throw ValidationException::withMessages([

            'items' =>

              'A estrutura dos itens do menu não foi enviada corretamente.',

          ]);


        }


        $menuID =

          $this->menuEditorNormalizeItemID(

            $menuData['tbl_sys_menu_ID']

            ?? null

          );


        if($menuID === null) {


          throw ValidationException::withMessages([

            'menu' =>

              'O menu informado é inválido.',

          ]);


        }


        $responseData =

          DB::transaction(

            function() use (

              $menuID,

              $menuData,

              $items

            ) {


              $menu =

                SysMenu::where(

                  'tbl_sys_menu_ID',

                  $menuID

                )
                  ->lockForUpdate()
                  ->first();


              if($menu === null) {


                throw ValidationException::withMessages([

                  'menu' =>

                    'O menu selecionado não foi localizado.',

                ]);


              }


              $this->menuEditorAssignMenuData(

                $menu,

                $menuData

              );


              $menu->save();


              $syncResult =

                $this->menuEditorSyncItems(

                  $menu,

                  $items

                );


              session([

                'currentMenu' =>

                  $menu->tbl_sys_menu_ID,

              ]);


              return [

                'menu' =>

                  $menu,

                'sync' =>

                  $syncResult,

              ];


            },

            3

          );


        return response()->json([

          'status'       => true,
          'title'        => 'Sucesso',
          'message'      => 'As alterações do menu foram salvas com sucesso.',
          'menu_id'      => $responseData['menu']->tbl_sys_menu_ID,
          'items_total'  => $responseData['sync']['total'],
          'items_ids'    => $responseData['sync']['ids'],
          'redirect_url' => SysAutomator::SysAutomatorGetRouteLinkByName(

            'admin-menus',

            true

          ),

        ], 200);


      } catch(ValidationException $exception) {


        $errors =

          $exception->errors();


        $message =

          'Não foi possível validar os dados enviados.';


        foreach($errors as $errorMessages) {


          if(

            is_array($errorMessages) &&

            isset($errorMessages[0])

          ) {


            $message =

              $errorMessages[0];


            break;


          }


        }


        return response()->json([

          'status'  => false,
          'title'   => 'Atenção',
          'message' => $message,
          'errors'  => $errors,

        ], 422);


      } catch(\Throwable $exception) {


        Log::error(

          'Falha ao atualizar menu.',

          [

            'user_id' =>

              Auth::id(),

            'menu_id' =>

              $request->input(

                'menu.tbl_sys_menu_ID'

              ),

            'message' =>

              $exception->getMessage(),

            'file' =>

              $exception->getFile(),

            'line' =>

              $exception->getLine(),

          ]

        );


        return response()->json([

          'status'  => false,
          'title'   => 'Erro',
          'message' => 'Não foi possível salvar as alterações do menu.',

        ], 500);


      }


    }



  }