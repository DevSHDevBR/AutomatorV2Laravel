<?php


  namespace App\Helpers;


  use App\Models\SysConfig;
  use App\Models\SysTranslation;
  use App\Models\SysTranslationsWord;
  use App\Models\SysRoute;
  use App\Models\SysFieldType;
  use App\Models\SysFieldTypesGroup;
  use App\Models\SysForm;
  use App\Models\SysFormsAccess;
  use App\Models\SysFormsField;
  use App\Models\SysFormsFieldsAccess;
  use App\Models\SysPagination;
  use App\Models\SysPaginationsArg;
  use App\Models\SysPaginationsCol;
  use App\Models\SysPaginationsColsAccess;
  use App\Models\SysNav;
  use App\Models\SysMenu;
  use App\Models\SysMenusItem;
  use App\Models\SysMenusItemsAccess;
  use App\Models\SysMenusItemAccess;
  use App\Models\SysShortcode;
  use App\Models\SysNotification;
  use App\Models\SysFunction;
  use App\Models\SysView;
  

  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Route;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Session;
  use Illuminate\Support\Facades\Schema;
  use Illuminate\Support\Facades\Storage;
  use Illuminate\Support\Carbon;
  use Illuminate\Http\Request;
  

  use App\Automator\AutomatorFields;
  use App\Http\Controllers\SystemController;
  use App\Http\Controllers\AutomatorController;



  class SysAutomator {



    public static function SysAutomatorGetPublicUploadURL(
      $directory,
      $fileName,
      $access = 'public'
    ): string {


      if($access !== 'public') {

        return '';

      }


      $directory = trim((string) $directory, '/');
      $fileName = basename((string) $fileName);


      if($directory === '' || $fileName === '') {

        return '';

      }


      $path = $directory . '/' . $fileName;


      if(Storage::disk('public')->exists($path)) {

        return Storage::disk('public')->url($path);

      }


      return asset($path);


    }



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

      /*
      |--------------------------------------------------------------------------
      | Controllers de módulos instalados
      |--------------------------------------------------------------------------
      */

      if(
        strpos($controller, '\\') === false &&
        preg_match('/^[A-Za-z0-9_]+$/', $controller)
      ) {

        $controllerFiles = glob(

          storage_path(

            'app/modulos/installed/*/Controllers/' . $controller . '.php'

          )

        );


        if(is_array($controllerFiles)) {

          foreach($controllerFiles as $controllerFile) {

            $modulePath = dirname(

              dirname($controllerFile)

            );

            $modelsPath = $modulePath . '/Models';


            if(is_dir($modelsPath)) {

              foreach(glob($modelsPath . '/*.php') as $modelFile) {

                require_once $modelFile;

              }

            }


            require_once $controllerFile;

          }

        }


        if(class_exists($controllerWithNamespace)) {

          return $controllerWithNamespace;

        }

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


    public static function SysAutomatorRegisterDynamicRoutes($routes = [], $args = [])
    {

        if (!is_array($routes) || empty($routes)) {
            return;
        }

        $urlPrefix              = $args['urlPrefix'] ?? '';
        $adminPrefix            = $args['adminPrefix'] ?? '';
        $routeNamePrefix        = $args['routeNamePrefix'] ?? 'page.';
        $pageSlugPrefix         = $args['pageSlugPrefix'] ?? 'page-';
        $restrictMiddleware     = $args['restrictMiddleware'] ?? 'route.access';
        $useRestrictMiddleware  = $args['useRestrictMiddleware'] ?? true;
        $onlyAdminRoutes        = $args['onlyAdminRoutes'] ?? false;
        $useAdminPrefix         = $args['useAdminPrefix'] ?? true;
        $defaultRouteArgs       = $args['defaultRouteArgs'] ?? [SystemController::class, 'pageNotFound'];
        $invalidRouteResponse   = $args['invalidRouteResponse'] ?? 'web';

        /*
        |--------------------------------------------------------------------------
        | Compatibilidade
        |--------------------------------------------------------------------------
        */

        $routeScope = $args['routeScope'] ?? null;

        if ($routeScope === null) {

            if ($onlyAdminRoutes === true) {
                $routeScope = 'admin';
            } else {
                $routeScope = 'all';
            }

        }

        $removeNamePrefixes = $args['removeNamePrefixes'] ?? [
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

            /*
            |--------------------------------------------------------------------------
            | Escopo das rotas
            |--------------------------------------------------------------------------
            */

            switch ($routeScope) {

                case 'admin':

                    if (empty($route['tbl_sys_route_admin'])) {
                        continue 2;
                    }

                break;

                case 'public':

                    if (!empty($route['tbl_sys_route_admin'])) {
                        continue 2;
                    }

                break;

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

            if (
                !empty($route['tbl_sys_route_controller']) &&
                !empty($route['tbl_sys_route_method'])
            ) {

                if (
                    self::SysAutomatorMethodExists(
                        $route['tbl_sys_route_controller'],
                        $route['tbl_sys_route_method']
                    )
                ) {

                    $controllerClass = self::SysAutomatorGetControllerClass(
                        $route['tbl_sys_route_controller']
                    );

                    $routeArgs = [
                        $controllerClass,
                        $route['tbl_sys_route_method']
                    ];

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

            if (
                $useAdminPrefix &&
                !empty($route['tbl_sys_route_admin']) &&
                $adminPrefix != ''
            ) {

                $url .= '/' . trim($adminPrefix, '/');

            }

            /*
            |--------------------------------------------------------------------------
            | Rotas Pai
            |--------------------------------------------------------------------------
            */

            $parentRouteID = $route['tbl_sys_route_parent_id'] ?? null;

            if (!empty($parentRouteID)) {

                $parentRoutes = [];
                $checkedParentRoutes = [];
                $currentParentID = $parentRouteID;

                while (!empty($currentParentID)) {

                    if (in_array($currentParentID, $checkedParentRoutes)) {
                        break;
                    }

                    $checkedParentRoutes[] = $currentParentID;

                    $parentRoute = SysRoute::where(
                        'tbl_sys_route_ID',
                        $currentParentID
                    )->first();

                    if (!$parentRoute) {
                        break;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | IMPORTANTE
                    |--------------------------------------------------------------------------
                    | Não utiliza pais administrativos quando a rota atual
                    | é pública.
                    */

                    if (
                        empty($route['tbl_sys_route_admin']) &&
                        !empty($parentRoute->tbl_sys_route_admin)
                    ) {

                        break;

                    }

                    array_unshift($parentRoutes, $parentRoute);

                    $currentParentID = $parentRoute->tbl_sys_route_parent_id;

                }

                foreach ($parentRoutes as $parentRoute) {

                    if (!empty($parentRoute->tbl_sys_route_permalink)) {

                        $url .= '/' . trim(
                            $parentRoute->tbl_sys_route_permalink,
                            '/'
                        );

                    } else {

                        $url .= '/' . trim(

                            str_replace(
                                $removeNamePrefixes,
                                '',
                                $parentRoute->tbl_sys_route_name
                            ),

                            '/'

                        );

                    }

                }

            }

            if (!empty($route['tbl_sys_route_permalink'])) {

                $url .= '/' . trim(
                    $route['tbl_sys_route_permalink'],
                    '/'
                );

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

            if (!empty($route['tbl_sys_route_args'])) {

                $url .= '/' . trim(
                    $route['tbl_sys_route_args'],
                    '/'
                );

            }

            $url = '/' . trim($url, '/');

            $routeBuilder = Route::$method($url, $routeArgs)
                ->defaults(
                    'pageSlug',
                    $pageSlugPrefix . $route['tbl_sys_route_name']
                )
                ->defaults(
                    'sysRouteName',
                    $route['tbl_sys_route_name']
                )
                ->name(
                    $routeNamePrefix . $route['tbl_sys_route_name']
                );

            if (
                $useRestrictMiddleware &&
                ($route['tbl_sys_route_area'] ?? '') == 'restrict'
            ) {

                $routeBuilder->middleware($restrictMiddleware);

            }

        }

    }
    // public static function SysAutomatorRegisterDynamicRoutes($routes = [], $args = []) {


    //   if (!is_array($routes) || count($routes) <= 0) {

    //     return;

    //   }


    //   $urlPrefix = isset($args['urlPrefix']) ? $args['urlPrefix'] : '';

    //   $adminPrefix = isset($args['adminPrefix']) ? $args['adminPrefix'] : '';

    //   $routeNamePrefix = isset($args['routeNamePrefix']) ? $args['routeNamePrefix'] : 'page.';

    //   $pageSlugPrefix = isset($args['pageSlugPrefix']) ? $args['pageSlugPrefix'] : 'page-';

    //   $restrictMiddleware = isset($args['restrictMiddleware']) ? $args['restrictMiddleware'] : 'route.access';

    //   $useRestrictMiddleware = isset($args['useRestrictMiddleware']) ? $args['useRestrictMiddleware'] : true;

    //   $onlyAdminRoutes = isset($args['onlyAdminRoutes']) ? $args['onlyAdminRoutes'] : false;

    //   $useAdminPrefix = isset($args['useAdminPrefix']) ? $args['useAdminPrefix'] : true;

    //   $defaultRouteArgs = isset($args['defaultRouteArgs']) ? $args['defaultRouteArgs'] : [SystemController::class, 'pageNotFound'];

    //   $invalidRouteResponse = isset($args['invalidRouteResponse']) ? $args['invalidRouteResponse'] : 'web';

    //   $removeNamePrefixes = isset($args['removeNamePrefixes']) ? $args['removeNamePrefixes'] : [

    //     'admin-api-',
    //     'api-',
    //     'admin-',

    //   ];


    //   $allowedMethods = [

    //     'get',
    //     'post',
    //     'put',
    //     'patch',
    //     'delete',
    //     'options',

    //   ];

    //   foreach ($routes as $route) {


    //     if ($onlyAdminRoutes == true && $route['tbl_sys_route_admin'] != true) {

    //       continue;

    //     }


    //     $routeArgs = $defaultRouteArgs;

    //     // echo '<pre>';
    //     // var_dump($route);
    //     // echo '</pre>';
    //     // echo '<br />';
    //     // echo '<br />';
    //     if ($invalidRouteResponse == 'json') {

    //       $routeArgs = function () {

    //         return response()->json([

    //           'status'  => false,
    //           'message' => 'Endpoint não encontrado ou controller inválido.',

    //         ], 404);

    //       };

    //     }

    //     if (($route['tbl_sys_route_controller'] != '') && ($route['tbl_sys_route_method'] != '')) {

    //       if (self::SysAutomatorMethodExists($route['tbl_sys_route_controller'], $route['tbl_sys_route_method']) == true) {

    //         $controllerClass = self::SysAutomatorGetControllerClass($route['tbl_sys_route_controller']);

    //         $routeArgs = [$controllerClass, $route['tbl_sys_route_method']];

    //       }

    //     }


    //     $method = strtolower($route['tbl_sys_route_type']);

    //     if (!in_array($method, $allowedMethods)) {

    //       $method = 'get';

    //     }


    //     $url = '';


    //     if ($urlPrefix != '') {

    //       $url .= '/' . trim($urlPrefix, '/');

    //     }


    //     if ($useAdminPrefix == true && $route['tbl_sys_route_admin'] == true && $adminPrefix != '') {

    //       $url .= '/' . trim($adminPrefix, '/');

    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Prefixo por rota pai
    //     |--------------------------------------------------------------------------
    //     |
    //     | Se a rota possuir tbl_sys_route_parent_id, a URL da rota pai será usada
    //     | como prefixo antes da rota atual.
    //     |
    //     | Exemplo:
    //     | Pai:
    //     | name = admin-usuarios
    //     | permalink = usuarios
    //     |
    //     | Filho:
    //     | name = admin-usuarios-form
    //     | permalink = form
    //     |
    //     | Resultado:
    //     | /usuarios/form
    //     |
    //     | Se o pai não possuir permalink, será utilizado o name tratado removendo
    //     | prefixos como admin-, api- e admin-api-.
    //     |
    //     */

    //     $parentRouteID = isset($route['tbl_sys_route_parent_id']) ? $route['tbl_sys_route_parent_id'] : null;

    //     if ($parentRouteID !== null && $parentRouteID !== '' && $parentRouteID != 0) {


    //       $parentRoutes = [];

    //       $currentParentID = $parentRouteID;

    //       $checkedParentRoutes = [];


    //       while ($currentParentID !== null && $currentParentID !== '' && $currentParentID != 0) {


    //         if (in_array($currentParentID, $checkedParentRoutes)) {

    //           break;

    //         }


    //         $checkedParentRoutes[] = $currentParentID;


    //         $SysParentRoute = SysRoute::where('tbl_sys_route_ID', $currentParentID)->first();


    //         if ($SysParentRoute === null) {

    //           break;

    //         }


    //         array_unshift($parentRoutes, $SysParentRoute);


    //         $currentParentID = $SysParentRoute->tbl_sys_route_parent_id;


    //       }


    //       if (count($parentRoutes) >= 1) {

    //         foreach ($parentRoutes as $parentRoute) {


    //           if ($parentRoute->tbl_sys_route_permalink != '') {

    //             $url .= '/' . trim($parentRoute->tbl_sys_route_permalink, '/');

    //           } else {

    //             $url .= '/' . trim(

    //               str_replace(

    //                 $removeNamePrefixes,
    //                 '',
    //                 $parentRoute->tbl_sys_route_name

    //               ),

    //               '/'

    //             );

    //           }


    //         }

    //       }


    //     }


    //     if ($route['tbl_sys_route_permalink'] != '') {

    //       $url .= '/' . trim($route['tbl_sys_route_permalink'], '/');

    //     } else {

    //       $url .= '/' . trim(

    //         str_replace(

    //           $removeNamePrefixes,
    //           '',
    //           $route['tbl_sys_route_name']

    //         ),

    //         '/'

    //       );

    //     }


    //     if ($route['tbl_sys_route_args'] != '') {

    //       $url .= '/' . trim($route['tbl_sys_route_args'], '/');

    //     }


    //     $url = '/' . trim($url, '/');

    //     // echo '<pre>';
    //     // echo $url;
    //     // echo '</pre>';

    //     $routeBuilder = Route::$method($url, $routeArgs)
    //       ->defaults('pageSlug', $pageSlugPrefix . $route['tbl_sys_route_name'])
    //       ->defaults('sysRouteName', $route['tbl_sys_route_name'])
    //       ->name($routeNamePrefix . $route['tbl_sys_route_name']);


    //     if ($useRestrictMiddleware == true && $route['tbl_sys_route_area'] == 'restrict') {

    //       $routeBuilder->middleware($restrictMiddleware);

    //     }


    //   }


    // }


    public static function SysAutomatorGetSysView($viewName) {

      $retorno = '';

      $view = SysView::where('tbl_sys_view_name', $viewName)->get();
      if($view) {

        $view = $view->toArray();

        $arquivo = str_replace(['\\', '/'], '.', $view['tbl_sys_view_directory']) . '.' . $view['tbl_sys_view_file'];
        $exists = self::SysAutomatorViewExists($arquivo);
        if($exists != false) {

          $retorno = $arquivo;

        }

      }

      return $retorno;


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


      preg_match('/\[system-pages\s+([^\]]*)\]/', $shortcode, $matches);


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




    public static function SysAutomatorNormalizeShortcodeClass($class) {


      if(!$class || trim($class) == '') {

        return null;

      }


      $class = trim($class);


      if(class_exists($class)) {

        return $class;

      }


      $namespaces = [

        'App\\Http\\Controllers\\',
        'App\\Helpers\\',
        'App\\Models\\',
        'App\\Automator\\',

      ];


      foreach($namespaces as $namespace) {

        $classWithNamespace = $namespace . ltrim($class, '\\');

        if(class_exists($classWithNamespace)) {

          return $classWithNamespace;

        }

      }


      return null;


    }



    public static function SysAutomatorGetShortcodeAttributes($shortcode) {


      $attributes = [];


      if(!$shortcode || $shortcode == '') {

        return $attributes;

      }


      preg_match_all('/([a-zA-Z0-9_\-]+)\s*=\s*("([^"]*)"|\'([^\']*)\'|([^\s\]]+))/', $shortcode, $matches, PREG_SET_ORDER);


      if(count($matches) >= 1) {

        foreach($matches as $match) {

          $key   = $match[1];
          $value = '';


          if(isset($match[3]) && $match[3] !== '') {

            $value = $match[3];

          } elseif(isset($match[4]) && $match[4] !== '') {

            $value = $match[4];

          } elseif(isset($match[5]) && $match[5] !== '') {

            $value = $match[5];

          }


          $attributes[$key] = $value;

        }

      }


      return $attributes;


    }



    public static function SysAutomatorRenderDynamicShortcodes($content, $vars = [], $route = []) {


      if($content === null || $content === '') {

        return '';

      }


      if(!is_array($vars)) {

        $vars = [];

      }


      if(!is_array($route)) {

        $route = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Remove <code> somente quando envolve um shortcode
      |--------------------------------------------------------------------------
      */

      $content = preg_replace_callback(

        '/<code\b[^>]*>\s*(\[[^\]]+\])\s*<\/code>/i',

        function($matches) {

          return $matches[1] ?? '';

        },

        $content

      );


      /*
      |--------------------------------------------------------------------------
      | Busca os shortcodes cadastrados
      |--------------------------------------------------------------------------
      */

      $shortcodes = SysShortcode::get();


      if($shortcodes->count() <= 0) {

        return $content;

      }


      /*
      |--------------------------------------------------------------------------
      | Indexa os shortcodes por código
      |--------------------------------------------------------------------------
      */

      $shortcodesByCode = [];


      foreach($shortcodes as $shortcodeConfig) {

        $shortcodeCode = trim(

          (string) (

            $shortcodeConfig->tbl_sys_shortcode_code

            ?? ''

          )

        );


        if($shortcodeCode === '') {

          continue;

        }


        $shortcodeCode = trim(

          $shortcodeCode,

          '[]'

        );


        $shortcodeCode = preg_replace(

          '/\s+.*/',

          '',

          $shortcodeCode

        );


        $shortcodeCode = strtolower(

          trim($shortcodeCode)

        );


        if($shortcodeCode === '') {

          continue;

        }


        $shortcodesByCode[$shortcodeCode] =

          $shortcodeConfig;

      }


      /*
      |--------------------------------------------------------------------------
      | Funções internas do AutomatorController
      |--------------------------------------------------------------------------
      |
      | Estas funções sempre devem continuar sendo executadas por:
      |
      | AutomatorController@getFunction
      |
      | Mesmo que exista outro registro com o mesmo nome em tbl_sys_shortcodes.
      |
      */

      $automatorInternalFunctions = [

        'pagination',
        'getdata',
        'get-data',
        'getdatabytablemodel',
        'get-data-by-table-model',
        'getdatabytablemodelname',
        'get-data-by-table-model-name',
        'getdatabymodel',
        'get-data-by-model',
        'storedata',
        'store-data',
        'updatedata',
        'update-data',
        'deletedata',
        'delete-data',

      ];


      /*
      |--------------------------------------------------------------------------
      | Resolve variáveis do shortcode
      |--------------------------------------------------------------------------
      */

      $resolveVars = function($attributes) use ($vars) {


        $resolvedVars = $vars;


        if(

          isset($attributes['vars']) &&

          is_scalar($attributes['vars']) &&

          trim((string) $attributes['vars']) !== ''

        ) {

          $varsName = trim(

            (string) $attributes['vars']

          );


          if(substr($varsName, 0, 1) === '$') {

            $varsName = substr(

              $varsName,

              1

            );

          }


          if(

            $varsName !== '' &&

            array_key_exists(

              $varsName,

              $vars

            )

          ) {

            $resolvedVars = $vars[$varsName];

          }

        }


        if(is_object($resolvedVars)) {

          $resolvedVars = (array) $resolvedVars;

        }


        if(!is_array($resolvedVars)) {

          $resolvedVars = [];

        }


        return $resolvedVars;


      };


      /*
      |--------------------------------------------------------------------------
      | Normaliza o retorno do shortcode
      |--------------------------------------------------------------------------
      */

      $normalizeShortcodeResponse = function($response) {


        if(

          $response instanceof

          \Illuminate\Contracts\View\View

        ) {

          return $response->render();

        }


        if(

          $response instanceof

          \Illuminate\Http\JsonResponse

        ) {

          $responseData = $response->getData(true);


          if(

            is_array($responseData) &&

            array_key_exists(

              'html',

              $responseData

            )

          ) {

            $html = $responseData['html'];


            return is_scalar($html)

              ? (string) $html

              : '';

          }


          return $response->getContent();

        }


        if(

          $response instanceof

          \Symfony\Component\HttpFoundation\Response

        ) {

          return $response->getContent();

        }


        if(is_array($response)) {


          if(array_key_exists('html', $response)) {

            $html = $response['html'];


            return is_scalar($html)

              ? (string) $html

              : '';

          }


          if(

            isset($response['status']) &&

            $response['status'] === false

          ) {

            $message =

              $response['message']

              ?? 'Não foi possível renderizar o conteúdo.';


            if(!is_scalar($message)) {

              $message =

                'Não foi possível renderizar o conteúdo.';

            }


            return '<div class="alert alert-warning">' .

              e((string) $message) .

            '</div>';

          }


          return '';

        }


        if($response === null) {

          return '';

        }


        if(is_bool($response)) {

          return $response ? '1' : '';

        }


        if(is_scalar($response)) {

          return (string) $response;

        }


        if(

          is_object($response) &&

          method_exists($response, '__toString')

        ) {

          return (string) $response;

        }


        return '';


      };


      /*
      |--------------------------------------------------------------------------
      | Valida parâmetros obrigatórios
      |--------------------------------------------------------------------------
      */

      $validateShortcodeParams = function(

        $shortcodeConfig,

        array $attributes

      ) {


        $paramsRules = [];

        $paramsValue =

          $shortcodeConfig->tbl_sys_shortcode_params

          ?? [];


        if(is_object($paramsValue)) {

          $paramsValue = (array) $paramsValue;

        }


        if(is_array($paramsValue)) {

          $paramsRules = $paramsValue;

        } elseif(

          is_string($paramsValue) &&

          trim($paramsValue) !== ''

        ) {

          $decodedParams = json_decode(

            $paramsValue,

            true

          );


          if(is_array($decodedParams)) {

            $paramsRules = $decodedParams;

          }

        }


        foreach($paramsRules as $paramName => $paramRule) {

          $required = false;


          if($paramRule === true) {

            $required = true;

          } elseif(

            is_array($paramRule) &&

            array_key_exists(

              'required',

              $paramRule

            )

          ) {

            $required = in_array(

              $paramRule['required'],

              [

                true,
                1,
                '1',
                'true',
                'TRUE',
                'required',

              ],

              true

            );

          }


          if($required !== true) {

            continue;

          }


          if(

            !array_key_exists(

              $paramName,

              $attributes

            ) ||

            $attributes[$paramName] === null ||

            $attributes[$paramName] === ''

          ) {

            return false;

          }

        }


        return true;


      };


      /*
      |--------------------------------------------------------------------------
      | Executa um shortcode cadastrado
      |--------------------------------------------------------------------------
      */

      $executeShortcodeConfig = function(

        $shortcodeConfig,

        array $attributes,

        $originalShortcode

      ) use (

        $vars,

        $route,

        $resolveVars,

        $normalizeShortcodeResponse,

        $validateShortcodeParams

      ) {


        $shortcodeCode = strtolower(

          trim(

            (string) (

              $shortcodeConfig->tbl_sys_shortcode_code

              ?? ''

            )

          )

        );


        if(

          $validateShortcodeParams(

            $shortcodeConfig,

            $attributes

          ) !== true

        ) {

          return $originalShortcode;

        }


        /*
        |--------------------------------------------------------------------------
        | Compatibilidade direta: system-form
        |--------------------------------------------------------------------------
        */

        if($shortcodeCode === 'system-form') {

          $formName = trim(

            (string) (

              $attributes['form']

              ?? ''

            )

          );


          if($formName === '') {

            return '';

          }


          $formID = self::SysAutomatorGetFormIDByName(

            $formName

          );


          if($formID === null || $formID === '') {

            return '';

          }


          $formResponse =

            self::SysAutomatorRenderFormByID(

              $formID,

              $resolveVars($attributes)

            );


          return $normalizeShortcodeResponse(

            $formResponse

          );

        }


        /*
        |--------------------------------------------------------------------------
        | Compatibilidade direta: system-pages
        |--------------------------------------------------------------------------
        */

        if($shortcodeCode === 'system-pages') {

          $view = trim(

            (string) (

              $attributes['view']

              ?? ''

            )

          );


          if(

            $view === '' ||

            !View::exists($view)

          ) {

            return '';

          }


          return view(

            $view,

            $resolveVars($attributes)

          )->render();

        }


        /*
        |--------------------------------------------------------------------------
        | Classe e método cadastrados
        |--------------------------------------------------------------------------
        */

        $className =

          $shortcodeConfig->tbl_sys_shortcode_class

          ?? '';


        $methodName =

          $shortcodeConfig->tbl_sys_shortcode_method

          ?? '';


        $className =

          self::SysAutomatorNormalizeShortcodeClass(

            $className

          );


        if(

          $className === null ||

          $methodName === null ||

          trim((string) $methodName) === ''

        ) {

          return $originalShortcode;

        }


        $methodName = trim(

          (string) $methodName

        );


        if(!method_exists($className, $methodName)) {

          return $originalShortcode;

        }


        try {

          $request = request();


          /*
          |--------------------------------------------------------------------------
          | Contexto do shortcode
          |--------------------------------------------------------------------------
          */

          $request->attributes->set(

            'automator_shortcode_code',

            $shortcodeCode

          );


          $request->attributes->set(

            'automator_shortcode_params',

            $attributes

          );


          $request->attributes->set(

            'automator_shortcode_vars',

            $vars

          );


          $request->attributes->set(

            'automator_shortcode_route',

            $route

          );


          $request->attributes->set(

            'automator_shortcode_original',

            $originalShortcode

          );


          foreach($attributes as $attributeKey => $attributeValue) {

            $request->attributes->set(

              $attributeKey,

              $attributeValue

            );

          }


          /*
          |--------------------------------------------------------------------------
          | Executa método estático do SysAutomator
          |--------------------------------------------------------------------------
          */

          if($className === self::class) {

            $renderedContent = call_user_func(

              [

                $className,

                $methodName

              ],

              $attributes,

              $resolveVars($attributes)

            );

          } else {

            /*
            |--------------------------------------------------------------------------
            | Executa controller ou outra classe pelo container
            |--------------------------------------------------------------------------
            */

            $object = app($className);


            $renderedContent = call_user_func(

              [

                $object,

                $methodName

              ],

              $request,

              $attributes

            );

          }


          return $normalizeShortcodeResponse(

            $renderedContent

          );


        } catch(\Throwable $exception) {

          /*
          |--------------------------------------------------------------------------
          | Registra contexto completo no log
          |--------------------------------------------------------------------------
          */

          report($exception);


          \Illuminate\Support\Facades\Log::error(

            'Falha ao renderizar shortcode do Automator.',

            [

              'shortcode'  => $originalShortcode,
              'code'       => $shortcodeCode,
              'class'      => $className,
              'method'     => $methodName,
              'attributes' => $attributes,
              'route'      => $route,
              'exception'  => $exception->getMessage(),
              'file'       => $exception->getFile(),
              'line'       => $exception->getLine(),

            ]

          );


          return '<div class="alert alert-danger">' .

            e(

              self::SysAutomatorGetTranslateWord(

                'Não foi possível renderizar o shortcode.'

              )

            ) .

          '</div>';

        }


      };


      /*
      |--------------------------------------------------------------------------
      | Processa os shortcodes encontrados
      |--------------------------------------------------------------------------
      */

      $maximumPasses = 10;


      for($pass = 0; $pass < $maximumPasses; $pass++) {

        $contentBeforePass = $content;


        /*
        |--------------------------------------------------------------------------
        | Processa primeiro [automator ...]
        |--------------------------------------------------------------------------
        */

        if(isset($shortcodesByCode['automator'])) {

          $automatorConfig =

            $shortcodesByCode['automator'];


          $content = preg_replace_callback(

            '/\[automator(?:\s+[^\]]*)?\]/i',

            function($matches) use (

              $automatorConfig,

              $shortcodesByCode,

              $automatorInternalFunctions,

              $executeShortcodeConfig

            ) {


              $originalShortcode =

                $matches[0]

                ?? '';


              if($originalShortcode === '') {

                return '';

              }


              $attributes =

                self::SysAutomatorGetShortcodeAttributes(

                  $originalShortcode

                );


              $dynamicFunction = strtolower(

                trim(

                  (string) (

                    $attributes['function']

                    ?? ''

                  )

                )

              );


              if($dynamicFunction === '') {

                return $originalShortcode;

              }


              /*
              |--------------------------------------------------------------------------
              | Função interna do AutomatorController
              |--------------------------------------------------------------------------
              |
              | Mantém o atributo function e usa sempre o registro "automator".
              |
              | Isso corrige principalmente:
              |
              | [automator function="pagination" name="teste"]
              |
              */

              if(

                in_array(

                  $dynamicFunction,

                  $automatorInternalFunctions,

                  true

                )

              ) {

                return $executeShortcodeConfig(

                  $automatorConfig,

                  $attributes,

                  $originalShortcode

                );

              }


              /*
              |--------------------------------------------------------------------------
              | Shortcodes especiais chamados através de function
              |--------------------------------------------------------------------------
              |
              | Exemplos:
              |
              | [automator function="system-pages" ...]
              | [automator function="system-form" ...]
              |
              */

              if(

                isset(

                  $shortcodesByCode[$dynamicFunction]

                )

              ) {

                $targetAttributes = $attributes;


                unset(

                  $targetAttributes['function']

                );


                return $executeShortcodeConfig(

                  $shortcodesByCode[$dynamicFunction],

                  $targetAttributes,

                  $originalShortcode

                );

              }


              /*
              |--------------------------------------------------------------------------
              | Compatibilidade com qualquer função ainda não listada
              |--------------------------------------------------------------------------
              |
              | Caso a função não represente outro shortcode cadastrado, continua
              | sendo enviada para AutomatorController@getFunction.
              |
              */

              return $executeShortcodeConfig(

                $automatorConfig,

                $attributes,

                $originalShortcode

              );


            },

            $content

          );

        }


        /*
        |--------------------------------------------------------------------------
        | Processa shortcodes no formato direto
        |--------------------------------------------------------------------------
        */

        foreach(

          $shortcodesByCode

          as $shortcodeCode => $shortcodeConfig

        ) {

          if($shortcodeCode === 'automator') {

            continue;

          }


          $pattern =

            '/\[' .

            preg_quote(

              $shortcodeCode,

              '/'

            ) .

            '(?:\s+[^\]]*)?\]/i';


          $content = preg_replace_callback(

            $pattern,

            function($matches) use (

              $shortcodeConfig,

              $executeShortcodeConfig

            ) {


              $originalShortcode =

                $matches[0]

                ?? '';


              if($originalShortcode === '') {

                return '';

              }


              $attributes =

                self::SysAutomatorGetShortcodeAttributes(

                  $originalShortcode

                );


              return $executeShortcodeConfig(

                $shortcodeConfig,

                $attributes,

                $originalShortcode

              );


            },

            $content

          );

        }


        if($content === $contentBeforePass) {

          break;

        }

      }


      return $content;


    }


    public static function SysAutomatorSearchShortcode($slug, $vars = []) {


      if(!$slug || $slug == '') {

        $slug = 'error-404';

      }


      if(!is_array($vars)) {

        $vars = [];

      }


      $routeName = str_replace('page-', '', $slug);


      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();


      if($route !== null) {


        $route = $route->toArray();


        if(count($vars) >= 1) {

          $vars2 = [];


          foreach($vars as $varKey => $varValue) {

            if(!array_key_exists($varKey, $vars2)) {

              $vars2[$varKey] = ((is_string($varValue)) ? str_replace('@replace(route["tbl_sys_route_name"])', $route['tbl_sys_route_name'], $varValue) : $varValue);

            }

          }


          $vars = $vars2;

        }


        $conteudo = self::SysAutomatorRenderDynamicShortcodes($route['tbl_sys_route_content'], $vars, $route);


      } else {


        $route = [

          'tbl_sys_route_name'  => 'error-404',
          'tbl_sys_route_title' => 'Erro 404',
          'tbl_sys_route_area'  => 'public'

        ];


        $conteudo = view('pages.404', [

          'pageName' => $route['tbl_sys_route_title']

        ])->render();


      }


      if($route['tbl_sys_route_area'] == 'restrict') {

        return view('layouts.painel-restrict', [

          'content' => $conteudo,
          'title'   => $route['tbl_sys_route_title'],
          'page'    => $route['tbl_sys_route_name']

        ]);

      }


      return view('layouts.painel-public', [

        'content' => $conteudo,
        'title'   => $route['tbl_sys_route_title'],
        'page'    => $route['tbl_sys_route_name']

      ]);


    }


    public static function SysAutomatorRenderSystemPageWithShortcode($content, $vars = [], $defaultView = '') {


      if($content == null || $content == '') {

        return $content;

      }


      if(!is_array($vars)) {

        $vars = [];

      }


      $shortcodes = SysShortcode::get()->toArray();

      if(count($shortcodes) <= 0) {

        return $content;

      }


      foreach ($shortcodes as $shortcode) {


        if(
          !isset($shortcode['tbl_sys_shortcode_code']) ||
          $shortcode['tbl_sys_shortcode_code'] == ''
        ) {

          continue;

        }


        $shortcodeCode   = $shortcode['tbl_sys_shortcode_code'];
        $shortcodeClass  = $shortcode['tbl_sys_shortcode_class'] ?? '';
        $shortcodeMethod = $shortcode['tbl_sys_shortcode_method'] ?? '';
        $shortcodeParams = [];


        if(
          isset($shortcode['tbl_sys_shortcode_params']) &&
          $shortcode['tbl_sys_shortcode_params'] != ''
        ) {

          $shortcodeParams = json_decode($shortcode['tbl_sys_shortcode_params'], true);

          if(!is_array($shortcodeParams)) {

            $shortcodeParams = [];

          }

        }


        preg_match_all('/\[' . preg_quote($shortcodeCode, '/') . '(?:\s+([^\]]*))?\]/', $content, $matches, PREG_SET_ORDER);


        if(count($matches) <= 0) {

          continue;

        }


        foreach ($matches as $match) {


          $fullShortcode = $match[0] ?? '';
          $attrsString   = $match[1] ?? '';


          if($fullShortcode == '') {

            continue;

          }


          /*
          |--------------------------------------------------------------------------
          | Captura atributos do shortcode
          |--------------------------------------------------------------------------
          |
          | Exemplo:
          | [system-form form="admin-minha-conta" vars="$currentUser"]
          |
          */

          $attrs = [];


          if($attrsString != '') {


            preg_match_all('/([a-zA-Z0-9_\-]+)\s*=\s*"([^"]*)"/', $attrsString, $attrsMatches, PREG_SET_ORDER);

            if(count($attrsMatches) >= 1) {

              foreach($attrsMatches as $attr) {

                $attrName  = $attr[1] ?? '';
                $attrValue = $attr[2] ?? '';

                if($attrName != '') {

                  $attrs[$attrName] = $attrValue;

                }

              }

            }


            preg_match_all("/([a-zA-Z0-9_\-]+)\s*=\s*'([^']*)'/", $attrsString, $attrsMatchesSingle, PREG_SET_ORDER);

            if(count($attrsMatchesSingle) >= 1) {

              foreach($attrsMatchesSingle as $attr) {

                $attrName  = $attr[1] ?? '';
                $attrValue = $attr[2] ?? '';

                if($attrName != '') {

                  $attrs[$attrName] = $attrValue;

                }

              }

            }


          }


          /*
          |--------------------------------------------------------------------------
          | Valida parâmetros obrigatórios cadastrados no shortcode
          |--------------------------------------------------------------------------
          */

          $validParams = true;


          if(count($shortcodeParams) >= 1) {

            foreach($shortcodeParams as $paramName => $required) {

              if($required == true) {

                if(!isset($attrs[$paramName]) || $attrs[$paramName] == '') {

                  $validParams = false;

                }

              }

            }

          }


          if($validParams == false) {

            $content = str_replace($fullShortcode, '', $content);

            continue;

          }


          /*
          |--------------------------------------------------------------------------
          | Resolve variáveis recebidas no atributo vars
          |--------------------------------------------------------------------------
          |
          | Exemplo:
          | vars="$currentUser"
          |
          | Irá buscar:
          | $vars['currentUser']
          |
          */

          $resolvedVars = [];


          if(isset($attrs['vars']) && $attrs['vars'] != '') {


            $_varsName = trim($attrs['vars']);



            if(substr($_varsName, 0, 1) == '$') {

              $_varsName = substr($_varsName, 1);

              if(isset($vars[$_varsName])) {

                $resolvedVars = $vars[$_varsName];

              }

            } else {

              if(isset($vars[$_varsName])) {

                $resolvedVars = $vars[$_varsName];

              }

            }


            // dd($resolvedVars);


            if(!is_array($resolvedVars)) {

              $resolvedVars = [];

            }


          }


          /*
          |--------------------------------------------------------------------------
          | Shortcode system-form
          |--------------------------------------------------------------------------
          |
          | Estrutura:
          | [system-form form="admin-minha-conta" vars="$currentUser"]
          |
          */

          if($shortcodeCode == 'system-form') {


            $formName = $attrs['form'] ?? '';
            $shortcodeContent = '';


            if($formName != '') {

              $formID = self::SysAutomatorGetFormIDByName($formName);

              if($formID != null && $formID != '') {

                $form = self::SysAutomatorRenderFormByID($formID, $resolvedVars);

                if(is_array($form)) {

                  $shortcodeContent = $form['html'] ?? '';

                } else {

                  $shortcodeContent = $form;

                }

              }

            }


            $content = str_replace($fullShortcode, $shortcodeContent, $content);

            continue;


          }


          /*
          |--------------------------------------------------------------------------
          | Shortcode system-pages
          |--------------------------------------------------------------------------
          |
          | Estrutura:
          | [system-pages view="minha.view" args="$algumaVariavel"]
          |
          */

          if($shortcodeCode == 'system-pages') {


            $view = $attrs['view'] ?? $defaultView;
            $shortcodeContent = '';

            if($view != '' && view()->exists($view)) {

              $shortcodeContent = view($view, $resolvedVars)->render();

            }


            $content = str_replace($fullShortcode, $shortcodeContent, $content);

            continue;


          }


          /*
          |--------------------------------------------------------------------------
          | Shortcode automator
          |--------------------------------------------------------------------------
          |
          | Estrutura:
          | [automator function="pagination" name="shortcodes-pagination"]
          |
          */

          if($shortcodeCode == 'automator') {


            $shortcodeContent = '';

            $function = $attrs['function'] ?? '';


            if($function != '') {


              if(method_exists(self::class, $function)) {

                $shortcodeContent = self::$function($attrs);

              } else {


                $methodName = 'SysAutomator' . ucfirst($function);

                if(method_exists(self::class, $methodName)) {

                  $shortcodeContent = self::$methodName($attrs);

                }


              }


            }


            $content = str_replace($fullShortcode, $shortcodeContent, $content);

            continue;


          }


          /*
          |--------------------------------------------------------------------------
          | Execução dinâmica baseada na tabela tbl_sys_shortcodes
          |--------------------------------------------------------------------------
          */

          $shortcodeContent = '';


          if($shortcodeClass != '' && $shortcodeMethod != '') {


            if($shortcodeClass == 'SysAutomator') {


              if(method_exists(self::class, $shortcodeMethod)) {

                $shortcodeContent = self::$shortcodeMethod($attrs, $resolvedVars);

              }


            } else {


              $controllerClass = '\\App\\Http\\Controllers\\' . $shortcodeClass;


              if(class_exists($controllerClass)) {

                $controller = app($controllerClass);

                if(method_exists($controller, $shortcodeMethod)) {

                  $shortcodeContent = $controller->$shortcodeMethod(request(), $attrs, $resolvedVars);

                }

              }


            }


          }


          if(is_array($shortcodeContent)) {

            $shortcodeContent = $shortcodeContent['html'] ?? '';

          }


          $content = str_replace($fullShortcode, $shortcodeContent, $content);


        }


      }


      return $content;


      
    }


    public static function SysAutomatoRenderRouteContent($slug, $vars = [], $area = 'restrict') {


      $routeName = str_replace('page-', '', $slug);

      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();


      if($route !== null) {

        $route = $route->toArray();

        if(count($vars) >= 1) {

          $vars2 = [];

          foreach($vars as $varKey => $varValue) {

            if(!array_key_exists($varKey, $vars2)) {

              $vars2[$varKey] = ((is_string($varValue)) ? str_replace('@replace(route["tbl_sys_route_name"])', $route['tbl_sys_route_name'], $varValue) : $varValue);

            }

          }

          $vars = $vars2;

        }


        $conteudo = self::SysAutomatorRenderDynamicShortcodes($route['tbl_sys_route_content'], $vars, $route);


      } else {

        $route = [

          'tbl_sys_route_name'  => 'error-404',
          'tbl_sys_route_title' => 'Erro 404',
          'tbl_sys_route_area'  => 'public'

        ];


        $conteudo = view('pages.404', [

          'pageName' => $route['tbl_sys_route_title']

        ])->render();

      }


      if($route['tbl_sys_route_area'] == 'restrict') {

        return view('layouts.painel-restrict', [

          'content' => $conteudo,
          'title'   => $route['tbl_sys_route_title'],
          'page'    => $route['tbl_sys_route_name']

        ]);

      }


      if( ($route['tbl_sys_route_admin'] == false) || $route['tbl_sys_route_admin'] == 0 ) {

        return view('layouts.public', [

          'content' => $conteudo,
          'title'   => $route['tbl_sys_route_title'],
          'page'    => $route['tbl_sys_route_name']

        ]);

      }


      return view('layouts.painel-public', [

        'content' => $conteudo,
        'title'   => $route['tbl_sys_route_title'],
        'page'    => $route['tbl_sys_route_name']

      ]);


    }
    

    public static function SysAutomatoRenderRouteContent2($slug, $vars = [], $area = 'restrict') {


      return self::SysAutomatoRenderRouteContent($slug, $vars, $area);


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


        /*
        |--------------------------------------------------------------------------
        | Garante variável tbl_sys_menu_item_can_delete
        |--------------------------------------------------------------------------
        |
        | Mantém compatibilidade com itens antigos e garante
        | que todos os menus e submenus possuam a variável.
        |
        | Resultado esperado:
        |
        | tbl_sys_menu_item_can_delete => [1,2,4]
        |
        */

        if (
          !isset($item['tbl_sys_menu_item_can_delete']) ||
          !is_array($item['tbl_sys_menu_item_can_delete'])
        ) {

          $item['tbl_sys_menu_item_can_delete'] = [];

        }


        $itemID = isset($item['tbl_sys_menu_item_ID']) ? $item['tbl_sys_menu_item_ID'] : null;

        $children = self::SysAutomatorBuildNavMenuItensTree($itens, $itemID);

        $item['children'] = $children;
        $item['sub_itens'] = $children;

        $retorno[] = $item;


      }


      return $retorno;


    }



    public static function SysAutomatorGenerateNavMenu( $navName, $display = 'nav' ) {


      $retorno = '';

      $navData = self::SysAutomatorGetNavMenuItens($navName);
      // echo '<pre>';
      // var_dump($navData);
      // echo '</pre>'

      if(count($navData) >= 1) {

        $nav  = $navData['nav'];
        $menu = $navData['menu'];
        if(count($menu) >= 1) {
          
          $items = $navData['items'];
          if(count($items) >= 1) {

            $currentRouteName = Route::currentRouteName();

            $container = ( ($display == 'nav') ? 'nav' : 'ul' );

            $retorno  = '<' . $container . ( ($menu['tbl_sys_menu_index'] != '') ? ' id="' . $menu['tbl_sys_menu_index'] . '"' : '' ) . ( ($menu['tbl_sys_menu_class'] != '') ? ' class="' . $menu['tbl_sys_menu_class'] . '"' : '' ) . '>' . "\n";

              foreach ($items as $item) {
                
                $_activeClass = '';

                if (
                  isset($item['tbl_sys_menu_item_type']) &&
                  $item['tbl_sys_menu_item_type'] == 'route' &&
                  isset($item['tbl_sys_route_ID']) &&
                  $item['tbl_sys_route_ID'] != ''
                ) {

                  $SysRouteActive = SysRoute::where('tbl_sys_route_ID', $item['tbl_sys_route_ID'])->first();

                  if ($SysRouteActive !== null) {

                    if (
                      $currentRouteName == $SysRouteActive->tbl_sys_route_name ||
                      $currentRouteName == 'page.' . $SysRouteActive->tbl_sys_route_name ||
                      $currentRouteName == 'api.' . $SysRouteActive->tbl_sys_route_name
                    ) {

                      $_activeClass = ' active';

                    }

                  }

                }


                $_hasActiveChild = false;

                if (!empty($item['children'])) {

                  foreach ($item['children'] as $_checkSubItem) {

                    if (
                      isset($_checkSubItem['tbl_sys_menu_item_type']) &&
                      $_checkSubItem['tbl_sys_menu_item_type'] == 'route' &&
                      isset($_checkSubItem['tbl_sys_route_ID']) &&
                      $_checkSubItem['tbl_sys_route_ID'] != ''
                    ) {

                      $_SysRouteSubActive = SysRoute::where('tbl_sys_route_ID', $_checkSubItem['tbl_sys_route_ID'])->first();

                      if ($_SysRouteSubActive !== null) {

                        if (
                          $currentRouteName == $_SysRouteSubActive->tbl_sys_route_name ||
                          $currentRouteName == 'page.' . $_SysRouteSubActive->tbl_sys_route_name ||
                          $currentRouteName == 'api.' . $_SysRouteSubActive->tbl_sys_route_name
                        ) {

                          $_hasActiveChild = true;
                          $_activeClass = ' active';

                        }

                      }

                    }

                  }

                }
                
                $_props = '';
                $props = ( ($item['tbl_sys_menu_item_props'] != '') ? ( (array) (json_decode($item['tbl_sys_menu_item_props'])) ) : [] );

                if(count($props) >= 1) {

                  foreach ($props as $propKey => $propValue) {

                    $_props .= ' ' . $propKey . '="' . $propValue . '"';

                  }

                }

                if($display == 'nav') {

                  if (!empty($item['children'])) {

                    $retorno .= '<button type="button"' . ( ($item['tbl_sys_menu_item_class'] != '' || $_activeClass != '') ? ' class="' . trim($item['tbl_sys_menu_item_class'] . $_activeClass) . '"' : '' ) . ' data-bs-toggle="collapse" data-bs-target="#' . $nav['tbl_sys_nav_name'] . '-' . $menu['tbl_sys_menu_ID'] . '-' . $item['tbl_sys_menu_item_ID'] . '" aria-expanded="' . ( ($_hasActiveChild) ? 'true' : 'false' ) . '" aria-controls="' . $nav['tbl_sys_nav_name'] . '-' . $menu['tbl_sys_menu_ID'] . '-' . $item['tbl_sys_menu_item_ID'] . '"' . $_props . '>' . "\n";
                      
                      if($item['tbl_sys_menu_item_icon'] != '') {
                        
                        $retorno .= '<i class="fa fa-' . $item['tbl_sys_menu_item_icon'] . '"></i>' . "\n";

                      }

                      $retorno .= '<span>' . $item['tbl_sys_menu_item_title'] . '</span>' . "\n";
                      $retorno .= '<i class="fa fa-chevron-right sidebar-arrow"></i>' . "\n";

                    $retorno .= '</button>' . "\n";
                    $retorno .= '<div class="collapse sidebar-submenu' . ( ($_hasActiveChild) ? ' show' : '' ) . '" id="' . $nav['tbl_sys_nav_name'] . '-' . $menu['tbl_sys_menu_ID'] . '-' . $item['tbl_sys_menu_item_ID'] . '">' . "\n";
                      
                      foreach ($item['children'] as $subItem) {
                        
                        $_subActiveClass = '';

                        if (
                          isset($subItem['tbl_sys_menu_item_type']) &&
                          $subItem['tbl_sys_menu_item_type'] == 'route' &&
                          isset($subItem['tbl_sys_route_ID']) &&
                          $subItem['tbl_sys_route_ID'] != ''
                        ) {

                          $SysRouteSubActive = SysRoute::where('tbl_sys_route_ID', $subItem['tbl_sys_route_ID'])->first();

                          if ($SysRouteSubActive !== null) {

                            if (
                              $currentRouteName == $SysRouteSubActive->tbl_sys_route_name ||
                              $currentRouteName == 'page.' . $SysRouteSubActive->tbl_sys_route_name ||
                              $currentRouteName == 'api.' . $SysRouteSubActive->tbl_sys_route_name
                            ) {

                              $_subActiveClass = ' active';

                            }

                          }

                        }


                        $_subprops = '';
                        $subprops = ( ($subItem['tbl_sys_menu_item_props'] != '') ? json_decode($subItem['tbl_sys_menu_item_props']) : [] );

                        if(count($subprops) >= 1) {

                          foreach ($subprops as $subpropKey => $subpropValue) {

                            $_subprops .= ' ' . $subpropKey . '="' . $subpropValue . '"';

                          }

                        }

                        if($subItem['tbl_sys_menu_item_type'] == 'route' || $subItem['tbl_sys_menu_item_type'] == 'link') {
                          
                          if($subItem['tbl_sys_menu_item_type'] == 'route') {

                            $retorno .= '<a' . ( ($subItem['tbl_sys_menu_item_index'] != '') ? ' id="'. $subItem['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($subItem['tbl_sys_menu_item_class'] != '' || $_subActiveClass != '') ? ' class="' . trim($subItem['tbl_sys_menu_item_class'] . $_subActiveClass) . '"' : '' ) . ' href="' . ( ($subItem['tbl_sys_menu_item_url'] != '') ? $subItem['tbl_sys_menu_item_url'] : '#' ) . '"' . $_subprops . '>' . "\n";
                          
                              if($subItem['tbl_sys_menu_item_icon'] != '') {

                                $retorno .= '<i class="fa fa-' . $subItem['tbl_sys_menu_item_icon'] . '"></i>' . "\n";

                              }

                              $retorno .= '<span>' . $subItem['tbl_sys_menu_item_title'] . '</span>' . "\n";

                            $retorno .= '</a>' . "\n";

                          } else {

                            $retorno .= '<a' . ( ($subItem['tbl_sys_menu_item_index'] != '') ? ' id="'. $subItem['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($subItem['tbl_sys_menu_item_class'] != '') ? ' class="' . $subItem['tbl_sys_menu_item_class'] . '"' : '' ) . ' href="' . ( ($subItem['tbl_sys_menu_item_link'] != '') ? $subItem['tbl_sys_menu_item_link'] : '#' ) . '"' . $_subprops . '>' . "\n";
                          
                              if($subItem['tbl_sys_menu_item_icon'] != '') {

                                $retorno .= '<i class="fa fa-' . $subItem['tbl_sys_menu_item_icon'] . '"></i>' . "\n";

                              }

                              $retorno .= '<span>' . $subItem['tbl_sys_menu_item_title'] . '</span>' . "\n";

                            $retorno .= '</a>' . "\n";

                          }

                        } elseif($subItem['tbl_sys_menu_item_type'] == 'divider') {

                          $retorno .= '<div' . ( ($subItem['tbl_sys_menu_item_index'] != '') ? ' id="'. $subItem['tbl_sys_menu_item_index'] . '"' : '' ) . ' class="sidebar-submenu-divider' . ( ($subItem['tbl_sys_menu_item_class'] != '') ? ' ' . $subItem['tbl_sys_menu_item_class'] : '' ) . '"></div>' . "\n";

                        } else {

                          $retorno .= '<div' . ( ($subItem['tbl_sys_menu_item_index'] != '') ? ' id="'. $subItem['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($subItem['tbl_sys_menu_item_class'] != '') ? ' class="' . $subItem['tbl_sys_menu_item_class'] . '"' : '' ) . '>' . "\n";
                        
                            $retorno .= '<button type="button"' . $_subprops . '>' . ( ($subItem['tbl_sys_menu_item_icon'] != '') ? '<i class="fa fa-' . $subItem['tbl_sys_menu_item_icon'] . '"></i>' : '' ) . '<span>' . $subItem['tbl_sys_menu_item_title'] . '</span>' . '</button>' . "\n";

                          $retorno .= '</div>' . "\n";

                        }

                      }

                    $retorno .= '</div>' . "\n";

                  } else {

                    if($item['tbl_sys_menu_item_type'] == 'route' || $item['tbl_sys_menu_item_type'] == 'link') {

                      if($item['tbl_sys_menu_item_type'] == 'route') {

                        $retorno .= '<a' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($item['tbl_sys_menu_item_class'] != '' || $_activeClass != '') ? ' class="' . trim($item['tbl_sys_menu_item_class'] . $_activeClass) . '"' : '' ) . ' href="' . ( ($item['tbl_sys_menu_item_url'] != '') ? $item['tbl_sys_menu_item_url'] : '#' ) . '"' . $_props . '>' . "\n";
                          
                          if($item['tbl_sys_menu_item_icon'] != '') {

                            $retorno .= '<i class="fa fa-' . $item['tbl_sys_menu_item_icon'] . '"></i>' . "\n";

                          }

                          $retorno .= '<span>' . $item['tbl_sys_menu_item_title'] . '</span>' . "\n";

                        $retorno .= '</a>' . "\n";

                      } else {

                        $retorno .= '<a' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($item['tbl_sys_menu_item_class'] != '') ? ' class="' . $item['tbl_sys_menu_item_class'] . '"' : '' ) . ' href="' . ( ($item['tbl_sys_menu_item_link'] != '') ? $item['tbl_sys_menu_item_link'] : '#' ) . '"' . $_props . '>' . "\n";
                          
                          if($item['tbl_sys_menu_item_icon'] != '') {

                            $retorno .= '<i class="fa fa-' . $item['tbl_sys_menu_item_icon'] . '"></i>' . "\n";

                          }

                          $retorno .= '<span>' . $item['tbl_sys_menu_item_title'] . '</span>' . "\n";

                        $retorno .= '</a>' . "\n";

                      }

                    } elseif($item['tbl_sys_menu_item_type'] == 'divider') {

                      $retorno .= '<div' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ' class="sidebar-divider' . ( ($item['tbl_sys_menu_item_class'] != '') ? ' ' . $item['tbl_sys_menu_item_class'] : '' ) . '"></div>' . "\n";

                    } else {


                      $retorno .= '<div' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($item['tbl_sys_menu_item_class'] != '') ? ' class="' . $item['tbl_sys_menu_item_class'] . '"' : '' ) . '>' . "\n";
                        
                        $retorno .= '<button type="button"' . $_props . '>' . ( ($item['tbl_sys_menu_item_icon'] != '') ? '<i class="fa fa-' . $item['tbl_sys_menu_item_icon'] . '"></i>' : '' ) . '<span>' . $item['tbl_sys_menu_item_title'] . '</span>' . '</button>' . "\n";

                      $retorno .= '</div>' . "\n";

                    }

                  }

                } else {

                  $retorno .= '<li>' . "\n";

                    if (!empty($item['children'])) {
                    } else {

                      if($item['tbl_sys_menu_item_type'] == 'route' || $item['tbl_sys_menu_item_type'] == 'link') {

                        if($item['tbl_sys_menu_item_type'] == 'route') {

                          $retorno .= '<a' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($item['tbl_sys_menu_item_class'] != '' || $_activeClass != '') ? ' class="' . trim($item['tbl_sys_menu_item_class'] . $_activeClass) . '"' : '' ) . ' href="' . ( ($item['tbl_sys_menu_item_url'] != '') ? $item['tbl_sys_menu_item_url'] : '#' ) . '"' . $_props . '>' . "\n";
                            
                            if($item['tbl_sys_menu_item_icon'] != '') {

                              $retorno .= '<i class="fa fa-' . $item['tbl_sys_menu_item_icon'] . '"></i>' . "\n";

                            }

                            $retorno .= '<span>' . $item['tbl_sys_menu_item_title'] . '</span>' . "\n";

                          $retorno .= '</a>' . "\n";

                        } else {

                          $retorno .= '<a' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($item['tbl_sys_menu_item_class'] != '') ? ' class="' . $item['tbl_sys_menu_item_class'] . '"' : '' ) . ' href="' . ( ($item['tbl_sys_menu_item_link'] != '') ? $item['tbl_sys_menu_item_link'] : '#' ) . '"' . $_props . '>' . "\n";
                            
                            if($item['tbl_sys_menu_item_icon'] != '') {

                              $retorno .= '<i class="fa fa-' . $item['tbl_sys_menu_item_icon'] . '"></i>' . "\n";

                            }

                            $retorno .= '<span>' . $item['tbl_sys_menu_item_title'] . '</span>' . "\n";

                          $retorno .= '</a>' . "\n";

                        }


                      } elseif($item['tbl_sys_menu_item_type'] == 'divider') {

                        $retorno .= '<hr ' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ' class="dropdown-divider' . ( ($item['tbl_sys_menu_item_class'] != '') ? ' ' . $item['tbl_sys_menu_item_class'] : '' ) . '" />' . "\n";

                      } else {
                        $retorno .= '<div' . ( ($item['tbl_sys_menu_item_index'] != '') ? ' id="'. $item['tbl_sys_menu_item_index'] . '"' : '' ) . ( ($item['tbl_sys_menu_item_class'] != '') ? ' class="' . $item['tbl_sys_menu_item_class'] . '"' : '' ) . '>' . "\n";
                        
                          $retorno .= '<button type="button"' . $_props . '>' . ( ($item['tbl_sys_menu_item_icon'] != '') ? '<i class="fa fa-' . $item['tbl_sys_menu_item_icon'] . '"></i>' : '' ) . '<span>' . $item['tbl_sys_menu_item_title'] . '</span>' . '</button>' . "\n";

                        $retorno .= '</div>' . "\n";
                      }

                    }

                  $retorno .= '</li>' . "\n";

                }

              }

            $retorno .= '</' . $container . '>' . "\n";

          }

        }

      }

      return $retorno;


    }



    function SysAutomatorGetPKColumn($table) {


      $key = DB::selectOne("SHOW KEYS FROM {$table} WHERE Key_name = 'PRIMARY'");

      return $key->Column_name ?? null;


    }


    /*
    |--------------------------------------------------------------------------
    | Normaliza operadores utilizados nos filtros da paginação
    |--------------------------------------------------------------------------
    */

    public static function SysAutomatorNormalizePaginationWhereOperator( $operator ): string {


      $operator = trim(

        (string) $operator

      );


      $operators = [

        '=='  => '=',

        '===' => '=',

        '='   => '=',

        '!='  => '!=',

        '!==' => '!=',

        '<>'  => '!=',

        '>'   => '>',

        '>='  => '>=',

        '<'   => '<',

        '<='  => '<=',

        'like' => 'like',

        'LIKE' => 'like',

      ];


      if(
        array_key_exists(

          $operator,

          $operators

        )
      ) {

        return $operators[$operator];

      }


      return '=';


    }


    /*
    |--------------------------------------------------------------------------
    | Normaliza o comparador lógico da condição
    |--------------------------------------------------------------------------
    */

    public static function SysAutomatorNormalizePaginationWhereBoolean( $boolean ): string {


      $boolean = strtolower(

        trim(

          (string) $boolean

        )

      );


      return $boolean === 'or'

        ? 'or'

        : 'and';


    }


    /*
    |--------------------------------------------------------------------------
    | Normaliza as condições where recebidas pela paginação
    |--------------------------------------------------------------------------
    */

    public static function SysAutomatorNormalizePaginationWhereConditions( $where ): array {


      if(is_string($where)) {


        $decodedWhere = json_decode(

          $where,

          true

        );


        if(
          json_last_error() === JSON_ERROR_NONE &&
          is_array($decodedWhere)
        ) {

          $where = $decodedWhere;

        } else {

          return [];

        }


      }


      if(!is_array($where)) {

        return [];

      }


      /*
      |--------------------------------------------------------------------------
      | Aceita uma única condição sem array externo
      |--------------------------------------------------------------------------
      */


      if(
        isset($where[0]) &&
        !is_array($where[0]) &&
        !is_object($where[0])
      ) {

        $where = [

          $where

        ];

      }


      $normalizedConditions = [];


      foreach(
        array_values($where)
        as $conditionIndex => $condition
      ) {


        if(is_object($condition)) {

          $condition = (array) $condition;

        }


        if(!is_array($condition)) {

          continue;

        }


        $column = '';

        $operator = '=';

        $value = null;

        $boolean = 'and';


        if(array_is_list($condition)) {


          if(count($condition) === 2) {


            $column = trim(

              (string) (

                $condition[0] ?? ''

              )

            );


            $value =

              $condition[1] ?? null;


          } else {


            $column = trim(

              (string) (

                $condition[0] ?? ''

              )

            );


            $operator =

              $condition[1] ?? '=';


            $value =

              $condition[2] ?? null;


            $boolean =

              $condition[3] ?? 'and';


          }


        } else {


          $column = trim(

            (string) (

              $condition['column'] ??

              $condition['field'] ??

              $condition['key'] ??

              $condition['name'] ??

              ''

            )

          );


          $operator =

            $condition['operator'] ??

            $condition['compare'] ??

            $condition['comparison'] ??

            '=';


          $value =

            array_key_exists(
              'value',
              $condition
            )

              ? $condition['value']

              : null;


          $boolean =

            $condition['boolean'] ??

            $condition['connector'] ??

            $condition['logical'] ??

            'and';


        }


        if($column === '') {

          continue;

        }


        $operator =

          self::SysAutomatorNormalizePaginationWhereOperator(

            $operator

          );


        $boolean =

          self::SysAutomatorNormalizePaginationWhereBoolean(

            $boolean

          );


        if($conditionIndex === 0) {

          $boolean = 'and';

        }


        $normalizedConditions[] = [

          'column' => $column,

          'operator' => $operator,

          'value' => $value,

          'boolean' => $boolean,

        ];


      }


      return $normalizedConditions;


    }



    /*
    |--------------------------------------------------------------------------
    | Normaliza booleanos das configurações de funções internas
    |--------------------------------------------------------------------------
    */

    private static function SysAutomatorNormalizeSysFunctionBoolean(
      $value
    ): bool {


      return in_array(

        $value,

        [

          true,
          1,
          '1',
          'true',
          'TRUE',

        ],

        true

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Interpreta a definição dos parâmetros de uma função interna
    |--------------------------------------------------------------------------
    */

    private static function SysAutomatorParseSysFunctionParamsDefinition(
      $definition
    ): array {


      $params = [];


      if(is_object($definition)) {

        $definition = (array) $definition;

      }


      if(is_array($definition)) {


        foreach($definition as $paramName => $required) {


          if(
            !is_scalar($paramName) ||
            trim((string) $paramName) === ''
          ) {

            continue;

          }


          $params[

            trim(

              (string) $paramName

            )

          ] = self::SysAutomatorNormalizeSysFunctionBoolean(

            $required

          );


        }


        return $params;


      }


      if(
        !is_string($definition) ||
        trim($definition) === ''
      ) {

        return $params;

      }


      $definition = trim(

        $definition

      );


      /*
      |--------------------------------------------------------------------------
      | JSON válido
      |--------------------------------------------------------------------------
      */

      $decodedDefinition = json_decode(

        $definition,

        true

      );


      if(is_array($decodedDefinition)) {


        foreach($decodedDefinition as $paramName => $required) {


          if(
            !is_scalar($paramName) ||
            trim((string) $paramName) === ''
          ) {

            continue;

          }


          $params[

            trim(

              (string) $paramName

            )

          ] = self::SysAutomatorNormalizeSysFunctionBoolean(

            $required

          );


        }


        return $params;


      }


      /*
      |--------------------------------------------------------------------------
      | Formato utilizado atualmente nos Seeders
      |--------------------------------------------------------------------------
      |
      | { 'data': true, 'lang': false }
      |--------------------------------------------------------------------------
      */

      preg_match_all(

        '/[\'"]([^\'"]+)[\'"]\s*:\s*(true|false|1|0)/i',

        $definition,

        $matches,

        PREG_SET_ORDER

      );


      foreach($matches as $match) {


        $paramName = trim(

          (string) (

            $match[1]

            ?? ''

          )

        );


        if($paramName === '') {

          continue;

        }


        $params[$paramName] =

          self::SysAutomatorNormalizeSysFunctionBoolean(

            strtolower(

              (string) (

                $match[2]

                ?? 'false'

              )

            )

          );


      }


      return $params;


    }



    /*
    |--------------------------------------------------------------------------
    | Interpreta os parâmetros enviados em uma chamada @SysFunctions
    |--------------------------------------------------------------------------
    */

    private static function SysAutomatorParseSysFunctionInvocationParams(
      $paramsExpression
    ): array {


      $params = [];


      if(
        $paramsExpression === null ||
        !is_scalar($paramsExpression)
      ) {

        return $params;

      }


      $paramsExpression = trim(

        (string) $paramsExpression

      );


      if(
        $paramsExpression === '' ||
        $paramsExpression === '[]'
      ) {

        return $params;

      }


      preg_match_all(

        '/[\'"]([^\'"]+)[\'"]\s*=>\s*(?:[\'"]((?:\\\\.|[^\'"\\\\])*)[\'"]|(-?\d+(?:\.\d+)?)|(true|false|null))/i',

        $paramsExpression,

        $matches,

        PREG_SET_ORDER

      );


      foreach($matches as $match) {


        $paramName = trim(

          (string) (

            $match[1]

            ?? ''

          )

        );


        if($paramName === '') {

          continue;

        }


        /*
        |--------------------------------------------------------------------------
        | String
        |--------------------------------------------------------------------------
        */

        if(
          isset($match[2]) &&
          $match[2] !== ''
        ) {


          $paramValue = stripcslashes(

            $match[2]

          );


        /*
        |--------------------------------------------------------------------------
        | Número
        |--------------------------------------------------------------------------
        */

        } elseif(
          isset($match[3]) &&
          $match[3] !== ''
        ) {


          $paramValue = str_contains(

            $match[3],

            '.'

          )
            ? (float) $match[3]
            : (int) $match[3];


        /*
        |--------------------------------------------------------------------------
        | Booleano ou null
        |--------------------------------------------------------------------------
        */

        } else {


          $normalizedValue = strtolower(

            (string) (

              $match[4]

              ?? 'null'

            )

          );


          $paramValue = match($normalizedValue) {

            'true'  => true,

            'false' => false,

            default => null,

          };


        }


        $params[$paramName] =

          $paramValue;


      }


      return $params;


    }


    /*
    |--------------------------------------------------------------------------
    | Executa uma função interna registrada no sistema
    |--------------------------------------------------------------------------
    */

    private static function SysAutomatorExecuteSysFunction(
      $functionName,
      array $invocationParams = []
    ): array {


      $functionName = trim(

        (string) $functionName

      );


      if($functionName === '') {

        return [

          'executed' => false,

          'value' => null,

        ];

      }


      try {


        $functionConfig = SysFunction::where(

          'tbl_sys_function_name',

          $functionName

        )->first();


        if($functionConfig === null) {

          return [

            'executed' => false,

            'value' => null,

          ];

        }


        $methodName = trim(

          (string) (

            $functionConfig->tbl_sys_function_fn

            ?? ''

          )

        );


        if(
          $methodName === '' ||
          !method_exists(
            AutomatorController::class,
            $methodName
          )
        ) {

          return [

            'executed' => false,

            'value' => null,

          ];

        }


        $methodReflection = new \ReflectionMethod(

          AutomatorController::class,

          $methodName

        );


        if(!$methodReflection->isPublic()) {

          return [

            'executed' => false,

            'value' => null,

          ];

        }


        $paramsDefinition =

          self::SysAutomatorParseSysFunctionParamsDefinition(

            $functionConfig->tbl_sys_function_params

            ?? []

          );


        $methodParams = [];


        /*
        |--------------------------------------------------------------------------
        | Mantém a ordem registrada na definição dos parâmetros
        |--------------------------------------------------------------------------
        */

        foreach($paramsDefinition as $paramName => $required) {


          if(
            !array_key_exists(
              $paramName,
              $invocationParams
            )
          ) {


            if($required === true) {

              return [

                'executed' => false,

                'value' => null,

              ];

            }


            continue;

          }


          $methodParams[] =

            $invocationParams[$paramName];


        }


        /*
        |--------------------------------------------------------------------------
        | Executa o método registrado
        |--------------------------------------------------------------------------
        |
        | Os métodos atuais das funções internas são estáticos, porém o uso de
        | call_user_func também mantém compatibilidade com métodos públicos
        | chamados através da classe.
        |--------------------------------------------------------------------------
        */

        $value = call_user_func_array(

          [

            AutomatorController::class,

            $methodName,

          ],

          $methodParams

        );


        return [

          'executed' => true,

          'value' => $value,

        ];


      } catch(\Throwable $exception) {


        report(

          $exception

        );


        \Illuminate\Support\Facades\Log::error(

          'Falha ao executar função interna do Automator.',

          [

            'function' => $functionName,

            'parameters' => $invocationParams,

            'exception' => $exception->getMessage(),

            'file' => $exception->getFile(),

            'line' => $exception->getLine(),

          ]

        );


        return [

          'executed' => false,

          'value' => null,

        ];


      }


    }



    /*
    |--------------------------------------------------------------------------
    | Resolve chamadas de funções internas
    |--------------------------------------------------------------------------
    |
    | Exemplo:
    |
    | @SysFunctions(
    |   'sysGetCurrentUserData',
    |   [
    |     'data' => 'tbl_user_ID'
    |   ]
    | )
    |--------------------------------------------------------------------------
    */

    public static function SysAutomatorResolveSysFunctionsValue(
      $value
    ) {


      /*
      |--------------------------------------------------------------------------
      | Array
      |--------------------------------------------------------------------------
      */

      if(is_array($value)) {


        foreach($value as $valueKey => $valueItem) {


          $value[$valueKey] =

            self::SysAutomatorResolveSysFunctionsValue(

              $valueItem

            );


        }


        return $value;


      }


      /*
      |--------------------------------------------------------------------------
      | Objeto
      |--------------------------------------------------------------------------
      */

      if(is_object($value)) {


        foreach(
          get_object_vars($value)
          as $valueKey => $valueItem
        ) {


          $value->{$valueKey} =

            self::SysAutomatorResolveSysFunctionsValue(

              $valueItem

            );


        }


        return $value;


      }


      /*
      |--------------------------------------------------------------------------
      | Mantém valores que não são strings
      |--------------------------------------------------------------------------
      */

      if(!is_string($value)) {

        return $value;

      }


      $originalValue = $value;


      $trimmedValue = trim(

        $value

      );


      if(
        $trimmedValue === '' ||
        !str_starts_with(
          $trimmedValue,
          '@SysFunctions('
        ) ||
        !str_ends_with(
          $trimmedValue,
          ')'
        )
      ) {

        return $value;

      }


      /*
      |--------------------------------------------------------------------------
      | Identifica nome e parâmetros
      |--------------------------------------------------------------------------
      */

      if(

        !preg_match(

          '/^@SysFunctions\(\s*([\'"])([^\'"]+)\1\s*(?:,\s*(\[[\s\S]*\]))?\s*\)$/',

          $trimmedValue,

          $matches

        )

      ) {

        return $value;

      }


      $functionName = trim(

        (string) (

          $matches[2]

          ?? ''

        )

      );


      $paramsExpression =

        $matches[3]

        ?? '[]';


      $invocationParams =

        self::SysAutomatorParseSysFunctionInvocationParams(

          $paramsExpression

        );


      $execution =

        self::SysAutomatorExecuteSysFunction(

          $functionName,

          $invocationParams

        );


      if(

        !is_array($execution) ||

        ($execution['executed'] ?? false) !== true

      ) {

        return $originalValue;

      }


      return $execution['value']

        ?? null;


    }



    /*
    |--------------------------------------------------------------------------
    | Aplica as condições where na consulta da paginação
    |--------------------------------------------------------------------------
    */

    public static function SysAutomatorApplyPaginationWhere(
      $query,
      $where
    ) {


      if(is_callable($where)) {


        $callbackQuery = $where(

          $query

        );


        return $callbackQuery ?? $query;


      }


      $conditions =

        self::SysAutomatorNormalizePaginationWhereConditions(

          $where

        );


      if(count($conditions) <= 0) {

        return $query;

      }


      /*
      |--------------------------------------------------------------------------
      | Resolve funções internas nos valores das condições
      |--------------------------------------------------------------------------
      |
      | A resolução ocorre somente em runtime, depois que o usuário já está
      | autenticado. O banco continua armazenando a expressão original.
      |--------------------------------------------------------------------------
      */

      foreach($conditions as $conditionIndex => $condition) {


        if(
          !is_array($condition) ||
          !array_key_exists(
            'value',
            $condition
          )
        ) {

          continue;

        }


        $conditions[$conditionIndex]['value'] =

          self::SysAutomatorResolveSysFunctionsValue(

            $condition['value']

          );


      }


      $query->where(function($whereQuery) use (
        $conditions
      ) {


        foreach(
          $conditions
          as $conditionIndex => $condition
        ) {


          $column =

            $condition['column'];


          $operator =

            $condition['operator'];


          $value =

            $condition['value'];


          $boolean =

            $conditionIndex === 0

              ? 'and'

              : $condition['boolean'];


          /*
          |--------------------------------------------------------------------------
          | Primeira condição ou comparador AND
          |--------------------------------------------------------------------------
          */

          if($boolean !== 'or') {


            $whereQuery->where(

              $column,

              $operator,

              $value

            );


            continue;


          }


          /*
          |--------------------------------------------------------------------------
          | Comparador OR
          |--------------------------------------------------------------------------
          */

          $whereQuery->orWhere(

            $column,

            $operator,

            $value

          );


        }


      });


      return $query;


    }


    /*
    |--------------------------------------------------------------------------
    | Aplica as condições where na consulta da paginação
    |--------------------------------------------------------------------------
    */

    // public static function SysAutomatorApplyPaginationWhere( $query, $where ) {


    //   if(is_callable($where)) {


    //     $callbackQuery = $where(

    //       $query

    //     );


    //     return $callbackQuery ?? $query;


    //   }


    //   $conditions =

    //     self::SysAutomatorNormalizePaginationWhereConditions(

    //       $where

    //     );


    //   if(count($conditions) <= 0) {

    //     return $query;

    //   }


    //   $query->where(function($whereQuery) use (
    //     $conditions
    //   ) {


    //     foreach(
    //       $conditions
    //       as $conditionIndex => $condition
    //     ) {


    //       $column =

    //         $condition['column'];


    //       $operator =

    //         $condition['operator'];


    //       $value =

    //         $condition['value'];


    //       $boolean =

    //         $conditionIndex === 0

    //           ? 'and'

    //           : $condition['boolean'];


    //       /*
    //       |--------------------------------------------------------------------------
    //       | Primeira condição ou comparador AND
    //       |--------------------------------------------------------------------------
    //       */


    //       if($boolean !== 'or') {


    //         $whereQuery->where(

    //           $column,

    //           $operator,

    //           $value

    //         );


    //         continue;

    //       }


    //       /*
    //       |--------------------------------------------------------------------------
    //       | Comparador OR
    //       |--------------------------------------------------------------------------
    //       */


    //       $whereQuery->orWhere(

    //         $column,

    //         $operator,

    //         $value

    //       );


    //     }


    //   });


    //   return $query;


    // }

    

    public static function SysAutomatorPaginationData( array $params, Request $request ) {


      $table = $params['table'];


      /*
      |--------------------------------------------------------------------------
      | Quantidade de registros por página
      |--------------------------------------------------------------------------
      */


      $perPage = $request->input(

        'per_page',

        $params['per_page'] ??

        Session::get(

          'per_page_' . $table,

          15

        )

      );


      $perPage = max(

        1,

        min(

          (int) $perPage,

          100

        )

      );


      Session::put(

        'per_page_' . $table,

        $perPage

      );


      $query = DB::table(

        $table

      );


      /*
      |--------------------------------------------------------------------------
      | Filtros fixos cadastrados na paginação
      |--------------------------------------------------------------------------
      */


      if(
        array_key_exists(
          'where',
          $params
        ) &&
        $params['where'] !== null &&
        $params['where'] !== ''
      ) {


        $query =

          self::SysAutomatorApplyPaginationWhere(

            $query,

            $params['where']

          );


      }


      /*
      |--------------------------------------------------------------------------
      | Filtros de relacionamentos
      |--------------------------------------------------------------------------
      */


      if(isset($params['with_where'])) {


        $withWhere =

          $params['with_where'];


        if(is_array($withWhere)) {


          foreach(
            $withWhere
            as $relation => $conditions
          ) {


            if(is_callable($conditions)) {


              $query->whereHas(

                $relation,

                $conditions

              );


            } elseif(is_array($conditions)) {


              $query->whereHas(

                $relation,

                function($relationQuery) use (
                  $conditions
                ) {


                  $normalizedConditions =

                    self::SysAutomatorNormalizePaginationWhereConditions(

                      $conditions

                    );


                  foreach(
                    $normalizedConditions
                    as $conditionIndex => $condition
                  ) {


                    $boolean =

                      $conditionIndex === 0

                        ? 'and'

                        : $condition['boolean'];


                    if($boolean === 'or') {


                      $relationQuery->orWhere(

                        $condition['column'],

                        $condition['operator'],

                        $condition['value']

                      );


                      continue;

                    }


                    $relationQuery->where(

                      $condition['column'],

                      $condition['operator'],

                      $condition['value']

                    );


                  }


                }

              );


            }


          }


        }


      }


      /*
      |--------------------------------------------------------------------------
      | Busca
      |--------------------------------------------------------------------------
      */


      if(
        $request->has('search') &&
        isset($params['search_fields'])
      ) {


        $search =

          $request->input('search');


        Session::put(

          'search_' . $table,

          $search

        );


        $selectedFields =

          $request->input(

            'search_in',

            array_keys(

              $params['search_fields']

            )

          );


        $query->where(function($searchQuery) use (
          $search,
          $selectedFields
        ) {


          foreach($selectedFields as $field) {


            $searchQuery->orWhere(

              $field,

              'like',

              '%' . $search . '%'

            );


          }


        });


      }


      /*
      |--------------------------------------------------------------------------
      | Ordenação
      |--------------------------------------------------------------------------
      */


      $sort = $request->input(

        'sort',

        $params['default_sort'] ?? null

      );


      $direction = $request->input(

        'direction',

        $params['default_direction'] ?? 'asc'

      );


      $direction = strtolower(

        trim((string) $direction)

      );


      if(!in_array($direction, ['asc', 'desc'], true)) {

        $direction = 'asc';

      }


      if($sort) {


        $query->orderBy(

          $sort,

          $direction

        );


      }


      $items = $query
        ->paginate(
          $perPage
        )
        ->withQueryString();


      return [

        'items' =>

          $items,

        'columns' =>

          $params['columns'],

        'actions' =>

          $params['actions'] ?? [],

        'index' =>

          $params['index'] ??

          self::SysAutomatorGetPKColumn(

            $table

          ),

        'header_actions' =>

          $params['header_actions'] ?? [],

        'list_actions' =>

          $params['list_actions'] ?? [],

        'search_fields' =>

          $params['search_fields'] ?? [],

        'modals' =>

          $params['modals'] ?? [],

        'modal' =>

          $params['modal'] ?? null,

        'page_name' =>

          $params['page_name'] ?? null,

        'table' =>

          $table,

        'sort' =>

          $sort,

        'direction' =>

          $direction,

        'action_urls' =>

          $params['action_urls'] ?? [],

      ];


    }
    

    public static function SysAutomatorPaginateDynamic(array $params, Request $request) {

      $table = $params['table'];
      
      // Get per_page from request or params or session or default
      $perPage = $request->input('per_page', 
          $params['per_page'] ?? Session::get('per_page_' . $table, 15)
      );
      
      // Ensure per_page is a valid integer
      $perPage = max(1, min((int)$perPage, 100)); // Min 1, Max 100
      Session::put('per_page_' . $table, $perPage);

      $query = DB::table($table);

      // Apply where conditions if provided
      if (isset($params['where'])) {
        $where = $params['where'];
        
        if (is_callable($where)) {
          // If where is a closure, apply it
          $query = $where($query);
        } elseif (is_array($where)) {
          // If where is an array of conditions
          foreach ($where as $condition) {
            if (is_array($condition) && count($condition) >= 2) {
              if (count($condition) === 2) {
                // Simple condition: ['field', 'value']
                $query->where($condition[0], $condition[1]);
              } elseif (count($condition) === 3) {
                // Operator condition: ['field', 'operator', 'value']
                $query->where($condition[0], $condition[1], $condition[2]);
              }
            }
          }
        } elseif (is_string($where)) {
          // If where is a string, try to parse it as JSON or apply directly
          try {
            $whereArray = json_decode($where, true);
            if (is_array($whereArray)) {
              foreach ($whereArray as $condition) {
                if (is_array($condition) && count($condition) >= 2) {
                  if (count($condition) === 2) {
                    $query->where($condition[0], $condition[1]);
                  } elseif (count($condition) === 3) {
                    $query->where($condition[0], $condition[1], $condition[2]);
                  }
                }
              }
            }
          } catch (\Exception $e) {
            // Ignore JSON parse errors
          }
        }
      }

      // Apply relationship filters if provided (for filtering by related table)
      if (isset($params['with_where'])) {
        $withWhere = $params['with_where'];
        
        if (is_array($withWhere)) {
          foreach ($withWhere as $relation => $conditions) {
            if (is_callable($conditions)) {
              $query->whereHas($relation, $conditions);
            } elseif (is_array($conditions)) {
              $query->whereHas($relation, function($q) use ($conditions) {
                foreach ($conditions as $condition) {
                  if (is_array($condition) && count($condition) >= 2) {
                    if (count($condition) === 2) {
                      $q->where($condition[0], $condition[1]);
                    } elseif (count($condition) === 3) {
                      $q->where($condition[0], $condition[1], $condition[2]);
                    }
                  }
                }
              }); 
            }
          }
        }
      }

      // Search
      if ($request->has('search') && isset($params['search_fields'])) {
        $search = $request->input('search');
        Session::put('search_' . $table, $search);
        
        $selectedFields = $request->input('search_in', array_keys($params['search_fields']));
        
        $query->where(function($q) use ($search, $selectedFields) {
          foreach ($selectedFields as $field) {
            $q->orWhere($field, 'like', '%' . $search . '%');
          }
        });
      }

      // Sorting
      $sort = $request->input('sort', $params['default_sort'] ?? null);
      $direction = $request->input('direction', $params['default_direction'] ?? 'asc');
      if ($sort) {
        $query->orderBy($sort, $direction);
      }

      $items = $query->paginate($perPage)->withQueryString();

      return view('system.pages.pagination', [
        'items' => $items,
        'columns' => $params['columns'],
        'actions' => $params['actions'] ?? [],
        'header_actions' => $params['header_actions'] ?? [],
        'search_fields' => $params['search_fields'] ?? [],
        'modals' => $params['modals'] ?? [],
        'modal' => $params['modal'] ?? null,
        'page_name' => $params['page_name'] ?? null,
        'table' => $table,
        'sort' => $sort,
        'direction' => $direction,
        'action_urls' => $params['action_urls'] ?? []
      ]);

    }



    public static function SysAutomatorGetCurrentUserData($data) {


      if(!Auth::check()) {

        return '';

      }

      $_user = Auth::user();


      if($_user->$data != null) {

        return $_user->$data;

      }

      return '';

    }



    public static function SysAutomatorCheckUserAccess($route, $user = null) {


      if($user == null) {

        if(!Auth::check()) {

          return false;

        } else {

          return true;

        }

      } else {

        return true;

      }


      return true;


    }



    public static function SysAutomatorGetFormUserAccessByID($formID) {


      /*
      |--------------------------------------------------------------------------
      | Valida ID do formulário
      |--------------------------------------------------------------------------
      */

      if($formID === null || $formID === '' || $formID == 0) {

        return false;

      }



      /*
      |--------------------------------------------------------------------------
      | Busca formulário
      |--------------------------------------------------------------------------
      */

      $SysForm = SysForm::where('tbl_sys_form_ID', $formID)->first();


      if($SysForm === null) {

        return false;

      }



      /*
      |--------------------------------------------------------------------------
      | Valida se o formulário é privado/admin
      |--------------------------------------------------------------------------
      |
      | Se o formulário não for privado/admin, qualquer usuário pode acessar.
      | Se for privado/admin, será necessário validar usuário logado e permissão
      | pelos tipos de usuário vinculados ao cadastro.
      |
      */

      $formAdmin = $SysForm->tbl_sys_form_admin;


      if(
        $formAdmin === false ||
        $formAdmin === 0 ||
        $formAdmin === '0' ||
        $formAdmin === null ||
        $formAdmin === ''
      ) {

        return true;

      }



      /*
      |--------------------------------------------------------------------------
      | Valida usuário logado
      |--------------------------------------------------------------------------
      */

      if(!Auth::check()) {

        return false;

      }


      $user = Auth::user();


      if($user === null) {

        return false;

      }

      // if(!Auth::guard('web')->check()) {

      //   return false;

      // }


      // $user = Auth::guard('web')->user();


      // if($user === null) {

      //   return false;

      // }



      /*
      |--------------------------------------------------------------------------
      | Busca os tipos vinculados ao usuário logado
      |--------------------------------------------------------------------------
      */

      if(!method_exists($user, 'UserGetTypesIDs')) {

        return false;

      }


      $userTypesIDs = $user->UserGetTypesIDs();


      if(!is_array($userTypesIDs) || count($userTypesIDs) <= 0) {

        return false;

      }



      /*
      |--------------------------------------------------------------------------
      | Valida acesso ao formulário
      |--------------------------------------------------------------------------
      |
      | A tabela tbl_sys_forms_access relaciona:
      | - tbl_sys_form_ID
      | - tbl_users_type_ID
      |
      */

      $hasAccess = SysFormsAccess::where('tbl_sys_form_ID', $SysForm->tbl_sys_form_ID)
        ->whereIn('tbl_users_type_ID', $userTypesIDs)
        ->exists();


      if($hasAccess == true) {

        return true;

      }


      return false;


    }
    



    public static function SysAutomatorGetFormIDByName($formulario = '') {


      if($formulario == "") {

        return "";
        
      } else {

        $form = SysForm::where('tbl_sys_form_name', $formulario)->value('tbl_sys_form_ID');

        return ( ($form !== null) ? $form : "" );

      }


    }



    public static function SysAutomatorGetFormDataBy($campo = 'tbl_sys_form_name', $valor = null) {


      /*
      |--------------------------------------------------------------------------
      | Retorno padrão
      |--------------------------------------------------------------------------
      */

      $response = [

        'status'  => false,
        'message' => 'Formulário não encontrado.',
        'form'    => null,
        'fields'  => [],
        'data'    => [],

      ];



      /*
      |--------------------------------------------------------------------------
      | Valida parâmetros
      |--------------------------------------------------------------------------
      */

      if($campo === null || $campo === '' || $valor === null || $valor === '') {

        $response['message'] = 'Parâmetros inválidos para localizar o formulário.';

        return $response;

      }



      /*
      |--------------------------------------------------------------------------
      | Tabelas
      |--------------------------------------------------------------------------
      */

      $formTable  = (new SysForm())->getTable();
      $fieldTable = (new SysFormsField())->getTable();



      /*
      |--------------------------------------------------------------------------
      | Valida coluna de busca
      |--------------------------------------------------------------------------
      */

      if(!Schema::hasColumn($formTable, $campo)) {

        $response['message'] = 'Campo informado para busca do formulário não existe.';

        return $response;

      }



      /*
      |--------------------------------------------------------------------------
      | Busca formulário
      |--------------------------------------------------------------------------
      */

      $form = SysForm::where($campo, $valor)->first();


      if($form === null) {

        return $response;

      }


      $formData = $form->toArray();



      /*
      |--------------------------------------------------------------------------
      | Busca campos vinculados ao formulário
      |--------------------------------------------------------------------------
      */

      $fieldsQuery = SysFormsField::where('tbl_sys_form_ID', $form->tbl_sys_form_ID);


      if(Schema::hasColumn($fieldTable, 'tbl_sys_forms_field_ordem')) {

        $fieldsQuery->orderBy('tbl_sys_forms_field_ordem', 'asc');

      } else if(Schema::hasColumn($fieldTable, 'tbl_sys_forms_field_order')) {

        $fieldsQuery->orderBy('tbl_sys_forms_field_order', 'asc');

      }


      $fields = $fieldsQuery
        ->orderBy('tbl_sys_forms_field_ID', 'asc')
        ->get();



      /*
      |--------------------------------------------------------------------------
      | Aplica regra de acesso por campo
      |--------------------------------------------------------------------------
      |
      | Regra:
      | - Se o campo não possuir registros em tbl_sys_forms_fields_access,
      |   o campo é público dentro do formulário e será renderizado normalmente.
      |
      | - Se o campo possuir registros em tbl_sys_forms_fields_access,
      |   ele só será renderizado se o usuário logado possuir algum dos tipos
      |   vinculados ao campo.
      |
      */

      $userTypesIDs = self::SysAutomatorGetCurrentUserTypesIDsForAccess();

      $fieldIDs = $fields->pluck('tbl_sys_forms_field_ID')->toArray();

      $fieldsAccess = [];


      if(count($fieldIDs) >= 1) {

        $fieldsAccessRows = SysFormsFieldsAccess::whereIn('tbl_sys_forms_field_ID', $fieldIDs)->get();

        foreach($fieldsAccessRows as $fieldsAccessRow) {

          $accessFieldID = $fieldsAccessRow->tbl_sys_forms_field_ID;

          if(!isset($fieldsAccess[$accessFieldID])) {

            $fieldsAccess[$accessFieldID] = [];

          }

          $fieldsAccess[$accessFieldID][] = $fieldsAccessRow->tbl_users_type_ID;

        }

      }



      /*
      |--------------------------------------------------------------------------
      | Monta campos com relação do tipo de campo
      |--------------------------------------------------------------------------
      */

      $fieldsData = [];


      foreach($fields as $field) {


        $fieldID = $field->tbl_sys_forms_field_ID;


        /*
        |--------------------------------------------------------------------------
        | Verifica acesso ao campo
        |--------------------------------------------------------------------------
        */

        if(isset($fieldsAccess[$fieldID]) && count($fieldsAccess[$fieldID]) >= 1) {

          $allowedTypes = $fieldsAccess[$fieldID];

          $hasFieldAccess = false;

          foreach($userTypesIDs as $userTypeID) {

            if(in_array($userTypeID, $allowedTypes)) {

              $hasFieldAccess = true;

              break;

            }

          }


          if($hasFieldAccess != true) {

            continue;

          }

        }


        $fieldData = $field->toArray();



        /*
        |--------------------------------------------------------------------------
        | Tipo do campo
        |--------------------------------------------------------------------------
        */

        $fieldTypeData = null;


        if(isset($field->tbl_sys_field_type_ID) && $field->tbl_sys_field_type_ID != '') {

          $fieldType = SysFieldType::where('tbl_sys_field_type_ID', $field->tbl_sys_field_type_ID)->first();

          if($fieldType !== null) {

            $fieldTypeData = $fieldType->toArray();

          }

        }



        /*
        |--------------------------------------------------------------------------
        | Normaliza JSONs do campo
        |--------------------------------------------------------------------------
        */

        $fieldProps = [];
        $fieldAttrs = [];
        $fieldConfig = [];


        if(isset($fieldData['tbl_sys_forms_field_props']) && $fieldData['tbl_sys_forms_field_props'] != '') {

          $decoded = json_decode($fieldData['tbl_sys_forms_field_props'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $fieldProps = $decoded;

          }

        }


        if(isset($fieldData['tbl_sys_forms_field_attrs']) && $fieldData['tbl_sys_forms_field_attrs'] != '') {

          $decoded = json_decode($fieldData['tbl_sys_forms_field_attrs'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $fieldAttrs = $decoded;

          }

        }


        if(isset($fieldData['tbl_sys_forms_field_config']) && $fieldData['tbl_sys_forms_field_config'] != '') {

          $decoded = json_decode($fieldData['tbl_sys_forms_field_config'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $fieldConfig = $decoded;

          }

        }



        /*
        |--------------------------------------------------------------------------
        | Normaliza JSONs do tipo de campo
        |--------------------------------------------------------------------------
        */

        $fieldTypeParams = [];


        if(is_array($fieldTypeData) && isset($fieldTypeData['tbl_sys_field_type_params']) && $fieldTypeData['tbl_sys_field_type_params'] != '') {

          $decoded = json_decode($fieldTypeData['tbl_sys_field_type_params'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $fieldTypeParams = $decoded;

          }

        }


        if(is_array($fieldTypeData)) {

          $fieldTypeData['params'] = $fieldTypeParams;

        }



        /*
        |--------------------------------------------------------------------------
        | Metadados compatíveis com AJAX e Blade
        |--------------------------------------------------------------------------
        */

        $fieldName = $fieldData['tbl_sys_forms_field_name'] ?? '';

        $fieldData['props']          = $fieldProps;
        $fieldData['attrs']          = $fieldAttrs;
        $fieldData['config']         = $fieldConfig;
        $fieldData['field_type']     = $fieldTypeData;
        $fieldData['field_name']     = $fieldName;
        $fieldData['field_id']       = 'field_' . $fieldID;
        $fieldData['field_selector'] = ($fieldName != '') ? '[name="' . $fieldName . '"]' : '';
        $fieldData['value']          = '';
        $fieldData['fillable']       = true;


        $fieldsData[] = $fieldData;


      }



      /*
      |--------------------------------------------------------------------------
      | Retorno final
      |--------------------------------------------------------------------------
      */

      $response['status']  = true;
      $response['message'] = 'Formulário encontrado.';
      $response['form']    = $formData;
      $response['fields']  = $fieldsData;
      $response['data']    = [];
      $response['populate'] = [

        'enabled' => true,
        'source'  => 'external',
        'action'  => null,
        'id'      => null,
        'values'  => [],

      ];


      return $response;


    }



    public static function SysAutomatorRenderFormBuilderFields() {


      $fieldTypes = SysFieldType::where('tbl_sys_field_type_layout', false)
        ->orderBy('tbl_sys_field_type_group_ID', 'ASC')
        ->orderBy('tbl_sys_field_type_ID', 'ASC')
        ->get();


      $groupIds = $fieldTypes
        ->pluck('tbl_sys_field_type_group_ID')
        ->unique()
        ->values()
        ->toArray();


      $groups = SysFieldTypesGroup::whereIn(
          'tbl_sys_field_type_group_ID',
          $groupIds
        )
        ->orderBy('tbl_sys_field_type_group_ordem', 'ASC')
        ->get();


      $fieldsByGroup = $fieldTypes->groupBy('tbl_sys_field_type_group_ID');


      return $groups
        ->map(function($group) use ($fieldsByGroup) {

          return [

            'tbl_sys_field_type_group_ID'     => $group->tbl_sys_field_type_group_ID,
            'tbl_sys_field_type_group_name'   => $group->tbl_sys_field_type_group_name,
            'tbl_sys_field_type_group_title'  => $group->tbl_sys_field_type_group_title,

            'tbl_sys_field_type_group_fields' => isset($fieldsByGroup[$group->tbl_sys_field_type_group_ID])
              ? $fieldsByGroup[$group->tbl_sys_field_type_group_ID]->values()->toArray()
              : []

          ];

        })
        ->values()
        ->toArray();


    }




    public static function SysAutomatorRenderPaginationBuilderFields() {


      $fieldTypes = SysFieldType::where('tbl_sys_field_type_layout', false)
        ->whereNotNull('tbl_sys_field_type_pagination')
        ->whereRaw("TRIM(tbl_sys_field_type_pagination) != ''")
        ->orderBy('tbl_sys_field_type_group_ID', 'ASC')
        ->orderBy('tbl_sys_field_type_ID', 'ASC')
        ->get();


      $fieldTypes = $fieldTypes
        ->filter(function($fieldType) {


          $pagination = $fieldType->tbl_sys_field_type_pagination;


          if(
            $pagination === null ||
            trim((string) $pagination) == ''
          ) {

            return false;

          }


          $pagination = json_decode($pagination, true);


          if(
            !is_array($pagination) ||
            count($pagination) <= 0
          ) {

            return false;

          }


          return true;


        })
        ->values();


      if($fieldTypes->isEmpty()) {

        return [];

      }


      $groupIds = $fieldTypes
        ->pluck('tbl_sys_field_type_group_ID')
        ->unique()
        ->values()
        ->toArray();


      $groups = SysFieldTypesGroup::whereIn(
          'tbl_sys_field_type_group_ID',
          $groupIds
        )
        ->orderBy('tbl_sys_field_type_group_ordem', 'ASC')
        ->get();


      $fieldsByGroup = $fieldTypes->groupBy('tbl_sys_field_type_group_ID');


      return $groups
        ->map(function($group) use ($fieldsByGroup) {

          return [

            'tbl_sys_field_type_group_ID'     => $group->tbl_sys_field_type_group_ID,
            'tbl_sys_field_type_group_name'   => $group->tbl_sys_field_type_group_name,
            'tbl_sys_field_type_group_title'  => $group->tbl_sys_field_type_group_title,

            'tbl_sys_field_type_group_fields' => isset($fieldsByGroup[$group->tbl_sys_field_type_group_ID])
              ? $fieldsByGroup[$group->tbl_sys_field_type_group_ID]->values()->toArray()
              : []

          ];

        })
        ->filter(function($group) {

          return count($group['tbl_sys_field_type_group_fields']) >= 1;

        })
        ->values()
        ->toArray();


    }


    public static function SysAutomatorRenderPaginationRoutesList($type = 'web') {


      $retorno = [];

      $type = ( ($type == 'api') ? true : false );

      $routes = SysRoute::getRoutes([

        'where' => [

          'tbl_sys_route_status' => 'ativo',
          'tbl_sys_route_api'    => $type,

        ],

      ]);

      $_routes = [];
      foreach ($routes as $route) {

        if(!in_array($route['tbl_sys_route_name'], $_routes)) {

          $_routes[$route['tbl_sys_route_name']] = $route['tbl_sys_route_title'];

        }

      }

      $retorno = $_routes;

      return $retorno;

    }



    public static function SysAutomatorRenderFormByID($formID, $values = []) {


      /*
      |--------------------------------------------------------------------------
      | Busca dados do formulário
      |--------------------------------------------------------------------------
      */

      $response = self::SysAutomatorGetFormDataBy('tbl_sys_form_ID', $formID);


      if(!isset($response['status']) || $response['status'] !== true) {

        return $response;

      }



      /*
      |--------------------------------------------------------------------------
      | Renderiza campos
      |--------------------------------------------------------------------------
      */

      $rendered = AutomatorFields::renderFormFields($response, $values);


      $response['fields'] = $rendered['fields'];
      $response['html']   = $rendered['html'];
      $response['data']   = $values;


      if(isset($response['populate']) && is_array($response['populate'])) {

        $response['populate']['values'] = $values;

      }


      return $response;


    }






    public static function SysAutomatorGetPaginationDataBy($campo = 'tbl_sys_pagination_name', $valor = null) {


      /*
      |--------------------------------------------------------------------------
      | Retorno padrão
      |--------------------------------------------------------------------------
      */

      $response = [

        'status'     => false,
        'message'    => 'Paginação não encontrada.',
        'pagination' => null,
        'args'       => [],
        'columns'    => [],

      ];



      /*
      |--------------------------------------------------------------------------
      | Valida parâmetros
      |--------------------------------------------------------------------------
      */

      if($campo === null || $campo === '' || $valor === null || $valor === '') {

        $response['message'] = 'Parâmetros inválidos para localizar a paginação.';

        return $response;

      }



      /*
      |--------------------------------------------------------------------------
      | Tabelas
      |--------------------------------------------------------------------------
      */

      $paginationTable = (new SysPagination())->getTable();
      $colsTable       = (new SysPaginationsCol())->getTable();



      /*
      |--------------------------------------------------------------------------
      | Valida coluna de busca
      |--------------------------------------------------------------------------
      */

      if(!Schema::hasColumn($paginationTable, $campo)) {

        $response['message'] = 'Campo informado para busca da paginação não existe.';

        return $response;

      }



      /*
      |--------------------------------------------------------------------------
      | Busca paginação
      |--------------------------------------------------------------------------
      */

      $pagination = SysPagination::where($campo, $valor)->first();


      if($pagination === null) {

        return $response;

      }


      $paginationData = $pagination->toArray();



      /*
      |--------------------------------------------------------------------------
      | Busca argumentos da paginação
      |--------------------------------------------------------------------------
      */

      $argsData = [];


      if(class_exists(SysPaginationsArg::class)) {

        $args = SysPaginationsArg::where('tbl_sys_pagination_ID', $pagination->tbl_sys_pagination_ID)
          ->orderBy('tbl_sys_paginations_arg_ID', 'asc')
          ->get();


        foreach($args as $arg) {

          $argData = $arg->toArray();

          $argName  = $argData['tbl_sys_paginations_arg_name'] ?? null;
          $argValue = $argData['tbl_sys_paginations_arg_value'] ?? null;


          if($argName === null || $argName === '') {

            continue;

          }


          if(is_string($argValue)) {

            $decoded = json_decode($argValue, true);

            if(json_last_error() === JSON_ERROR_NONE) {

              $argValue = $decoded;

            }

          }


          $argsData[$argName] = $argValue;

        }

      }



      /*
      |--------------------------------------------------------------------------
      | Busca colunas da paginação
      |--------------------------------------------------------------------------
      */

      $colsQuery = SysPaginationsCol::where('tbl_sys_pagination_ID', $pagination->tbl_sys_pagination_ID);


      if(Schema::hasColumn($colsTable, 'tbl_sys_paginations_col_ordem')) {

        $colsQuery->orderBy('tbl_sys_paginations_col_ordem', 'asc');

      }


      $cols = $colsQuery
        ->orderBy('tbl_sys_paginations_col_ID', 'asc')
        ->get();



      /*
      |--------------------------------------------------------------------------
      | Aplica regra de acesso por coluna
      |--------------------------------------------------------------------------
      |
      | Regra:
      | - Se a coluna não possuir registros em tbl_sys_paginations_cols_access,
      |   a coluna é pública dentro da paginação e será renderizada normalmente.
      |
      | - Se a coluna possuir registros em tbl_sys_paginations_cols_access,
      |   ela só será renderizada se o usuário logado possuir algum dos tipos
      |   vinculados à coluna.
      |
      */

      $userTypesIDs = self::SysAutomatorGetCurrentUserTypesIDsForAccess();

      $colIDs = $cols->pluck('tbl_sys_paginations_col_ID')->toArray();

      $colsAccess = [];


      if(count($colIDs) >= 1) {

        $colsAccessRows = SysPaginationsColsAccess::whereIn('tbl_sys_paginations_col_ID', $colIDs)->get();

        foreach($colsAccessRows as $colsAccessRow) {

          $accessColID = $colsAccessRow->tbl_sys_paginations_col_ID;

          if(!isset($colsAccess[$accessColID])) {

            $colsAccess[$accessColID] = [];

          }

          $colsAccess[$accessColID][] = $colsAccessRow->tbl_users_type_ID;

        }

      }



      /*
      |--------------------------------------------------------------------------
      | Monta colunas com relação do tipo de campo
      |--------------------------------------------------------------------------
      */

      $columnsData = [];


      foreach($cols as $col) {


        $colID = $col->tbl_sys_paginations_col_ID;


        /*
        |--------------------------------------------------------------------------
        | Verifica acesso à coluna
        |--------------------------------------------------------------------------
        */

        if(isset($colsAccess[$colID]) && count($colsAccess[$colID]) >= 1) {

          $allowedTypes = $colsAccess[$colID];

          $hasColAccess = false;

          foreach($userTypesIDs as $userTypeID) {

            if(in_array($userTypeID, $allowedTypes)) {

              $hasColAccess = true;

              break;

            }

          }


          if($hasColAccess != true) {

            continue;

          }

        }


        $colData = $col->toArray();



        /*
        |--------------------------------------------------------------------------
        | Tipo do campo/coluna
        |--------------------------------------------------------------------------
        */

        $fieldTypeData = null;


        if(isset($col->tbl_sys_field_type_ID) && $col->tbl_sys_field_type_ID != '') {

          $fieldType = SysFieldType::where('tbl_sys_field_type_ID', $col->tbl_sys_field_type_ID)->first();

          if($fieldType !== null) {

            $fieldTypeData = $fieldType->toArray();

          }

        }



        /*
        |--------------------------------------------------------------------------
        | Normaliza JSONs da coluna
        |--------------------------------------------------------------------------
        */

        $colProps  = [];
        $colAttrs  = [];
        $colHeader = [];
        $colBody   = [];
        $colConfig = [];


        if(isset($colData['tbl_sys_paginations_col_props']) && $colData['tbl_sys_paginations_col_props'] != '') {

          $decoded = json_decode($colData['tbl_sys_paginations_col_props'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $colProps = $decoded;

          }

        }


        if(isset($colData['tbl_sys_paginations_col_attrs']) && $colData['tbl_sys_paginations_col_attrs'] != '') {

          $decoded = json_decode($colData['tbl_sys_paginations_col_attrs'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $colAttrs = $decoded;

          }

        }


        if(isset($colData['tbl_sys_paginations_col_header']) && $colData['tbl_sys_paginations_col_header'] != '') {

          $decoded = json_decode($colData['tbl_sys_paginations_col_header'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $colHeader = $decoded;

          }

        }


        if(isset($colData['tbl_sys_paginations_col_body']) && $colData['tbl_sys_paginations_col_body'] != '') {

          $decoded = json_decode($colData['tbl_sys_paginations_col_body'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $colBody = $decoded;

          }

        }


        if(isset($colData['tbl_sys_paginations_col_config']) && $colData['tbl_sys_paginations_col_config'] != '') {

          $decoded = json_decode($colData['tbl_sys_paginations_col_config'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $colConfig = $decoded;

          }

        }



        /*
        |--------------------------------------------------------------------------
        | Normaliza params do tipo de campo
        |--------------------------------------------------------------------------
        */

        $fieldTypeParams = [];


        if(is_array($fieldTypeData) && isset($fieldTypeData['tbl_sys_field_type_params']) && $fieldTypeData['tbl_sys_field_type_params'] != '') {

          $decoded = json_decode($fieldTypeData['tbl_sys_field_type_params'], true);

          if(json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {

            $fieldTypeParams = $decoded;

          }

        }


        if(is_array($fieldTypeData)) {

          $fieldTypeData['params'] = $fieldTypeParams;

        }



        /*
        |--------------------------------------------------------------------------
        | Nome da coluna
        |--------------------------------------------------------------------------
        */

        $columnName = $colData['tbl_sys_paginations_col_name']
          ?? $colData['tbl_sys_paginations_col_field']
          ?? $colData['tbl_sys_paginations_col_column']
          ?? '';



        /*
        |--------------------------------------------------------------------------
        | Adiciona dados tratados
        |--------------------------------------------------------------------------
        */

        $colData['props']       = $colProps;
        $colData['attrs']       = $colAttrs;
        $colData['header']      = $colHeader;
        $colData['body']        = $colBody;
        $colData['config']      = $colConfig;
        $colData['field_type']  = $fieldTypeData;
        $colData['column_name'] = $columnName;


        $columnsData[] = $colData;


      }



      /*
      |--------------------------------------------------------------------------
      | Retorno final
      |--------------------------------------------------------------------------
      */

      $response['status']     = true;
      $response['message']    = 'Paginação encontrada.';
      $response['pagination'] = $paginationData;
      $response['args']       = $argsData;
      $response['columns']    = $columnsData;


      return $response;


    }



    public static function SysAutomatorNormalizePaginationParams($paginationResponse = [], $overrides = []) {


      /*
      |--------------------------------------------------------------------------
      | Retorno padrão no mesmo formato usado manualmente nos controllers
      |--------------------------------------------------------------------------
      */

      $pagination = $paginationResponse['pagination'] ?? [];
      $args       = $paginationResponse['args'] ?? [];
      $columns    = $paginationResponse['columns'] ?? [];


      if(!is_array($pagination)) {

        $pagination = [];

      }


      if(!is_array($args)) {

        $args = [];

      }


      if(!is_array($columns)) {

        $columns = [];

      }


      $table = $pagination['tbl_sys_pagination_table'] ?? ($args['table'] ?? null);

      $index = $args['index']
        ?? ($pagination['tbl_sys_pagination_index'] ?? null)
        ?? (($table != '' && Schema::hasTable($table)) ? self::SysAutomatorGetPKColumn($table) : null);


      $params = [

        'page_name'         => $args['page_name'] ?? ($pagination['tbl_sys_pagination_title'] ?? ($pagination['tbl_sys_pagination_name'] ?? null)),
        'table'             => $table,
        'index'             => $index,
        'per_page'          => $args['per_page'] ?? ($pagination['tbl_sys_pagination_per_page'] ?? 15),
        'actions'           => $args['actions'] ?? [],
        'header_actions'    => $args['header_actions'] ?? [],
        'list_actions'      => $args['list_actions'] ?? [],
        'search_fields'     => $args['search_fields'] ?? [],
        'modals'            => $args['modals'] ?? [],
        'modal'             => $args['modal'] ?? null,
        'action_urls'       => $args['action_urls'] ?? [],
        'default_sort'      => $args['default_sort'] ?? ($args['order_by'] ?? null),
        'default_direction' => $args['default_direction'] ?? ($args['order_direction'] ?? ($args['direction'] ?? 'asc')),
        'where'             => $args['where'] ?? null,
        'with_where'        => $args['with_where'] ?? null,
        'columns'           => [],

      ];


      /*
      |--------------------------------------------------------------------------
      | Controle de nomes repetidos
      |--------------------------------------------------------------------------
      */

      $columnCounters = [];


      foreach($columns as $column) {


        if(!is_array($column)) {

          continue;

        }


        /*
        |--------------------------------------------------------------------------
        | Nome original da coluna
        |--------------------------------------------------------------------------
        */

        $originalColumnName = $column['column_name']
          ?? $column['tbl_sys_paginations_col_name']
          ?? $column['tbl_sys_paginations_col_field']
          ?? $column['tbl_sys_paginations_col_column']
          ?? null;


        if($originalColumnName === null || $originalColumnName === '') {

          continue;

        }


        /*
        |--------------------------------------------------------------------------
        | Gera chave única quando repetir
        |--------------------------------------------------------------------------
        |
        | name
        | name_2
        | name_3
        |
        */

        if(!isset($columnCounters[$originalColumnName])) {

          $columnCounters[$originalColumnName] = 1;

          $columnKey = $originalColumnName;

        } else {

          $columnCounters[$originalColumnName]++;

          $columnKey = $originalColumnName . '_' . $columnCounters[$originalColumnName];

        }


        $props  = (isset($column['props']) && is_array($column['props'])) ? $column['props'] : [];
        $attrs  = (isset($column['attrs']) && is_array($column['attrs'])) ? $column['attrs'] : [];
        $header = (isset($column['header']) && is_array($column['header'])) ? $column['header'] : [];
        $body   = (isset($column['body']) && is_array($column['body'])) ? $column['body'] : [];
        $config = (isset($column['config']) && is_array($column['config'])) ? $column['config'] : [];


        if(isset($header['classes']) && !isset($header['class'])) {

          $header['class'] = $header['classes'];

        }


        if(isset($header['class']) && !isset($header['classes'])) {

          $header['classes'] = $header['class'];

        }


        if(isset($body['classes']) && !isset($body['class'])) {

          $body['class'] = $body['classes'];

        }


        if(isset($body['class']) && !isset($body['classes'])) {

          $body['classes'] = $body['class'];

        }


        $sortable = $column['tbl_sys_paginations_col_sort']
          ?? $column['tbl_sys_paginations_col_sortable']
          ?? ($config['sortable'] ?? ($props['sortable'] ?? false));

        $searchable = $column['tbl_sys_paginations_col_search']
          ?? $column['tbl_sys_paginations_col_searchable']
          ?? ($config['searchable'] ?? ($props['searchable'] ?? false));


        $fieldType = $column['field_type'] ?? [];

        $type = $config['type']
          ?? $props['type']
          ?? ($fieldType['tbl_sys_field_type_name'] ?? 'text');


        $label = $column['tbl_sys_paginations_col_title']
          ?? $column['tbl_sys_paginations_col_label']
          ?? ($config['label'] ?? ($props['label'] ?? $originalColumnName));


        $params['columns'][$columnKey] = array_merge($column, [

          'type'        => $type,
          'label'       => $label,
          'sortable'    => self::SysAutomatorValueIsTruthy($sortable),
          'searchable'  => self::SysAutomatorValueIsTruthy($searchable),
          'header'      => $header,
          'body'        => $body,
          'props'       => $props,
          'attrs'       => $attrs,
          'config'      => $config,
          'field_type'  => $fieldType,

          /*
          |--------------------------------------------------------------------------
          | Mantém nome original da coluna
          |--------------------------------------------------------------------------
          */

          'column_name' => $originalColumnName,

          'replaced' => $column['replaced']
            ?? ($config['replaced']
            ?? ($props['replaced'] ?? [])),

        ]);


        if(
          self::SysAutomatorValueIsTruthy($searchable) &&
          !isset($params['search_fields'][$columnKey])
        ) {

          $params['search_fields'][$columnKey] = $label;

        }


      }


      foreach($args as $argKey => $argValue) {

        if(!array_key_exists($argKey, $params)) {

          $params[$argKey] = $argValue;

        }

      }


      if(is_array($overrides) && count($overrides) >= 1) {

        $params = array_replace_recursive($params, $overrides);

      }


      return $params;


    }



    public static function SysAutomatorGetPaginationParamsBy($campo = 'tbl_sys_pagination_name', $valor = null, $overrides = []) {


      $response = self::SysAutomatorGetPaginationDataBy($campo, $valor);


      if(!isset($response['status']) || $response['status'] !== true) {

        return $response;

      }


      $response['params'] = self::SysAutomatorNormalizePaginationParams($response, $overrides);


      return $response;


    }



    public static function SysAutomatorValueIsTruthy($value) {


      return ($value === true || $value === 1 || $value === '1' || $value === 'true' || $value === 'yes' || $value === 'sim');


    }



    public static function SysAutomatorRenderPaginationByName($paginationName, $requestArgs = [], $overrides = []) {


      $response = self::SysAutomatorGetPaginationParamsBy('tbl_sys_pagination_name', $paginationName, $overrides);
      // dd($response);

      if(!isset($response['status']) || $response['status'] !== true) {

        return $response;

      }


      return self::SysAutomatorRenderPaginationByParams($response['params'], $requestArgs, $response);


    }



    public static function SysAutomatorRenderPaginationByID($paginationID, $requestArgs = [], $overrides = []) {


      $response = self::SysAutomatorGetPaginationParamsBy('tbl_sys_pagination_ID', $paginationID, $overrides);


      if(!isset($response['status']) || $response['status'] !== true) {

        return $response;

      }


      return self::SysAutomatorRenderPaginationByParams($response['params'], $requestArgs, $response);


    }



    public static function SysAutomatorRenderPaginationByParams($params = [], $requestArgs = [], $response = []) {


      if(!is_array($params)) {

        $params = [];

      }


      if(!is_array($requestArgs)) {

        $requestArgs = request()->all();

      }


      $table = $params['table'] ?? '';

      if($table == '' || !Schema::hasTable($table)) {

        $response['status']  = false;
        $response['message'] = 'Tabela da paginação não encontrada.';
        $response['items']   = [];
        $response['html']    = '';

        return $response;

      }


      $paginationRequest = Request::create(request()->fullUrl(), request()->method(), $requestArgs);

      $paginationData = self::SysAutomatorPaginationData($params, $paginationRequest);

      $response = array_merge($response, $paginationData);


      if(View::exists('system.pages.pagination')) {

        $response['html'] = view('system.pages.pagination', $paginationData)->render();

      } else {

        $response['html'] = self::SysAutomatorRenderPaginationHTML($paginationData, $requestArgs);

      }


      $response['status'] = true;



      return $response;


    }



    public static function SysAutomatorRenderPaginationHTML($data = [], $requestArgs = []) {


      $items        = $data['items'] ?? null;
      $columns      = $data['columns'] ?? [];
      $index        = $data['index'] ?? null;
      $listActions  = $data['list_actions'] ?? [];
      $headerActions = $data['header_actions'] ?? [];
      $searchFields = $data['search_fields'] ?? [];
      $sort         = $data['sort'] ?? null;
      $direction    = $data['direction'] ?? 'asc';


      $html = '';

      $html .= '<div class="automator-pagination">';


        if(count($headerActions) >= 1 || count($searchFields) >= 1) {

          $html .= '<div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">';

            if(count($headerActions) >= 1) {

              $html .= '<div class="d-flex flex-wrap gap-2">';

                foreach($headerActions as $action) {

                  $html .= self::SysAutomatorRenderPaginationAction($action, null, $index);

                }

              $html .= '</div>';

            } else {

              $html .= '<div></div>';

            }


            if(count($searchFields) >= 1) {

              $html .= '<form method="GET" class="d-flex gap-2 align-items-center">';
                $html .= '<input type="text" name="search" value="' . e($requestArgs['search'] ?? '') . '" class="form-control" placeholder="Pesquisar">';
                $html .= '<button type="submit" class="btn btn-primary">Buscar</button>';
              $html .= '</form>';

            }

          $html .= '</div>';

        }


        $html .= '<div class="card shadow-sm overflow-hidden">';
          $html .= '<div class="table-responsive">';
            $html .= '<table class="table table-hover align-middle mb-0">';
              $html .= '<thead class="table-light">';
                $html .= '<tr>';

                  foreach($columns as $columnName => $column) {

                    $html .= self::SysAutomatorRenderPaginationHeaderColumn($columnName, $column, $sort, $direction, $requestArgs);

                  }

                  if(count($listActions) >= 1) {

                    $html .= '<th scope="col" class="text-end">Ações</th>';

                  }

                $html .= '</tr>';
              $html .= '</thead>';
              $html .= '<tbody>';

                if($items !== null && $items->count() >= 1) {

                  foreach($items as $item) {

                    $html .= '<tr>';

                      foreach($columns as $columnName => $column) {

                        $html .= self::SysAutomatorRenderPaginationBodyColumn($columnName, $column, $item, $data, $requestArgs);

                      }

                      if(count($listActions) >= 1) {

                        $html .= '<td class="text-end">';
                          $html .= '<div class="btn-group btn-group-sm" role="group">';

                            foreach($listActions as $action) {

                              $html .= self::SysAutomatorRenderPaginationAction($action, $item, $index);

                            }

                          $html .= '</div>';
                        $html .= '</td>';

                      }

                    $html .= '</tr>';

                  }

                } else {

                  $colspan = count($columns) + ((count($listActions) >= 1) ? 1 : 0);
                  $html .= '<tr><td colspan="' . $colspan . '" class="text-center text-muted py-4">Nenhum registro encontrado.</td></tr>';

                }

              $html .= '</tbody>';
            $html .= '</table>';
          $html .= '</div>';

          if($items !== null && $items->hasPages()) {

            $html .= '<div class="card-footer bg-light">';
              $html .= $items->links()->render();
            $html .= '</div>';

          }

        $html .= '</div>';

      $html .= '</div>';


      return $html;


    }



    public static function SysAutomatorRenderPaginationHeaderColumn($columnName, $column = [], $sort = null, $direction = 'asc', $requestArgs = []) {


      $label = $column['label'] ?? ($column['tbl_sys_paginations_col_title'] ?? $columnName);

      $class = $column['header']['class'] ?? ($column['header']['classes'] ?? '');

      $sortable = $column['sortable'] ?? false;


      if(!self::SysAutomatorValueIsTruthy($sortable)) {

        return '<th scope="col" class="' . e($class) . '">' . e($label) . '</th>';

      }


      $nextDirection = (($sort == $columnName && strtolower($direction) == 'asc') ? 'desc' : 'asc');

      $query = array_merge($requestArgs, [

        'sort'      => $columnName,
        'direction' => $nextDirection,

      ]);

      $url = request()->url() . '?' . http_build_query($query);


      return '<th scope="col" class="' . e($class) . '"><a href="' . e($url) . '" class="text-decoration-none text-reset">' . e($label) . '</a></th>';


    }



    public static function SysAutomatorRenderPaginationBodyColumn($columnName, $column = [], $item = null, $data = [], $requestArgs = []) {


      if(isset($column['field_type']) && is_array($column['field_type']) && count($column['field_type']) >= 1) {

        $html = AutomatorFields::renderPaginationColumn('tbody', [

          'pagination' => $data['pagination'] ?? [],
          'args'       => $data,
          'column'     => $column,
          'columns'    => $data['columns'] ?? [],
          'item'       => $item,
          'request'    => $requestArgs,

        ]);


        if($html != '') {

          return $html;

        }

      }


      $class = $column['body']['class'] ?? ($column['body']['classes'] ?? '');

      $value = AutomatorFields::getColumnValue($item, $columnName);


      if(isset($column['replaced']) && is_array($column['replaced']) && array_key_exists($value, $column['replaced'])) {

        $value = $column['replaced'][$value];

        return '<td class="' . e($class) . '">' . $value . '</td>';

      }


      return '<td class="' . e($class) . '">' . e($value) . '</td>';


    }



    public static function SysAutomatorRenderPaginationAction($action = [], $item = null, $index = null) {


      if(!is_array($action)) {

        return '';

      }


      if(isset($action['show']) && !self::SysAutomatorValueIsTruthy($action['show'])) {

        return '';

      }


      $type = $action['type'] ?? 'button';
      $id   = $action['id'] ?? '';
      $class = $action['class'] ?? 'btn btn-primary';
      $icon = $action['icon'] ?? '';
      $text = $action['text'] ?? '';
      $onclick = $action['onclick'] ?? '';


      $itemID = '';

      if($item !== null && $index !== null && $index !== '') {

        $itemID = AutomatorFields::getColumnValue($item, $index);

      }


      if($itemID !== '') {

        $onclick = str_replace(['{id}', '#ID#'], $itemID, $onclick);
        $id      = str_replace(['{id}', '#ID#'], $itemID, $id);

      }


      $content = '';

      if($icon != '') {

        $content .= '<i class="fa fa-' . e($icon) . '"></i>';

      }


      if($text != '') {

        $content .= (($content != '') ? ' ' : '') . e($text);

      }


      if($content == '') {

        $content = e($action['action'] ?? 'Ação');

      }


      if($type == 'link' || $type == 'a') {

        $href = $action['href'] ?? '#';

        if($itemID !== '') {

          $href = str_replace(['{id}', '#ID#'], $itemID, $href);

        }

        return '<a href="' . e($href) . '"' . (($id != '') ? ' id="' . e($id) . '"' : '') . ' class="' . e($class) . '"' . (($onclick != '') ? ' onclick="' . e($onclick) . '"' : '') . '>' . $content . '</a>';

      }


      return '<button type="button"' . (($id != '') ? ' id="' . e($id) . '"' : '') . ' class="' . e($class) . '"' . (($onclick != '') ? ' onclick="' . e($onclick) . '"' : '') . '>' . $content . '</button>';


    }


    public static function SysAutomatorPreperRelationFieldOptionsData($args = []) {


      $retorno = [];
      $table = ( (isset($args['table'])) ? ( ($args['table'] != '') ? $args['table'] : null ) : null );

      if(!Schema::hasTable($table)) {

        return [];
      
      } else {

        $query = DB::table($table);

        $select = [

          $args['value'],
          $args['label']

        ];

        if (isset($args['where'])) {

          $where = $args['where'];
          if (is_callable($where)) {

            $query = $where($query);

          } elseif (is_array($where)) {

            foreach ($where as $condition) {

              if (is_array($condition) && count($condition) >= 2) {

                if (count($condition) === 2) {

                  // Simple condition: ['field', 'value']
                  $query->where($condition[0], $condition[1]);

                } elseif (count($condition) === 3) {

                  // Operator condition: ['field', 'operator', 'value']
                  $query->where($condition[0], $condition[1], $condition[2]);
                
                }

                if(!in_array($condition[0], $select)) {
                  $select[] = $condition[0];
                }

              }

            }

          } elseif (is_string($where)) {

            try {

              $whereArray = json_decode($where, true);
              if (is_array($whereArray)) {

                foreach ($whereArray as $condition) {

                  if (is_array($condition) && count($condition) >= 2) {

                    if (count($condition) === 2) {

                      $query->where($condition[0], $condition[1]);

                    } elseif (count($condition) === 3) {

                      $query->where($condition[0], $condition[1], $condition[2]);

                    }

                    if(!in_array($condition[0], $select)) {
                      $select[] = $condition[0];
                    }

                  }

                }
              }

            } catch (\Exception $e) {
              
            }

          }
          // $where = ( (isset($args['where'])) ? ( ( count($args['where']) >= 1) ? $args['where'] : [] ) : [] );
          // if(count($where) >= 1) {

          //   if(foreach ($where as $whereKey => $whereValue) {
              
          //     if(!$in_array($whereKey, $select)) {

          //       $select[] = $whereKey;

          //     }

          //   }

          // }

        }


        $filters = ( (isset($args['filters'])) ? ( ( count($args['filters']) >= 1) ? $args['filters'] : [] ) : [] );
        if(count($filters) >= 1) {

          foreach ($filters as $filterKey => $filterValue) {
            
            if(!in_array($filterKey, $select)) {

              $select[] = $filterKey;

            }

          }

        }



        $sort = ( (isset($args['default_sort'])) ? $args['default_sort'] : $args['value'] );
        $direction = ( (!isset($args['default_direction'])) ? 'asc' : $args['default_direction']);
        if ($sort) {
          
          $query->orderBy($sort, $direction);

        }



        return $query->select($select)->get();

      }

      return [];
      // var_dump($args);

    }



    public static function SysAutomatorGetUserNotificationsUnopedNumber($userID = null) {

      $retorno = 0;

      if($userID == null) {

        return $retorno;

      }


      $retorno = SysNotification::where('tbl_user_ID', $userID)->where('tbl_sys_notification_opened', false)->count();

      return $retorno;

    }



    public static function SysAutomatorGetUserNotificationsListHTML($userID = null) {

      $retorno = '<div class="text-center p-3">' . self::SysAutomatorGetTranslateWord('Nenhuma notificação encontrada!') . '</div>';

      if($userID == null) {

        return $retorno;

      }


      $notificacoes = SysNotification::where('tbl_user_ID', $userID)->limit(5)->get();
      if(count($notificacoes) >= 1) {

        $notificacoes = $notificacoes->toArray();

        $retorno = '<ul class="list-group rounded-0">' . "\n";
        foreach ($notificacoes as $notificacao) {
          
          $retorno .= '<li class="list-group-item rounded-0' . ( ($notificacao['tbl_sys_notification_opened'] == false) ? ' list-group-item-secondary' : '' ) . '">' . "\n";
            
            $retorno .= '<div class="d-flex w-100 justify-content-between">' . "\n";

              $retorno .= '<h5 class="fs-6 fw-bold">' . $notificacao['tbl_sys_notification_title'] . '</h5>' . "\n";
              $retorno .= '<small>' . Carbon::parse($notificacao['tbl_sys_notification_created_at'])->format('d/m/Y') . '</small>' . "\n";

            $retorno .= '</div>' . "\n";
            $retorno .= '<div class="d-flex w-100 justify-content-between">' . "\n";
              
              $retorno .= '<small>' . ( (strlen(strip_tags($notificacao['tbl_sys_notification_text'])) >= 20) ? ( mb_substr(strip_tags($notificacao['tbl_sys_notification_text']), 0, 20) ) . '...' : strip_tags($notificacao['tbl_sys_notification_text']) ) . '</small>' . "\n";
              $retorno .= '<i class="fa fa-eye"></i>' . "\n";
            
            $retorno .= '</div>' . "\n";

          $retorno .= '</li>' . "\n";

        }

        $retorno .= '</ul>' . "\n";

      }


      return $retorno;


    }



    public static function SysAutomatorGetCurrentUserTypesIDsForAccess() {


      $userTypesIDs = [];


      if(!Auth::check()) {

        return $userTypesIDs;

      }


      $user = Auth::user();


      if($user == null) {

        return $userTypesIDs;

      }


      if(method_exists($user, 'UserGetTypes')) {

        $userTypesIDs = $user->UserGetTypes()
          ->where('tbl_users_types.tbl_users_type_status', 'ativo')
          ->pluck('tbl_users_types.tbl_users_type_ID')
          ->toArray();

      } elseif(method_exists($user, 'UserGetTypesIDs')) {

        $userTypesIDs = $user->UserGetTypesIDs();

      }


      if(!is_array($userTypesIDs)) {

        $userTypesIDs = [];

      }


      return $userTypesIDs;


    }


    public static function SysAutomatorRenderFormRequestByID($formID, $request) {

      
      $retorno = [

        'status'  => false,
        'message' => 'Solicitação inválida!'

      ];

      

      return $retorno;


    }




    /**
     * Retorna os itens de um menu pelo ID do menu, com sub-itens e permissões de acesso,
     * sem montar nenhuma estrutura HTML.
     *
     * Análogo a SysAutomatorGetNavMenuItens(), porém recebe diretamente o tbl_sys_menu_ID
     * em vez do nome do nav, e retorna apenas arrays puros.
     *
     * @param  int|string  $menuID   ID do menu (tbl_sys_menu_ID)
     * @param  array       $args     Mesmos args aceitos por SysAutomatorGetNavMenuItens()
     * @return array  [
     *   'menu'  => array,   // dados do SysMenu
     *   'items' => array,   // itens em árvore (children / sub_itens) com permissões filtradas
     * ]
     */
    public static function SysAutomatorGetMenuItemsByMenuID($menuID, $args = []) {


      $retorno = [

        'menu'  => [],
        'items' => [],

      ];


      if (!$menuID || $menuID == '') {

        return $retorno;

      }


      if (!is_array($args)) {

        $args = [];

      }


      $SysMenu = SysMenu::where('tbl_sys_menu_ID', $menuID)->first();

      if ($SysMenu === null) {

        return $retorno;

      }


      $retorno['menu'] = $SysMenu->toArray();


      /*
      |--------------------------------------------------------------------------
      | Verifica se o menu pertence a um nav admin
      |--------------------------------------------------------------------------
      */

      $isAdminNav  = false;
      $user        = null;
      $userTypesIDs = [];


      if ($SysMenu->tbl_sys_nav_ID) {

        $SysNav = SysNav::where('tbl_sys_nav_ID', $SysMenu->tbl_sys_nav_ID)->first();

        if ($SysNav !== null) {

          $isAdminNav = ($SysNav->tbl_sys_nav_admin == true);

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Usuário logado + tipos
      |--------------------------------------------------------------------------
      */

      if ($isAdminNav == true) {

        if (!Auth::check()) {

          return $retorno;

        }

        $user = Auth::user();

        if ($user !== null && method_exists($user, 'UserGetTypesIDs')) {

          $userTypesIDs = $user->UserGetTypesIDs();

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Busca itens do menu
      |--------------------------------------------------------------------------
      */

      $itens = SysMenusItem::where('tbl_sys_menu_ID', $SysMenu->tbl_sys_menu_ID)
        ->where('tbl_sys_menu_item_status', 'ativo')
        ->orderBy('tbl_sys_menu_item_ordem', 'asc')
        ->get();


      if ($itens->count() <= 0) {

        return $retorno;

      }


      $itensPermitidos = [];


      foreach ($itens as $item) {


        /*
        |--------------------------------------------------------------------------
        | Controle de acesso admin
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | URL do item
        |--------------------------------------------------------------------------
        */

        $itemArray['tbl_sys_menu_item_url'] = self::SysAutomatorGetMenuItemURL($itemArray, $args);


        /*
        |--------------------------------------------------------------------------
        | Estrutura padrão
        |--------------------------------------------------------------------------
        */

        $itemArray['children']  = [];
        $itemArray['sub_itens'] = [];


        /*
        |--------------------------------------------------------------------------
        | Access
        |--------------------------------------------------------------------------
        |
        | Mantém compatibilidade com código atual
        |
        */

        $itemArray['access'] = SysMenusItemsAccess::where('tbl_sys_menu_item_ID', $item->tbl_sys_menu_item_ID)
          ->get()
          ->toArray();


        /*
        |--------------------------------------------------------------------------
        | tbl_sys_menu_item_can_delete
        |--------------------------------------------------------------------------
        |
        | Retorna TODOS os tipos de usuário vinculados
        | à tabela SysMenusItemAccess
        |
        | Resultado:
        |
        | [1,2,4]
        |
        */

        $itemArray['tbl_sys_menu_item_can_delete'] = SysMenusItemAccess::where(
          'tbl_sys_menu_item_ID',
          $item->tbl_sys_menu_item_ID
        )
        ->pluck('tbl_users_type_ID')
        ->filter(function($value) {

          return $value !== null && $value !== '';

        })
        ->unique()
        ->values()
        ->map(function($value) {

          return (int) $value;

        })->toArray();


        $itensPermitidos[] = $itemArray;


      }


      $retorno['items'] = self::SysAutomatorBuildNavMenuItensTree($itensPermitidos);

      return $retorno;


    }



    /**
     * Versão simplificada: retorna apenas o array de itens em árvore pelo ID do menu,
     * já com sub-itens, children e permissões de acesso, sem nenhum HTML.
     *
     * @param  int|string  $menuID   ID do menu (tbl_sys_menu_ID)
     * @param  array       $args     Mesmos args aceitos por SysAutomatorGetMenuItemsByMenuID()
     * @return array  Array de itens em árvore (com 'children', 'sub_itens' e 'access')
     */
    public static function SysAutomatorGetMenuItemsArrayByMenuID($menuID, $args = []) {


      $data = self::SysAutomatorGetMenuItemsByMenuID($menuID, $args);

      return $data['items'] ?? [];


    }



    public static function SysAutomatorFormatMenuItemUserTypesAccessValues($data) {

      $retorno = [];

      if(is_array($data)) {

        if(count($data) >= 1) {

          foreach ($data as $item) {
            
            if(!in_array($item['tbl_users_type_ID'], $retorno)) {

              $retorno[] = $item['tbl_users_type_ID'];

            }

          }

        }

      }

      return $retorno;


    }



    public static function SysAutomatorCountMenuItemUserTypesAccessValues($usersTypes,$data) {

      $retorno = 0;

      if (count($data) >= 1) {
        
        foreach ($usersTypes as $_userTypeID => $_userTypeName) {
        

          if (in_array($_userTypeID, array_values($data))) {
            
            $retorno++;

          }

        }

      }

      return $retorno;


    }



    public static function SysAutomatorGetRelationValues($props, $column_value = '') {

      $retorno = $column_value;

      if(Schema::hasTable($props['table'])) {

        if(Schema::hasColumn($props['table'], $props['column'])) {

          if($props['mode'] == 'revert') {

            if($props['type'] == 'single') {

              $query = DB::table($props['table'])->where($props['column'], $column_value)->first();
              if($query) {

                $query = ( (array) $query);
                // $query = $query->toArray();
                $retorno = ( (isset($query[$props['display']])) ? $query[$props['display']] : $column_value );

              } else {

                if($props['empty']) {

                  $retorno = $props['empty'];

                }

              }

            }

          }

        }

      }
      
      return $retorno;

    }



    public static function SysAutomatorRenderPageBuilderFields() {
      

      // IDs dos grupos utilizados pelos campos do layout
      $groupIds = SysFieldType::where('tbl_sys_field_type_layout', true)
          ->pluck('tbl_sys_field_type_group_ID')
          ->unique()
          ->toArray();

      // Buscar todos os campos do editor agrupados pelo group_ID
      $fieldsByGroup = SysFieldType::where('tbl_sys_field_type_layout', true)
          ->get()
          ->groupBy('tbl_sys_field_type_group_ID');

      // Buscar grupos ordenados
      $groups = SysFieldTypesGroup::whereIn(
              'tbl_sys_field_type_group_ID',
              $groupIds
          )
          ->orderBy('tbl_sys_field_type_group_ordem', 'ASC')
          ->get([
              'tbl_sys_field_type_group_ID',
              'tbl_sys_field_type_group_name',
              'tbl_sys_field_type_group_title'
          ])
          ->map(function ($group) use ($fieldsByGroup) {

              return [
                  'tbl_sys_field_type_group_name'  => $group->tbl_sys_field_type_group_name,
                  'tbl_sys_field_type_group_title' => $group->tbl_sys_field_type_group_title,

                  'tbl_sys_field_type_group_fields' =>
                      isset($fieldsByGroup[$group->tbl_sys_field_type_group_ID])
                          ? $fieldsByGroup[$group->tbl_sys_field_type_group_ID]
                              ->values()
                              ->toArray()
                          : []
              ];
          })
          ->values()
          ->toArray();

      return $groups;

    }



    public static function SysAutomatorRenderPageBuilderField($field, $data = [], $layout = true) {


      $fieldID = $field;


      if(is_array($field)) {

        $fieldID = $field['tbl_sys_field_type_ID'] ?? null;


        if(!is_array($data) || count($data) <= 0) {

          $data = $field;

        }

      }


      if(
        $fieldID === null ||
        $fieldID === ''
      ) {

        return '';

      }


      $rendered = AutomatorFields::renderViewEditorField(

        $fieldID,

        $data,

        $layout

      );


      return $rendered;


    }




    public static function SysAutomatorNormalizeRelationFieldProps($props = []) {

      if(!is_array($props)) {
        $props = [];
      }

      $fieldType = strtolower((string) ($props['type'] ?? ''));

      if(isset($props['params']) && is_array($props['params'])) {

        $fieldType = strtolower((string) (
          $props['type']
          ?? $props['params']['configs.type']
          ?? $props['params']['advanced.type']
          ?? $props['params']['type']
          ?? $fieldType
        ));

      }

      if($fieldType == '') {
        $fieldType = 'select';
      }

      if(!in_array($fieldType, ['select', 'checkbox', 'radio', 'hidden'])) {
        $fieldType = 'select';
      }

      $props['type'] = $fieldType;

      if(!isset($props['relation']) || !is_array($props['relation'])) {
        $props['relation'] = [];
      }

      $relation = $props['relation'];

      $relation['table'] = trim((string) (
        $relation['table']
        ?? $relation['tabela-destino']
        ?? ''
      ));

      $relation['value'] = trim((string) (
        $relation['value']
        ?? $relation['column']
        ?? $relation['campo-destino']
        ?? ''
      ));

      $relation['label'] = trim((string) (
        $relation['label']
        ?? $relation['display']
        ?? $relation['label-destino']
        ?? ''
      ));

      unset(
        $relation['column'],
        $relation['display'],
        $relation['key'],
        $relation['label_table'],
        $relation['label_value'],
        $relation['label_display'],
        $relation['tabela-destino'],
        $relation['campo-destino'],
        $relation['label-destino']
      );

      $props['relation'] = $relation;

      return $props;

    }


    public static function SysAutomatorNavHasMenu($navID = '') {
      

      $retorno = false;

      $query = SysMenu::where('tbl_sys_nav_ID', $navID)->get();
      if($query) {

        $nav = $query->toArray();
        if(count($nav) >= 1) {

          $retorno = true;
          
        }

      }

      return $retorno;


    }


    public static function SysAutomatorGetFormFieldsRules($formID): array {


      $rules = [];


      if($formID === null || $formID === '') {

        return $rules;

      }


      if(!Schema::hasTable('tbl_sys_forms_fields')) {

        return $rules;

      }


      $formFields = DB::table('tbl_sys_forms_fields')
                      ->where('tbl_sys_form_ID', $formID)
                      ->get();


      foreach($formFields as $formField) {

        $formField = (array) $formField;

        $fieldName = $formField['tbl_sys_forms_field_name'] ?? null;


        if($fieldName === null || $fieldName === '') {

          continue;

        }


        $props = [];

        if(isset($formField['tbl_sys_forms_field_props']) && $formField['tbl_sys_forms_field_props'] !== '') {

          $decodedProps = json_decode($formField['tbl_sys_forms_field_props'], true);

          if(is_array($decodedProps)) {

            $props = $decodedProps;

          }

        }


        $rules[$fieldName] = [

          'title'    => $formField['tbl_sys_forms_field_title'] ?? $fieldName,
          'required' => (bool) ($formField['tbl_sys_forms_field_required'] ?? false),
          'props'    => $props

        ];

      }


      return $rules;


    }




  }
