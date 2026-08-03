<?php


  namespace App\Helpers;


  use App\Models\SysConfig;
  use App\Models\SysTranslation;
  use App\Models\SysTranslationsWord;
  use App\Models\SysRoute;
  use App\Models\SysNav;
  use App\Models\SysMenu;
  use App\Models\SysMenusItem;
  use App\Models\SysMenusItemsAccess;
  
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Route;
  use App\Http\Controllers\SystemController;



  class SysAutomator {



    public static function SysAutomatorNormalizeController($controller) {


      if (!$controller) {

        return null;

      }

      $controller = trim($controller);

      if (class_exists($controller)) {

        return $controller;

      }

      $controllerWithNamespace = 'App\\Http\\Controllers\\' . ltrim($controller, '\\');

      if (class_exists($controllerWithNamespace)) {

        return $controllerWithNamespace;

      }

      return null;


    }



    public static function SysAutomatorMethodExists($controller, $method) {


      if (!$controller || !$method) {

        return false;

      }

      $controllerClass = self::SysAutomatorNormalizeController($controller);

      if (!$controllerClass) {

        return false;

      }

      if (!method_exists($controllerClass, $method)) {

        return false;

      }

      return true;


    }



    public static function SysAutomatorGetControllerClass($controller) {


      return self::SysAutomatorNormalizeController($controller);


    }



    public static function SysAutomatorGetConfigValue($config, $default = '') {


      $retorno = SysConfig::where('tbl_sys_config_name', $config)->value('tbl_sys_config_value');

      if ($retorno === null) {

        return $default;

      }

      return $retorno;


    }



    public static function SysAutomatorGetTranslateWord($word, $lang = '') {


      if ($word === null || $word === '') {

        return $word;

      }

      if ($lang == '') {

        $lang = self::SysAutomatorGetConfigValue('system-default-language', 'pt-br');

      }

      $langID = SysTranslation::where('tbl_sys_translation_key', $lang)
        ->value('tbl_sys_translation_ID');

      if ($langID === null) {

        return $word;

      }

      $translation = SysTranslationsWord::where('tbl_sys_translation_ID', $langID)
        ->where('tbl_translations_word_name', $word)
        ->value('tbl_translations_word_str');

      if ($translation === null || $translation === '') {

        return $word;

      }

      return $translation;


    }



    public static function SysAutomatorRegisterDynamicRoutes($routes = [], $args = []) {


      if (!is_array($routes) || count($routes) <= 0) {

        return;

      }


      $urlPrefix = isset($args['urlPrefix']) ? $args['urlPrefix'] : '';

      $adminPrefix = isset($args['adminPrefix']) ? $args['adminPrefix'] : '';

      $routeNamePrefix = isset($args['routeNamePrefix']) ? $args['routeNamePrefix'] : 'page.';

      $pageSlugPrefix = isset($args['pageSlugPrefix']) ? $args['pageSlugPrefix'] : 'page-';

      $restrictMiddleware = isset($args['restrictMiddleware']) ? $args['restrictMiddleware'] : 'route.access';

      $useRestrictMiddleware = isset($args['useRestrictMiddleware']) ? $args['useRestrictMiddleware'] : true;

      $onlyAdminRoutes = isset($args['onlyAdminRoutes']) ? $args['onlyAdminRoutes'] : false;

      $useAdminPrefix = isset($args['useAdminPrefix']) ? $args['useAdminPrefix'] : true;

      $defaultRouteArgs = isset($args['defaultRouteArgs']) ? $args['defaultRouteArgs'] : [SystemController::class, 'pageNotFound'];

      $invalidRouteResponse = isset($args['invalidRouteResponse']) ? $args['invalidRouteResponse'] : 'web';

      $removeNamePrefixes = isset($args['removeNamePrefixes']) ? $args['removeNamePrefixes'] : [

        'admin-api-',
        'api-',
        'admin-',

      ];


      $allowedMethods = [

        'get',
        'post',
        'put',
        'patch',
        'delete',
        'options',

      ];


      foreach ($routes as $route) {


        if ($onlyAdminRoutes == true && $route['tbl_sys_route_admin'] != true) {

          continue;

        }


        $routeArgs = $defaultRouteArgs;


        if ($invalidRouteResponse == 'json') {

          $routeArgs = function () {

            return response()->json([

              'status'  => false,
              'message' => 'Endpoint não encontrado ou controller inválido.',

            ], 404);

          };

        }


        if (($route['tbl_sys_route_controller'] != '') && ($route['tbl_sys_route_method'] != '')) {

          if (self::SysAutomatorMethodExists($route['tbl_sys_route_controller'], $route['tbl_sys_route_method']) == true) {

            $controllerClass = self::SysAutomatorGetControllerClass($route['tbl_sys_route_controller']);

            $routeArgs = [$controllerClass, $route['tbl_sys_route_method']];

          }

        }


        $method = strtolower($route['tbl_sys_route_type']);

        if (!in_array($method, $allowedMethods)) {

          $method = 'get';

        }


        $url = '';


        if ($urlPrefix != '') {

          $url .= '/' . trim($urlPrefix, '/');

        }


        if ($useAdminPrefix == true && $route['tbl_sys_route_admin'] == true && $adminPrefix != '') {

          $url .= '/' . trim($adminPrefix, '/');

        }


        if ($route['tbl_sys_route_permalink'] != '') {

          $url .= '/' . trim($route['tbl_sys_route_permalink'], '/');

        } else {

          $url .= '/' . trim(

            str_replace(

              $removeNamePrefixes,
              '',
              $route['tbl_sys_route_name']

            ),

            '/'

          );

        }


        if ($route['tbl_sys_route_args'] != '') {

          $url .= '/' . trim($route['tbl_sys_route_args'], '/');

        }


        $url = '/' . trim($url, '/');


        $routeBuilder = Route::$method($url, $routeArgs)
          ->defaults('pageSlug', $pageSlugPrefix . $route['tbl_sys_route_name'])
          ->defaults('sysRouteName', $route['tbl_sys_route_name'])
          ->name($routeNamePrefix . $route['tbl_sys_route_name']);


        if ($useRestrictMiddleware == true && $route['tbl_sys_route_area'] == 'restrict') {

          $routeBuilder->middleware($restrictMiddleware);

        }


      }


    }



    public static function SysAutomatorViewExists($view) {


      if (!$view || $view == '') {

        return false;

      }

      return View::exists($view);


    }



    public static function SysAutomatorGetShortcodeAttribute($shortcode, $attribute) {


      if (!$shortcode || !$attribute) {

        return null;

      }


      $pattern = '/' . preg_quote($attribute, '/') . '\s*=\s*"([^"]*)"/';

      preg_match($pattern, $shortcode, $matches);


      if (isset($matches[1])) {

        return $matches[1];

      }


      return null;


    }



    public static function SysAutomatorRenderSystemPageShortcode($shortcode, $vars = [], $defaultView = '') {


      if (!$shortcode || $shortcode == '') {

        return '';

      }


      if (!is_array($vars)) {

        $vars = [];

      }


      preg_match('/\[system-page\s+([^\]]*)\]/', $shortcode, $matches);


      if (!isset($matches[0])) {

        return $shortcode;

      }


      $view = self::SysAutomatorGetShortcodeAttribute($shortcode, 'view');


      if (!$view || $view == '') {

        return '';

      }


      if (!self::SysAutomatorViewExists($view)) {

        if ($defaultView != '' && self::SysAutomatorViewExists($defaultView)) {

          return view($defaultView, $vars)->render();

        }

        return '';

      }


      return view($view, $vars)->render();


    }



    public static function SysAutomatorGetRouteLinkByName($route = '', $params = [], $status = false, $args = []) {


      /*
      |--------------------------------------------------------------------------
      | Compatibilidade com chamada antiga
      |--------------------------------------------------------------------------
      |
      | Permite continuar usando:
      | SysAutomatorGetRouteLinkByName('admin-dashboard', true)
      |
      */

      if (is_bool($params)) {

        $status = $params;
        $params = [];

      }


      if (!$route || $route == '') {

        return '';

      }


      if (!is_array($params)) {

        $params = [];

      }


      if (!is_array($args)) {

        $args = [];

      }


      $SysRoute = SysRoute::where('tbl_sys_route_name', $route)->first();

      if ($SysRoute === null) {

        return '';

      }


      $rota = [

        'tbl_sys_route_ID'        => $SysRoute->tbl_sys_route_ID,
        'tbl_sys_route_name'      => $SysRoute->tbl_sys_route_name,
        'tbl_sys_route_permalink' => $SysRoute->tbl_sys_route_permalink,
        'tbl_sys_route_args'      => $SysRoute->tbl_sys_route_args,
        'tbl_sys_route_api'       => $SysRoute->tbl_sys_route_api,
        'tbl_sys_route_admin'     => $SysRoute->tbl_sys_route_admin,
        'tbl_sys_route_status'    => $SysRoute->tbl_sys_route_status,

      ];


      /*
      |--------------------------------------------------------------------------
      | Valida status da rota
      |--------------------------------------------------------------------------
      */

      if ($status == true && $rota['tbl_sys_route_status'] != 'ativo') {

        return '';

      }


      /*
      |--------------------------------------------------------------------------
      | Define prefixo do nome da rota
      |--------------------------------------------------------------------------
      */

      if ($rota['tbl_sys_route_api'] == true) {

        $routeNamePrefix = isset($args['routeNamePrefix']) ? $args['routeNamePrefix'] : 'api.';

      } else {

        $routeNamePrefix = isset($args['routeNamePrefix']) ? $args['routeNamePrefix'] : 'page.';

      }


      $routeName = $routeNamePrefix . $rota['tbl_sys_route_name'];


      /*
      |--------------------------------------------------------------------------
      | Primeiro tenta usar a rota registrada no Laravel
      |--------------------------------------------------------------------------
      |
      | Esse é o melhor caminho, porque respeita o domínio, APP_URL,
      | parâmetros opcionais e regras internas do Laravel.
      |
      */

      if (Route::has($routeName)) {

        try {

          return route($routeName, $params);

        } catch (\Exception $e) {

          return '';

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Fallback manual
      |--------------------------------------------------------------------------
      |
      | Caso a rota ainda não esteja registrada no Laravel no momento da chamada,
      | monta o link seguindo a mesma lógica do SysAutomatorRegisterDynamicRoutes.
      |
      */

      $urlPrefix = isset($args['urlPrefix']) ? $args['urlPrefix'] : '';

      if ($rota['tbl_sys_route_api'] == true && $urlPrefix == '') {

        $urlPrefix = 'api';

      }


      $adminPrefix = isset($args['adminPrefix']) ? $args['adminPrefix'] : self::SysAutomatorGetConfigValue('system-admin', 'admin');

      $useAdminPrefix = isset($args['useAdminPrefix']) ? $args['useAdminPrefix'] : true;

      $removeNamePrefixes = isset($args['removeNamePrefixes']) ? $args['removeNamePrefixes'] : [

        'admin-api-',
        'api-',
        'admin-',

      ];


      $url = '';


      if ($urlPrefix != '') {

        $url .= '/' . trim($urlPrefix, '/');

      }


      if ($useAdminPrefix == true && $rota['tbl_sys_route_admin'] == true && $adminPrefix != '') {

        $url .= '/' . trim($adminPrefix, '/');

      }


      if ($rota['tbl_sys_route_permalink'] != '') {

        $url .= '/' . trim($rota['tbl_sys_route_permalink'], '/');

      } else {

        $url .= '/' . trim(

          str_replace(

            $removeNamePrefixes,
            '',
            $rota['tbl_sys_route_name']

          ),

          '/'

        );

      }


      if ($rota['tbl_sys_route_args'] != '') {

        $url .= '/' . trim($rota['tbl_sys_route_args'], '/');

      }


      $url = '/' . trim($url, '/');


      /*
      |--------------------------------------------------------------------------
      | Substitui parâmetros no formato {id}, {slug}, {lang?}
      |--------------------------------------------------------------------------
      */

      if (count($params) >= 1) {

        foreach ($params as $key => $value) {

          $url = str_replace('{' . $key . '}', $value, $url);
          $url = str_replace('{' . $key . '?}', $value, $url);

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Remove parâmetros opcionais não informados
      |--------------------------------------------------------------------------
      |
      | Exemplo:
      | /admin/page/{id?}
      | vira:
      | /admin/page
      |
      */

      $url = preg_replace('/\/\{[^\/]+\?\}/', '', $url);


      /*
      |--------------------------------------------------------------------------
      | Se ainda existir parâmetro obrigatório sem valor, retorna vazio
      |--------------------------------------------------------------------------
      */

      if (preg_match('/\{[^\/]+\}/', $url)) {

        return '';

      }


      return url($url);


    }




    public static function SysAutomatorGetNavMenuItens($navName = '', $args = []) {


      $retorno = [

        'nav'   => [],
        'menu'  => [],
        'items' => [],

      ];


      if (!is_array($args)) {

        $args = [];

      }


      if (!$navName || $navName == '') {

        return $retorno;

      }


      $SysNav = SysNav::where('tbl_sys_nav_name', $navName)->first();

      if ($SysNav === null) {

        return $retorno;

      }


      $retorno['nav'] = $SysNav->toArray();


      $isAdminNav = ($SysNav->tbl_sys_nav_admin == true);

      $user = null;
      $userTypesIDs = [];


      if ($isAdminNav == true) {

        if (!Auth::check()) {

          return $retorno;

        }

        $user = Auth::user();

        if ($user !== null && method_exists($user, 'UserGetTypesIDs')) {

          $userTypesIDs = $user->UserGetTypesIDs();

        }

      }


      $SysMenu = SysMenu::where('tbl_sys_nav_ID', $SysNav->tbl_sys_nav_ID)->first();

      if ($SysMenu === null) {

        return $retorno;

      }


      $retorno['menu'] = $SysMenu->toArray();


      $itens = SysMenusItem::where('tbl_sys_menu_ID', $SysMenu->tbl_sys_menu_ID)
        ->where('tbl_sys_menu_item_status', 'ativo')
        ->orderBy('tbl_sys_menu_item_ordem', 'asc')
        ->get();


      if ($itens->count() <= 0) {

        return $retorno;

      }


      $itensPermitidos = [];


      foreach ($itens as $item) {


        if ($isAdminNav == true && $item->tbl_sys_menu_item_admin == true) {

          if ($user === null || count($userTypesIDs) <= 0) {

            continue;

          }

          $hasAccess = SysMenusItemsAccess::where('tbl_sys_menu_item_ID', $item->tbl_sys_menu_item_ID)
            ->whereIn('tbl_users_type_ID', $userTypesIDs)
            ->exists();

          if ($hasAccess != true) {

            continue;

          }

        }


        $itemArray = $item->toArray();
        $itemArray['tbl_sys_menu_item_url'] = self::SysAutomatorGetMenuItemURL($itemArray, $args);
        $itemArray['children'] = [];
        $itemArray['sub_itens'] = [];

        $itensPermitidos[] = $itemArray;


      }


      $retorno['items'] = self::SysAutomatorBuildNavMenuItensTree($itensPermitidos);

      return $retorno;


    }



    public static function SysAutomatorGetMenuItemURL($item = [], $args = []) {


      if (!is_array($item) || count($item) <= 0) {

        return '';

      }


      if (!is_array($args)) {

        $args = [];

      }


      $itemType = isset($item['tbl_sys_menu_item_type']) ? $item['tbl_sys_menu_item_type'] : '';


      if ($itemType != 'route') {

        if (isset($item['tbl_sys_menu_item_url']) && $item['tbl_sys_menu_item_url'] != '') {

          return $item['tbl_sys_menu_item_url'];

        }

        if (isset($item['tbl_sys_menu_item_link']) && $item['tbl_sys_menu_item_link'] != '') {

          return $item['tbl_sys_menu_item_link'];

        }

        return '';

      }


      $routeID = isset($item['tbl_sys_route_ID']) ? $item['tbl_sys_route_ID'] : null;

      if ($routeID === null || $routeID === '') {

        return '';

      }


      $SysRoute = SysRoute::where('tbl_sys_route_ID', $routeID)->first();

      if ($SysRoute === null) {

        return '';

      }


      $routeParams = isset($args['routeParams']) ? $args['routeParams'] : [];

      if (!is_array($routeParams)) {

        $routeParams = [];

      }


      $routeLinkArgs = isset($args['routeLinkArgs']) ? $args['routeLinkArgs'] : [];

      if (!is_array($routeLinkArgs)) {

        $routeLinkArgs = [];

      }


      return self::SysAutomatorGetRouteLinkByName(

        $SysRoute->tbl_sys_route_name,
        $routeParams,
        true,
        $routeLinkArgs

      );


    }



    public static function SysAutomatorBuildNavMenuItensTree($itens = [], $parentID = null) {


      $retorno = [];


      if (!is_array($itens) || count($itens) <= 0) {

        return $retorno;

      }


      foreach ($itens as $item) {


        $itemParentID = isset($item['tbl_sys_menu_item_parent_id']) ? $item['tbl_sys_menu_item_parent_id'] : null;


        if ($itemParentID === 0 || $itemParentID === '0' || $itemParentID === '') {

          $itemParentID = null;

        }


        if ($parentID === 0 || $parentID === '0' || $parentID === '') {

          $parentID = null;

        }


        if ((string) $itemParentID !== (string) $parentID) {

          continue;

        }


        $itemID = isset($item['tbl_sys_menu_item_ID']) ? $item['tbl_sys_menu_item_ID'] : null;

        $children = self::SysAutomatorBuildNavMenuItensTree($itens, $itemID);

        $item['children'] = $children;
        $item['sub_itens'] = $children;

        $retorno[] = $item;


      }


      return $retorno;


    }



  }