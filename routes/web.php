<?php

  use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Facades\Schema;

  use App\Helpers\SysAutomator;
  use App\Models\SysConfig;
  use App\Models\SysRoute;



  if (Schema::hasTable('tbl_sys_routes')) {


    /*
    |--------------------------------------------------------------------------
    | Configuração do prefixo administrativo
    |--------------------------------------------------------------------------
    */

    $admin = SysConfig::where('tbl_sys_config_name', 'system-admin')->value('tbl_sys_config_value');

    if($admin === null || $admin == '') {

      $admin = 'admin';

    }

    $admin = '/' . trim($admin, '/');



    /*
    |--------------------------------------------------------------------------
    | Rotas de API registradas dentro do WEB
    |--------------------------------------------------------------------------
    |
    | Todas as rotas de API passam a ser registradas neste arquivo web.php.
    | Isso permite que as APIs utilizem sessão, cookies, CSRF, Auth::guard('web')
    | e o middleware route.access no mesmo fluxo das páginas do painel.
    |
    | Importante:
    | - O arquivo routes/api.php pode ser removido ou deixado vazio.
    | - As rotas de API continuam com nome iniciado por api.
    | - As rotas de API retornam JSON quando o controller for inválido.
    |
    */

    $apiRoutes = SysRoute::getRoutes([

      'where' => [

        'tbl_sys_route_status' => 'ativo',
        'tbl_sys_route_api'    => true,

      ],

    ]);


    SysAutomator::SysAutomatorRegisterDynamicRoutes($apiRoutes, [

      'urlPrefix'             => 'api',
      'adminPrefix'           => $admin,
      'routeNamePrefix'       => 'api.',
      'pageSlugPrefix'        => 'page-',
      'restrictMiddleware'    => 'route.access',
      'useRestrictMiddleware' => true,
      'onlyAdminRoutes'       => false,
      'useAdminPrefix'        => true,
      'invalidRouteResponse'  => 'json',
      'removeNamePrefixes'    => [

        'admin-api-',
        'api-',
        'admin-',

      ],

    ]);



    /*
    |--------------------------------------------------------------------------
    | Rotas WEB normais
    |--------------------------------------------------------------------------
    */

    $routes = SysRoute::getRoutes([

      'where' => [

        'tbl_sys_route_status' => 'ativo',
        'tbl_sys_route_api'    => false,

      ],

    ]);



    /*
    |--------------------------------------------------------------------------
    | Identifica a primeira rota restrita do admin
    |--------------------------------------------------------------------------
    |
    | Essa rota será usada quando o usuário acessar apenas /admin.
    |
    */

    $firstAdminUrl = null;


    foreach ($routes as $route) {

      if (
        $firstAdminUrl === null &&
        $route['tbl_sys_route_admin'] == true &&
        $route['tbl_sys_route_area'] == 'restrict' &&
        $route['tbl_sys_route_args'] == ''
      ) {

        if ($route['tbl_sys_route_permalink'] != '') {

          $firstAdminUrl = $admin . '/' . trim($route['tbl_sys_route_permalink'], '/');

        } else {

          $firstAdminUrl = $admin . '/' . trim(str_replace('admin-', '', $route['tbl_sys_route_name']), '/');

        }

      }

    }



    /*
    |--------------------------------------------------------------------------
    | Registro das rotas WEB
    |--------------------------------------------------------------------------
    */
    
    SysAutomator::SysAutomatorRegisterDynamicRoutes($routes, [

      'urlPrefix'             => '',
      'adminPrefix'           => $admin,
      'routeNamePrefix'       => 'page.',
      'pageSlugPrefix'        => 'page-',
      'restrictMiddleware'    => 'route.access',
      'useRestrictMiddleware' => true,
      'onlyAdminRoutes'       => true,
      'useAdminPrefix'        => true,
      'invalidRouteResponse'  => 'web',
      'removeNamePrefixes'    => [

        'admin-',

      ],

    ]);



    /*
    |--------------------------------------------------------------------------
    | Redirect da raiz do painel
    |--------------------------------------------------------------------------
    */

    if ($firstAdminUrl !== null) {

      Route::get($admin, function () use ($firstAdminUrl) {

        return redirect($firstAdminUrl);

      })->name('admin.index');


      Route::get($admin . '/', function () use ($firstAdminUrl) {

        return redirect($firstAdminUrl);

      })->name('admin.index.slash');

    }


  }



  /*
  |--------------------------------------------------------------------------
  | Fallback para APIs
  |--------------------------------------------------------------------------
  |
  | Como as APIs agora estão sendo registradas no web.php, qualquer rota
  | iniciada por /api que não for encontrada deve retornar JSON.
  |
  */

  Route::any('api/{any}', function () {

    return response()->json([

      'status'  => false,
      'message' => 'Endpoint não encontrado.',

    ], 404);

  })->where('any', '.*')->name('api.fallback');



  /*
  |--------------------------------------------------------------------------
  | Fallback WEB
  |--------------------------------------------------------------------------
  */

  Route::fallback(function () {

    abort(404);

  });