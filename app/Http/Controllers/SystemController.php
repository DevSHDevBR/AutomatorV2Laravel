<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Schema;

  use App\Http\Controllers\AutomatorController;
  use App\Helpers\SysAutomator;
  use App\Models\SysPagination;
  use App\Models\SysFunction;
  use App\Models\SysRoute;
  use App\Models\SysForm;
  use App\Models\SysConfig;
  use App\Models\SysFormsAccess;
  use App\Models\User;
  use App\Models\UsersType;



  class SystemController extends Controller {



    public function pageNotFound(Request $request) {

      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);


      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();
      if($route == null) {

        $route = [

          'tbl_sys_route_title' => 'Erro 404',
          'tbl_sys_route_name'  => 'error-404',
          'tbl_sys_route_area'  => 'public'
        
        ];

      } else {

        $route = $route->toArray();

      }


      $conteudo = view('pages.404', [

        'pageName' => $route['tbl_sys_route_title']

      ])->render();

      if($route['tbl_sys_route_area'] == 'restrict') {

        return view('layouts.painel-restrict', [

          'content' => $conteudo,
          'title'   => $route['tbl_sys_route_title'],
          'page'    => $route['tbl_sys_route_name']
          
        ]);

      } else {

        return view('layouts.painel-public', [

          'content' => $conteudo,
          'title'   => $route['tbl_sys_route_title'],
          'page'    => $route['tbl_sys_route_name']

        ]);

      }



    }



    public function login(Request $request) {

      
      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);


      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first()->toArray();

      if(Auth::check()) {

        return redirect()->route('page.admin-dashboard');

      } else {

        return response()
          ->view('layouts.painel-public', [

            'contentView' => 'system.login',
            'contentData' => [],
            'title'       => $route['tbl_sys_route_title'],
            'page'        => $route['tbl_sys_route_name']
            
          ])
          ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
          ->header('Pragma', 'no-cache')
          ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
      }


    }


    /*
    |--------------------------------------------------------------------------
    | Normaliza URL de retorno após autenticação
    |--------------------------------------------------------------------------
    |
    | Aceita somente URLs pertencentes ao próprio sistema.
    |
    | Isso impede que o parâmetro redirect_url seja utilizado para redirecionar
    | o usuário para um domínio externo.
    |
    */

    private function normalizeAutomatorRedirectURL(
      Request $request,
      $redirectURL = null
    ) {


      if(
        $redirectURL === null ||
        !is_scalar($redirectURL)
      ) {

        return null;

      }


      $redirectURL = trim(

        (string) $redirectURL

      );


      if($redirectURL === '') {

        return null;

      }


      /*
      |--------------------------------------------------------------------------
      | Decodifica somente uma vez
      |--------------------------------------------------------------------------
      */

      $decodedURL = rawurldecode(

        $redirectURL

      );


      if($decodedURL !== '') {

        $redirectURL = $decodedURL;

      }


      /*
      |--------------------------------------------------------------------------
      | URLs relativas
      |--------------------------------------------------------------------------
      */

      if(str_starts_with($redirectURL, '/')) {


        if(str_starts_with($redirectURL, '//')) {

          return null;

        }


        $normalizedURL = url(

          $redirectURL

        );


      } else {


        /*
        |--------------------------------------------------------------------------
        | URLs absolutas
        |--------------------------------------------------------------------------
        */

        $parsedURL = parse_url(

          $redirectURL

        );


        if(!is_array($parsedURL)) {

          return null;

        }


        $redirectHost = strtolower(

          trim(

            (string) (

              $parsedURL['host']

              ?? ''

            )

          )

        );


        $currentHost = strtolower(

          trim(

            (string) $request->getHost()

          )

        );


        if(
          $redirectHost === '' ||
          $redirectHost !== $currentHost
        ) {

          return null;

        }


        $redirectScheme = strtolower(

          trim(

            (string) (

              $parsedURL['scheme']

              ?? ''

            )

          )

        );


        if(
          $redirectScheme !== '' &&
          !in_array(

            $redirectScheme,

            [

              'http',
              'https',

            ],

            true

          )
        ) {

          return null;

        }


        $normalizedURL = $redirectURL;


      }


      /*
      |--------------------------------------------------------------------------
      | Impede retorno para rotas de login e logout
      |--------------------------------------------------------------------------
      */

      $loginURL = SysAutomator::SysAutomatorGetRouteLinkByName(

        'admin-login',

        [],

        true

      );


      $logoutURL = SysAutomator::SysAutomatorGetRouteLinkByName(

        'admin-logout',

        [],

        true

      );


      $normalizedPath = parse_url(

        $normalizedURL,

        PHP_URL_PATH

      );


      $loginPath = parse_url(

        $loginURL,

        PHP_URL_PATH

      );


      $logoutPath = parse_url(

        $logoutURL,

        PHP_URL_PATH

      );


      if(
        $normalizedPath !== null &&
        (
          (
            $loginPath !== null &&
            $normalizedPath === $loginPath
          ) ||
          (
            $logoutPath !== null &&
            $normalizedPath === $logoutPath
          )
        )
      ) {

        return null;

      }


      return $normalizedURL;


    }


    public function loginAPI(Request $request) {


      $request->validate([

        'login'        => ['required', 'string'],
        'password'     => ['required', 'string'],
        'redirect_url' => ['nullable', 'string'],

      ], [

        'login.required'    => SysAutomator::SysAutomatorGetTranslateWord('Informe seu login.'),
        'password.required' => SysAutomator::SysAutomatorGetTranslateWord('Informe sua senha.'),

      ]);


      $login = $request->input(

        'login'

      );


      $password = $request->input(

        'password'

      );


      $user = User::where(

        'tbl_user_login',

        $login

      )
        ->orWhere(

          'tbl_user_email',

          $login

        )
        ->first();


      if(!$user) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

        ], 401);

      }


      if(!Hash::check($password, $user->tbl_user_password)) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

        ], 401);

      }


      if($user->tbl_user_status != 'ativo') {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário não está ativo.'),

        ], 403);

      }


      if((bool) $user->tbl_user_blocked === true) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário está bloqueado.'),

        ], 403);

      }


      if((bool) $user->tbl_user_actived !== true) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário ainda não foi ativado.'),

        ], 403);

      }


      /*
      |--------------------------------------------------------------------------
      | Autentica o usuário
      |--------------------------------------------------------------------------
      */

      Auth::guard('web')->login(

        $user,

        $request->boolean('remember')

      );


      $request->session()->regenerate();


      /*
      |--------------------------------------------------------------------------
      | Resolve a URL de retorno
      |--------------------------------------------------------------------------
      */

      $redirectURL = $this->normalizeAutomatorRedirectURL(

        $request,

        $request->input('redirect_url')

      );


      /*
      |--------------------------------------------------------------------------
      | URL intended padrão do Laravel
      |--------------------------------------------------------------------------
      */

      if($redirectURL === null) {

        $redirectURL = $this->normalizeAutomatorRedirectURL(

          $request,

          $request->session()->pull(

            'url.intended'

          )

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Fallback para dashboard
      |--------------------------------------------------------------------------
      */

      if($redirectURL === null) {

        $redirectURL = url(

          '/' .

          trim(

            SysAutomator::SysAutomatorGetConfigValue(

              'system-admin',

              'admin'

            ),

            '/'

          )

        );

      }


      $request->session()->save();


      return response()->json([

        'status'       => true,
        'auth_check'   => Auth::guard('web')->check(),
        'user_id'      => Auth::guard('web')->id(),
        'message'      => SysAutomator::SysAutomatorGetTranslateWord('Login realizado com sucesso.'),
        'redirect_url' => $redirectURL,

      ]);


    }

    // public function loginAPI(Request $request) {


    //   $request->validate([

    //     'login'    => ['required', 'string'],
    //     'password' => ['required', 'string'],

    //   ], [

    //     'login.required'    => SysAutomator::SysAutomatorGetTranslateWord('Informe seu login.'),
    //     'password.required' => SysAutomator::SysAutomatorGetTranslateWord('Informe sua senha.'),

    //   ]);


    //   $login    = $request->input('login');
    //   $password = $request->input('password');

    //   $user = User::where('tbl_user_login', $login)->orWhere('tbl_user_email', $login)->first();

    //   if (!$user) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

    //     ], 401);

    //   }

    //   if (!Hash::check($password, $user->tbl_user_password)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

    //     ], 401);

    //   }

    //   if ($user->tbl_user_status != 'ativo') {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário não está ativo.'),

    //     ], 403);

    //   }

    //   if ((bool) $user->tbl_user_blocked === true) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário está bloqueado.'),

    //     ], 403);

    //   }

    //   if ((bool) $user->tbl_user_actived !== true) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário ainda não foi ativado.'),

    //     ], 403);

    //   }

    //   Auth::guard('web')->login($user, $request->boolean('remember'));

    //   $request->session()->regenerate();

    //   $request->session()->save();

    //   return response()->json([

    //     'status'       => true,
    //     'auth_check'   => Auth::guard('web')->check(),
    //     'user_id'      => Auth::guard('web')->id(),
    //     'message'      => SysAutomator::SysAutomatorGetTranslateWord('Login realizado com sucesso.'),
    //     'redirect_url' => url('/' . trim(SysAutomator::SysAutomatorGetConfigValue('system-admin', 'admin'), '/')),

    //   ]);


    // }


    /*
    |--------------------------------------------------------------------------
    | Verifica a sessão atual
    |--------------------------------------------------------------------------
    |
    | Esta função é utilizada pelo painel para:
    |
    | - verificação periódica;
    | - verificação após interação;
    | - identificação de sessão expirada.
    |
    */

    public function checkSession(Request $request) {


      $loginURL = SysAutomator::SysAutomatorGetRouteLinkByName(

        'admin-login',

        [],

        true

      );


      if(
        Auth::guard('web')->check() !== true ||
        Auth::guard('web')->user() === null
      ) {

        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'message'         => SysAutomator::SysAutomatorGetTranslateWord('Sua sessão expirou. Faça o login novamente para continuar.'),
          'login_url'       => $loginURL,

        ], 401);

      }


      return response()->json([

        'status'          => true,
        'authenticated'   => true,
        'session_expired' => false,
        'user_id'         => Auth::guard('web')->id(),
        'login_url'       => $loginURL,

      ], 200);


    }


    public function logout(Request $request) {


      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();


      return response()->json([

        'status'       => true,
        'redirect_url' => SysAutomator::SysAutomatorGetRouteLinkByName('admin-login', [], true),

      ]);

    
    }



    public function adminFunctions(Request $request) {


      $acao = trim(

        (string) $request->input(

          'acao',

          ''

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Verificação de sessão
      |--------------------------------------------------------------------------
      */

      if($acao == 'check-session') {

        return $this->checkSession(

          $request

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Autocomplete das funções internas
      |--------------------------------------------------------------------------
      */

      if($acao == 'get-sys-functions-autocomplete') {

        return $this->getSysFunctionsAutocomplete(

          $request

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Validação de senha
      |--------------------------------------------------------------------------
      */

      if($acao == 'validar-senha') {


        if(Auth::check()) {


          $user = Auth::user();


          if(!$user) {

            return response()->json([

              'status'          => false,
              'authenticated'   => false,
              'session_expired' => true,
              'title'           => 'Sessão expirada',
              'message'         => SysAutomator::SysAutomatorGetTranslateWord(
                'Sua sessão expirou. Faça o login novamente para continuar.'
              ),
              'login_url'       => SysAutomator::SysAutomatorGetRouteLinkByName(
                'admin-login',
                [],
                true
              ),

            ], 401);

          }


          $password = $request->input(

            'password'

          );


          if(!Hash::check($password, $user->tbl_user_password)) {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord(
                'Login ou senha inválidos.'
              ),

            ], 401);

          }


          if($user->tbl_user_status != 'ativo') {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord(
                'Este usuário não está ativo.'
              ),

            ], 403);

          }


          if((bool) $user->tbl_user_blocked === true) {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord(
                'Este usuário está bloqueado.'
              ),

            ], 403);

          }


          if((bool) $user->tbl_user_actived !== true) {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord(
                'Este usuário ainda não foi ativado.'
              ),

            ], 403);

          }


          return response()->json([

            'status'          => true,
            'authenticated'   => true,
            'session_expired' => false,
            'title'           => 'Validação realizada',
            'message'         => SysAutomator::SysAutomatorGetTranslateWord(
              'Credenciais validadas com sucesso.'
            ),

          ]);


        }


        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'title'           => 'Sessão expirada',
          'message'         => SysAutomator::SysAutomatorGetTranslateWord(
            'Sua sessão expirou. Faça o login novamente para continuar.'
          ),
          'login_url'       => SysAutomator::SysAutomatorGetRouteLinkByName(
            'admin-login',
            [],
            true
          ),

        ], 401);


      } elseif($acao == 'get-database-data') {


        return $this->getDatabaseDataForAdminFunctions(

          $request

        );


      } elseif($acao == 'render-pagination') {


        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Ação ainda não implementada.'
          ),

        ], 400);


      } elseif($acao == 'render-form') {


        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Ação ainda não implementada.'
          ),

        ], 400);


      }


      return response()->json([

        'status'  => false,
        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'Solicitação inválida!'
        ),

      ], 400);


    }

    // public function adminFunctions(Request $request) {


    //   $acao = trim(

    //     (string) $request->input(

    //       'acao',

    //       ''

    //     )

    //   );


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Verificação de sessão
    //   |--------------------------------------------------------------------------
    //   */

    //   if($acao == 'check-session') {

    //     return $this->checkSession(

    //       $request

    //     );

    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Validação de senha
    //   |--------------------------------------------------------------------------
    //   */

    //   if($acao == 'validar-senha') {


    //     if(Auth::check()) {


    //       $user = Auth::user();


    //       if(!$user) {

    //         return response()->json([

    //           'status'          => false,
    //           'authenticated'   => false,
    //           'session_expired' => true,
    //           'title'           => 'Sessão expirada',
    //           'message'         => SysAutomator::SysAutomatorGetTranslateWord('Sua sessão expirou. Faça o login novamente para continuar.'),
    //           'login_url'       => SysAutomator::SysAutomatorGetRouteLinkByName('admin-login', [], true),

    //         ], 401);

    //       }


    //       $password = $request->input(

    //         'password'

    //       );


    //       if(!Hash::check($password, $user->tbl_user_password)) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

    //         ], 401);

    //       }


    //       if($user->tbl_user_status != 'ativo') {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário não está ativo.'),

    //         ], 403);

    //       }


    //       if((bool) $user->tbl_user_blocked === true) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário está bloqueado.'),

    //         ], 403);

    //       }


    //       if((bool) $user->tbl_user_actived !== true) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário ainda não foi ativado.'),

    //         ], 403);

    //       }


    //       return response()->json([

    //         'status'          => true,
    //         'authenticated'   => true,
    //         'session_expired' => false,
    //         'title'           => 'Validação realizada',
    //         'message'         => SysAutomator::SysAutomatorGetTranslateWord('Credenciais validadas com sucesso.'),

    //       ]);


    //     }


    //     return response()->json([

    //       'status'          => false,
    //       'authenticated'   => false,
    //       'session_expired' => true,
    //       'title'           => 'Sessão expirada',
    //       'message'         => SysAutomator::SysAutomatorGetTranslateWord('Sua sessão expirou. Faça o login novamente para continuar.'),
    //       'login_url'       => SysAutomator::SysAutomatorGetRouteLinkByName('admin-login', [], true),

    //     ], 401);


    //   } elseif($acao == 'get-database-data') {


    //     return $this->getDatabaseDataForAdminFunctions(

    //       $request

    //     );


    //   } elseif($acao == 'render-pagination') {


    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Ação ainda não implementada.'),

    //     ], 400);


    //   } elseif($acao == 'render-form') {


    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Ação ainda não implementada.'),

    //     ], 400);


    //   }


    //   return response()->json([

    //     'status'  => false,
    //     'message' => SysAutomator::SysAutomatorGetTranslateWord('Solicitação inválida!'),

    //   ], 400);


    // }
    // ----------------------- NOVO ------------------
    // public function adminFunctions(Request $request) {


    //   $acao = $request->input('acao');


    //   if($acao == 'validar-senha') {

    //     if(Auth::check()) {

    //       $user = Auth::user();

    //       if (!$user) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

    //         ], 401);

    //       }


    //       $password = $request->input('password');


    //       if (!Hash::check($password, $user->tbl_user_password)) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

    //         ], 401);

    //       }


    //       if ($user->tbl_user_status != 'ativo') {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário não está ativo.'),

    //         ], 403);

    //       }

    //       if ((bool) $user->tbl_user_blocked === true) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário está bloqueado.'),

    //         ], 403);

    //       }

    //       if ((bool) $user->tbl_user_actived !== true) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => 'Validação inválida',
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário ainda não foi ativado.'),

    //         ], 403);

    //       }

    //       return response()->json([

    //         'status'  => true,
    //         'title'   => 'Validação realizada',
    //         'message' => SysAutomator::SysAutomatorGetTranslateWord('Credenciais validadas com sucesso.'),

    //       ]);

    //     } else {

    //       return response()->json([

    //         'status'  => false,
    //         'title'   => 'Validação inválida',
    //         'message' => SysAutomator::SysAutomatorGetTranslateWord('Solicitação inválida!'),

    //       ], 401);
        
    //     }

    //   } elseif($acao == 'get-database-data') {

    //     return $this->getDatabaseDataForAdminFunctions($request);

    //   } elseif($acao == 'render-pagination') {

    //   } elseif($acao == 'render-form') {

    //   }


    // }
    
    /*
    |--------------------------------------------------------------------------
    | Retorna as opções de uma coluna ENUM
    |--------------------------------------------------------------------------
    */

    private function getAutomatorDatabaseEnumOptions(
      string $tableName,
      string $columnName
    ): array {


      $result = [

        'is_enum' => false,

        'type' => '',

        'options' => [],

      ];


      if(
        $tableName === '' ||
        $columnName === ''
      ) {

        return $result;

      }


      if(
        !preg_match(
          '/^[a-zA-Z0-9_]+$/',
          $tableName
        ) ||
        !preg_match(
          '/^[a-zA-Z0-9_]+$/',
          $columnName
        )
      ) {

        return $result;

      }


      if(
        !Schema::hasTable(
          $tableName
        ) ||
        !Schema::hasColumn(
          $tableName,
          $columnName
        )
      ) {

        return $result;

      }


      try {


        $databaseName = DB::getDatabaseName();


        $column = DB::table(

          'information_schema.COLUMNS'

        )
          ->select([

            'DATA_TYPE',

            'COLUMN_TYPE',

          ])
          ->where(

            'TABLE_SCHEMA',

            $databaseName

          )
          ->where(

            'TABLE_NAME',

            $tableName

          )
          ->where(

            'COLUMN_NAME',

            $columnName

          )
          ->first();


        if($column === null) {

          return $result;

        }


        $dataType = strtolower(

          trim(

            (string) (

              $column->DATA_TYPE

              ?? $column->data_type

              ?? ''

            )

          )

        );


        $columnType = trim(

          (string) (

            $column->COLUMN_TYPE

            ?? $column->column_type

            ?? ''

          )

        );


        $result['type'] = $columnType;


        if(
          $dataType !== 'enum' ||
          !preg_match(
            '/^enum\s*\((.*)\)$/is',
            $columnType,
            $matches
          )
        ) {

          return $result;

        }


        $enumContent =

          $matches[1]

          ?? '';


        /*
        |--------------------------------------------------------------------------
        | Interpreta corretamente:
        |--------------------------------------------------------------------------
        |
        | enum('ativo','inativo')
        | enum('valor com espaço','outro valor')
        | enum('valor com \\' apóstrofo')
        |--------------------------------------------------------------------------
        */

        $enumValues = str_getcsv(

          $enumContent,

          ',',

          "'",

          '\\'

        );


        $options = [];


        foreach($enumValues as $enumValue) {


          $enumValue = stripcslashes(

            (string) $enumValue

          );


          $options[] = [

            'value' => $enumValue,

            'label' => $enumValue,

          ];


        }


        $result['is_enum'] = true;

        $result['options'] = $options;


        return $result;


      } catch(\Throwable $exception) {


        report(

          $exception

        );


        \Illuminate\Support\Facades\Log::error(

          'Falha ao carregar opções ENUM para o editor de paginações.',

          [

            'table' => $tableName,

            'column' => $columnName,

            'exception' => $exception->getMessage(),

            'file' => $exception->getFile(),

            'line' => $exception->getLine(),

          ]

        );


        return $result;


      }


    }



    /*
    |--------------------------------------------------------------------------
    | Retorna dados do banco para os editores administrativos
    |--------------------------------------------------------------------------
    */

    private function getDatabaseDataForAdminFunctions(
      Request $request
    ) {


      if(!Auth::check()) {

        return response()->json([

          'status'  => false,

          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Sessão expirada ou usuário não autenticado.'
          ),

          'data' => [],

        ], 401);

      }


      $dataType = trim(

        (string) $request->input(

          'data-type',

          ''

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Dados da rota selecionada no editor de paginação
      |--------------------------------------------------------------------------
      |
      | O editor envia:
      |
      | data-type = get-route-data
      | route-name = nome-da-rota
      |
      | Esta condição precisa existir antes das demais consultas, pois a leitura
      | da rota possui sua própria validação e tratamento dos parâmetros.
      |--------------------------------------------------------------------------
      */

      if($dataType === 'get-route-data') {

        return $this->getRouteDataForPaginationEditor(

          $request

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Tabelas
      |--------------------------------------------------------------------------
      */

      if($dataType === 'get-tables') {


        try {


          $tables = [];

          $databaseName = DB::getDatabaseName();

          $rows = DB::select(

            'SHOW TABLES'

          );


          foreach($rows as $row) {


            $row = (array) $row;


            $tableName =

              array_values($row)[0]

              ?? '';


            if($tableName === '') {

              continue;

            }


            $tables[] = [

              'value' => $tableName,

              'label' => $tableName,

            ];


          }


          usort(

            $tables,

            function($firstTable, $secondTable) {


              return strcmp(

                $firstTable['label'],

                $secondTable['label']

              );


            }

          );


          return response()->json([

            'status' => true,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Tabelas carregadas com sucesso.'
            ),

            'data' => $tables,

            'database' => $databaseName,

          ]);


        } catch(\Throwable $exception) {


          report(

            $exception

          );


          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Falha ao carregar tabelas do banco de dados.'
            ),

            'data' => [],

          ], 500);


        }


      }


      /*
      |--------------------------------------------------------------------------
      | Colunas de uma tabela
      |--------------------------------------------------------------------------
      */

      if($dataType === 'get-table-columns') {


        $tableName = trim(

          (string) $request->input(

            'table-name',

            $request->input(

              'table_name',

              ''

            )

          )

        );


        if(
          $tableName === '' ||
          !preg_match(
            '/^[a-zA-Z0-9_]+$/',
            $tableName
          )
        ) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Tabela inválida.'
            ),

            'data' => [],

          ], 400);

        }


        if(!Schema::hasTable($tableName)) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Tabela não encontrada.'
            ),

            'data' => [],

          ], 404);

        }


        try {


          $columns = Schema::getColumnListing(

            $tableName

          );


          $data = [];


          foreach($columns as $columnName) {


            $data[] = [

              'value' => $columnName,

              'label' => $columnName,

            ];


          }


          return response()->json([

            'status' => true,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Colunas carregadas com sucesso.'
            ),

            'table' => $tableName,

            'data' => $data,

          ]);


        } catch(\Throwable $exception) {


          report(

            $exception

          );


          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Falha ao carregar colunas da tabela.'
            ),

            'data' => [],

          ], 500);


        }


      }


      /*
      |--------------------------------------------------------------------------
      | Opções de uma coluna ENUM
      |--------------------------------------------------------------------------
      */

      if($dataType === 'get-table-enum-options') {


        $tableName = trim(

          (string) $request->input(

            'table-name',

            $request->input(

              'table_name',

              ''

            )

          )

        );


        $columnName = trim(

          (string) $request->input(

            'column-name',

            $request->input(

              'column_name',

              ''

            )

          )

        );


        if(
          $tableName === '' ||
          !preg_match(
            '/^[a-zA-Z0-9_]+$/',
            $tableName
          )
        ) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Tabela inválida.'
            ),

            'data' => [],

          ], 400);

        }


        if(
          $columnName === '' ||
          !preg_match(
            '/^[a-zA-Z0-9_]+$/',
            $columnName
          )
        ) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Coluna inválida.'
            ),

            'data' => [],

          ], 400);

        }


        if(!Schema::hasTable($tableName)) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Tabela não encontrada.'
            ),

            'data' => [],

          ], 404);

        }


        if(!Schema::hasColumn(
          $tableName,
          $columnName
        )) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Coluna não encontrada.'
            ),

            'data' => [],

          ], 404);

        }


        $enumData =

          $this->getAutomatorDatabaseEnumOptions(

            $tableName,

            $columnName

          );


        return response()->json([

          'status' => true,

          'message' => $enumData['is_enum'] === true

            ? SysAutomator::SysAutomatorGetTranslateWord(
                'Opções da coluna carregadas com sucesso.'
              )

            : SysAutomator::SysAutomatorGetTranslateWord(
                'A coluna selecionada não é do tipo ENUM.'
              ),

          'table' => $tableName,

          'column' => $columnName,

          'column_type' =>

            $enumData['type']

            ?? '',

          'is_enum' =>

            $enumData['is_enum']

            ?? false,

          'data' =>

            $enumData['options']

            ?? [],

        ]);


      }


      /*
      |--------------------------------------------------------------------------
      | Opções relacionais
      |--------------------------------------------------------------------------
      */

      if($dataType === 'get-table-options') {


        $tableName = trim(

          (string) $request->input(

            'table-name',

            $request->input(

              'table_name',

              ''

            )

          )

        );


        $valueColumn = trim(

          (string) $request->input(

            'value-column',

            $request->input(

              'value_column',

              ''

            )

          )

        );


        $labelColumn = trim(

          (string) $request->input(

            'label-column',

            $request->input(

              'label_column',

              ''

            )

          )

        );


        if(
          $tableName === '' ||
          !preg_match(
            '/^[a-zA-Z0-9_]+$/',
            $tableName
          )
        ) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Tabela inválida.'
            ),

            'data' => [],

          ], 400);

        }


        if(
          $valueColumn === '' ||
          !preg_match(
            '/^[a-zA-Z0-9_]+$/',
            $valueColumn
          )
        ) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Campo destino inválido.'
            ),

            'data' => [],

          ], 400);

        }


        if(
          $labelColumn === '' ||
          !preg_match(
            '/^[a-zA-Z0-9_]+$/',
            $labelColumn
          )
        ) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Label destino inválido.'
            ),

            'data' => [],

          ], 400);

        }


        if(!Schema::hasTable($tableName)) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Tabela não encontrada.'
            ),

            'data' => [],

          ], 404);

        }


        if(
          !Schema::hasColumn(
            $tableName,
            $valueColumn
          ) ||
          !Schema::hasColumn(
            $tableName,
            $labelColumn
          )
        ) {

          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Coluna inválida.'
            ),

            'data' => [],

          ], 400);

        }


        try {


          $rows = DB::table(

            $tableName

          )
            ->select([

              $valueColumn,

              $labelColumn,

            ])
            ->orderBy(

              $labelColumn,

              'asc'

            )
            ->get();


          $data = [];


          foreach($rows as $row) {


            $row = (array) $row;


            $data[] = [

              'value' =>

                $row[$valueColumn]

                ?? '',

              'label' =>

                $row[$labelColumn]

                ?? '',

            ];


          }


          return response()->json([

            'status' => true,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Opções carregadas com sucesso.'
            ),

            'data' => $data,

          ]);


        } catch(\Throwable $exception) {


          report(

            $exception

          );


          return response()->json([

            'status' => false,

            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Falha ao carregar opções.'
            ),

            'data' => [],

          ], 500);


        }


      }


      return response()->json([

        'status' => false,

        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'Tipo de solicitação inválido.'
        ),

        'data' => [],

      ], 400);


    }



    /*
    |--------------------------------------------------------------------------
    | Retorna dados do banco para os editores administrativos
    |--------------------------------------------------------------------------
    */

    // private function getDatabaseDataForAdminFunctions(
    //   Request $request
    // ) {


    //   if(!Auth::check()) {

    //     return response()->json([

    //       'status'  => false,

    //       'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //         'Sessão expirada ou usuário não autenticado.'
    //       ),

    //       'data' => [],

    //     ], 401);

    //   }


    //   $dataType = trim(

    //     (string) $request->input(

    //       'data-type',

    //       ''

    //     )

    //   );


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Tabelas
    //   |--------------------------------------------------------------------------
    //   */

    //   if($dataType === 'get-tables') {


    //     try {


    //       $tables = [];

    //       $databaseName = DB::getDatabaseName();

    //       $rows = DB::select(

    //         'SHOW TABLES'

    //       );


    //       foreach($rows as $row) {


    //         $row = (array) $row;


    //         $tableName =

    //           array_values($row)[0]

    //           ?? '';


    //         if($tableName === '') {

    //           continue;

    //         }


    //         $tables[] = [

    //           'value' => $tableName,

    //           'label' => $tableName,

    //         ];


    //       }


    //       usort(

    //         $tables,

    //         function($firstTable, $secondTable) {


    //           return strcmp(

    //             $firstTable['label'],

    //             $secondTable['label']

    //           );


    //         }

    //       );


    //       return response()->json([

    //         'status' => true,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Tabelas carregadas com sucesso.'
    //         ),

    //         'data' => $tables,

    //         'database' => $databaseName,

    //       ]);


    //     } catch(\Throwable $exception) {


    //       report(

    //         $exception

    //       );


    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Falha ao carregar tabelas do banco de dados.'
    //         ),

    //         'data' => [],

    //       ], 500);


    //     }


    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Colunas de uma tabela
    //   |--------------------------------------------------------------------------
    //   */

    //   if($dataType === 'get-table-columns') {


    //     $tableName = trim(

    //       (string) $request->input(

    //         'table-name',

    //         $request->input(

    //           'table_name',

    //           ''

    //         )

    //       )

    //     );


    //     if(
    //       $tableName === '' ||
    //       !preg_match(
    //         '/^[a-zA-Z0-9_]+$/',
    //         $tableName
    //       )
    //     ) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Tabela inválida.'
    //         ),

    //         'data' => [],

    //       ], 400);

    //     }


    //     if(!Schema::hasTable($tableName)) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Tabela não encontrada.'
    //         ),

    //         'data' => [],

    //       ], 404);

    //     }


    //     try {


    //       $columns = Schema::getColumnListing(

    //         $tableName

    //       );


    //       $data = [];


    //       foreach($columns as $columnName) {


    //         $data[] = [

    //           'value' => $columnName,

    //           'label' => $columnName,

    //         ];


    //       }


    //       return response()->json([

    //         'status' => true,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Colunas carregadas com sucesso.'
    //         ),

    //         'table' => $tableName,

    //         'data' => $data,

    //       ]);


    //     } catch(\Throwable $exception) {


    //       report(

    //         $exception

    //       );


    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Falha ao carregar colunas da tabela.'
    //         ),

    //         'data' => [],

    //       ], 500);


    //     }


    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Opções de uma coluna ENUM
    //   |--------------------------------------------------------------------------
    //   */

    //   if($dataType === 'get-table-enum-options') {


    //     $tableName = trim(

    //       (string) $request->input(

    //         'table-name',

    //         $request->input(

    //           'table_name',

    //           ''

    //         )

    //       )

    //     );


    //     $columnName = trim(

    //       (string) $request->input(

    //         'column-name',

    //         $request->input(

    //           'column_name',

    //           ''

    //         )

    //       )

    //     );


    //     if(
    //       $tableName === '' ||
    //       !preg_match(
    //         '/^[a-zA-Z0-9_]+$/',
    //         $tableName
    //       )
    //     ) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Tabela inválida.'
    //         ),

    //         'data' => [],

    //       ], 400);

    //     }


    //     if(
    //       $columnName === '' ||
    //       !preg_match(
    //         '/^[a-zA-Z0-9_]+$/',
    //         $columnName
    //       )
    //     ) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Coluna inválida.'
    //         ),

    //         'data' => [],

    //       ], 400);

    //     }


    //     if(!Schema::hasTable($tableName)) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Tabela não encontrada.'
    //         ),

    //         'data' => [],

    //       ], 404);

    //     }


    //     if(!Schema::hasColumn(
    //       $tableName,
    //       $columnName
    //     )) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Coluna não encontrada.'
    //         ),

    //         'data' => [],

    //       ], 404);

    //     }


    //     $enumData =

    //       $this->getAutomatorDatabaseEnumOptions(

    //         $tableName,

    //         $columnName

    //       );


    //     return response()->json([

    //       'status' => true,

    //       'message' => $enumData['is_enum'] === true

    //         ? SysAutomator::SysAutomatorGetTranslateWord(
    //             'Opções da coluna carregadas com sucesso.'
    //           )

    //         : SysAutomator::SysAutomatorGetTranslateWord(
    //             'A coluna selecionada não é do tipo ENUM.'
    //           ),

    //       'table' => $tableName,

    //       'column' => $columnName,

    //       'column_type' =>

    //         $enumData['type']

    //         ?? '',

    //       'is_enum' =>

    //         $enumData['is_enum']

    //         ?? false,

    //       'data' =>

    //         $enumData['options']

    //         ?? [],

    //     ]);


    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Opções relacionais
    //   |--------------------------------------------------------------------------
    //   */

    //   if($dataType === 'get-table-options') {


    //     $tableName = trim(

    //       (string) $request->input(

    //         'table-name',

    //         $request->input(

    //           'table_name',

    //           ''

    //         )

    //       )

    //     );


    //     $valueColumn = trim(

    //       (string) $request->input(

    //         'value-column',

    //         $request->input(

    //           'value_column',

    //           ''

    //         )

    //       )

    //     );


    //     $labelColumn = trim(

    //       (string) $request->input(

    //         'label-column',

    //         $request->input(

    //           'label_column',

    //           ''

    //         )

    //       )

    //     );


    //     if(
    //       $tableName === '' ||
    //       !preg_match(
    //         '/^[a-zA-Z0-9_]+$/',
    //         $tableName
    //       )
    //     ) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Tabela inválida.'
    //         ),

    //         'data' => [],

    //       ], 400);

    //     }


    //     if(
    //       $valueColumn === '' ||
    //       !preg_match(
    //         '/^[a-zA-Z0-9_]+$/',
    //         $valueColumn
    //       )
    //     ) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Campo destino inválido.'
    //         ),

    //         'data' => [],

    //       ], 400);

    //     }


    //     if(
    //       $labelColumn === '' ||
    //       !preg_match(
    //         '/^[a-zA-Z0-9_]+$/',
    //         $labelColumn
    //       )
    //     ) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Label destino inválido.'
    //         ),

    //         'data' => [],

    //       ], 400);

    //     }


    //     if(!Schema::hasTable($tableName)) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Tabela não encontrada.'
    //         ),

    //         'data' => [],

    //       ], 404);

    //     }


    //     if(
    //       !Schema::hasColumn(
    //         $tableName,
    //         $valueColumn
    //       ) ||
    //       !Schema::hasColumn(
    //         $tableName,
    //         $labelColumn
    //       )
    //     ) {

    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Coluna inválida.'
    //         ),

    //         'data' => [],

    //       ], 400);

    //     }


    //     try {


    //       $rows = DB::table(

    //         $tableName

    //       )
    //         ->select([

    //           $valueColumn,

    //           $labelColumn,

    //         ])
    //         ->orderBy(

    //           $labelColumn,

    //           'asc'

    //         )
    //         ->get();


    //       $data = [];


    //       foreach($rows as $row) {


    //         $row = (array) $row;


    //         $data[] = [

    //           'value' =>

    //             $row[$valueColumn]

    //             ?? '',

    //           'label' =>

    //             $row[$labelColumn]

    //             ?? '',

    //         ];


    //       }


    //       return response()->json([

    //         'status' => true,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Opções carregadas com sucesso.'
    //         ),

    //         'data' => $data,

    //       ]);


    //     } catch(\Throwable $exception) {


    //       report(

    //         $exception

    //       );


    //       return response()->json([

    //         'status' => false,

    //         'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //           'Falha ao carregar opções.'
    //         ),

    //         'data' => [],

    //       ], 500);


    //     }


    //   }


    //   return response()->json([

    //     'status' => false,

    //     'message' => SysAutomator::SysAutomatorGetTranslateWord(
    //       'Tipo de solicitação inválido.'
    //     ),

    //     'data' => [],

    //   ], 400);


    // }

    public function SystemLoadPageContent(Request $request, $shortcodeParams = [], $vars = [], $route = [], $originalShortcode = '') {


      if(!is_array($shortcodeParams)) {

        $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

      }


      if(!is_array($shortcodeParams)) {

        $shortcodeParams = [];

      }


      if(!is_array($vars)) {

        $vars = [];

      }


      $view = $shortcodeParams['view'] ?? $request->attributes->get('view') ?? null;


      if($view === null || trim($view) === '') {

        return '';

      }


      $view = trim($view);


      if(!View::exists($view)) {

        return '';

      }


      $resolvedVars = $vars;


      if(isset($shortcodeParams['vars']) && $shortcodeParams['vars'] !== '') {

        $varsName = trim($shortcodeParams['vars']);

        if(substr($varsName, 0, 1) == '$') {

          $varsName = substr($varsName, 1);

        }


        if(isset($vars[$varsName]) && is_array($vars[$varsName])) {

          $resolvedVars = $vars[$varsName];

        }

      }


      return view($view, $resolvedVars)->render();


    }

    public function dashboard(Request $request) {


      $slug = $request->route('pageSlug');


      // $this->createMenu();
      return SysAutomator::SysAutomatoRenderRouteContent($slug, [], 'restrict');

      

    }



    public function myAccount(Request $request) {


      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);


      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first()->toArray();

      if(!Auth::check()) {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('page.admin-login')->with('status', 'Sessão expirada!');

      } else {

        $_user = Auth::user();

        $currentUser = [

          'tbl_user_ID'    => $_user->tbl_user_ID,
          'tbl_user_name'  => $_user->tbl_user_name,
          'tbl_user_email' => $_user->tbl_user_email,
        
        ];


        return SysAutomator::SysAutomatoRenderRouteContent2($slug, ['currentUser' => $currentUser], 'restrict');

      }

    }



    public function myAccountAPI(Request $request) {


      $retorno = [

        'status'  => false,
        'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Solicitação inválida!'),
        'logout'  => false
      ];


      if(Auth::check()) {

        $_user = Auth::user();

        $id       = $request->input('tbl_user_ID');
        $name     = $request->input('tbl_user_name');
        $email    = $request->input('tbl_user_email');
        $pass     = $request->input('tbl_user_password');
        $confirm  = $request->input('tbl_user_confirm_password');

        if(isset($id) && $id != null) {

          if($id == $_user->tbl_user_ID) {

            if(isset($name) && $name != '') {

              if(strlen($name) >= 5) {

                if(strlen($name) <= 255) {

                  if(isset($email) && $email != '') {

                    if(strlen($email) >= 8) {

                      if(strlen($email) <= 255) {

                        $continuar = true;
                        if($email != $_user->tbl_user_email) {

                          $continuar = false;
                          $search = User::where('tbl_user_email', $email)->first();
                          if($search) {

                            $search = ( (array) $search );
                            if(count($search) <= 0) {

                              $continuar = true;

                            } else {

                              $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O valor informado no campo 'E-mail' ja está sendo utilizado por outro usuário!");

                            }

                          } else {

                            $continuar = true;

                          }

                        }

                        if($continuar == true) {

                          if(strlen($pass) <= 0 ) {
                            
                            $passwd = false;

                          } else {

                            $passwd    = true;
                            $continuar = false;

                            if(strlen($pass) >= 8) {

                              if(strlen($pass) <= 255) {

                                if(isset($confirm) && $confirm != '') {

                                  if(strlen($confirm) >= 8) {

                                    if(strlen($confirm) <= 255) {

                                      if($pass == $confirm) {

                                        $continuar = true;

                                      } else {

                                        $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O valor do campo 'Nova senha' deve ser igual ao valor do campo 'Confirmar Nova senha'!");

                                      }

                                    } else {

                                      $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Confirmar Nova senha' deve ser menor que 255 caracteres!");

                                    }

                                  } else {

                                    $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Confirmar Nova senha' deve ser maior que 7 caracteres!");

                                  }

                                } else {

                                  $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Confirmar Nova senha' é obrigatório quando o campo 'Nova senha' é preenchido!");

                                }

                              } else {

                                $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Nova senha' deve ser menor que 255 caracteres!");

                              }

                            } else {

                              $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Nova senha' deve ser maior que 7 caracteres!");

                            }

                          }

                          if($continuar == true) {

                            $update = [];
                            if($passwd == true) {

                              if($retorno['logout'] == false) {

                                $retorno['logout'] = true;

                              }

                              $pass = Hash::make($pass);
                              $update['tbl_user_password'] = $pass;

                            }

                            if($_user->tbl_user_email != $email) {
                              
                              $update['tbl_user_email'] = $email;

                              if($retorno['logout'] == false) {

                                $retorno['logout'] = true;

                              }

                            }

                            if($_user->tbl_user_name != $name) {

                              $update['tbl_user_name'] = $name;

                            }


                            $UserUpdate = User::where('tbl_user_id', $id)->update($update);
                            if($UserUpdate) {

                              $retorno['status']   = true;
                              $retorno['title']    = SysAutomator::SysAutomatorGetTranslateWord('SUCESSO');
                              $retorno['message']  = SysAutomator::SysAutomatorGetTranslateWord('Dados atualizado com sucesso!');


                            } else {

                              $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("Falha ao atualizar os dados de sua conta!");

                            }

                          }
                          

                        }

                      } else {

                        $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'E-mail' deve ser menor que 255 caracteres!");

                      }

                    } else {

                      $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'E-mail' deve ser maior que 11 caracteres!");

                    }

                  } else {

                    $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'E-mail' é obrigatório!");

                  }

                } else {

                  $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Nome' deve ser menor que 255 caracteres!");

                }

              } else {

                $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Nome' deve ser maior que 7 caracteres!");

              }

            } else {

              $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O campo 'Nome' é obrigatório!");

            }

          }

        }

      }

      return response()->json($retorno);

      // return $response;

    }



    public function adminGetView(Request $request) {


      /*
      |--------------------------------------------------------------------------
      | Valida o payload
      |--------------------------------------------------------------------------
      */

      $view = $request->input('view');

      if($view === null || $view === '') {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('View não informada.'),

        ], 400);

      }


      /*
      |--------------------------------------------------------------------------
      | Dados extras do payload disponíveis para a blade
      |--------------------------------------------------------------------------
      */

      $data = $request->except('view');


      /*
      |--------------------------------------------------------------------------
      | Mapeia as views disponíveis
      |--------------------------------------------------------------------------
      */

      $dados = [];

      $views = [

        'admin-routes-apis-access' => [

          'view'   => 'system.modals.admin-routes-apis-access',
          'title'  => SysAutomator::SysAutomatorGetTranslateWord('Permissões da Rota'),
          'dados'  => $dados,
          'footer' => null,

        ],

        'system-install-modulos' => [

          'view'   => 'system.modals.system-install-modulos',
          'title'  => SysAutomator::SysAutomatorGetTranslateWord('Instalar Módulo'),
          'dados'  => $dados,
          'footer' => null,

        ]

      ];


      if(Auth::check()) {

        /*
        |--------------------------------------------------------------------------
        | Editor de páginas
        |--------------------------------------------------------------------------
        */

        $modal = [

          'title' => SysAutomator::SysAutomatorGetTranslateWord('Nova Página')

        ];


        $dadosPageEditor = [

          'header' => [

            'type'    => 'form-input',
            'content' => [

              'type'      => 'text',
              'id'        => 'tbl_sys_route_title',
              'name'      => 'tbl_sys_route_title',
              'label'     => SysAutomator::SysAutomatorGetTranslateWord('Nome da página'),
              'required'  => true,
              'value'     => '',
              'have-slug' => [

                'enabled' => true,
                'field'   => '#automator-editor-slug',
                'label'   => SysAutomator::SysAutomatorGetTranslateWord('Gerar Nome')

              ],

            ]

          ],

          'configs' => [

            'page-settings' => [

              'default'     => true,
              'label'       => SysAutomator::SysAutomatorGetTranslateWord('Página'),
              'description' => SysAutomator::SysAutomatorGetTranslateWord('Configurações Básicas da página'),
              'fields'      => [

                'automator-editor-slug' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_route_name',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Nome da página'),
                  'value'    => '',
                  'required' => true

                ],
                'automator-editor-permalink' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_route_permalink',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Link Permanente'),
                  'value'    => '',
                  'required' => false

                ],
                'automator-editor-route-type' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_route_type',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Tipo de Rota'),
                  'value'    => 'GET',
                  'required' => true,
                  'choices'  => [

                    'GET'  => 'GET',
                    'POST' => 'POST'

                  ]

                ],
                'automator-editor-route-api' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_route_api',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Rota de API'),
                  'value'    => 0,
                  'required' => true,
                  'choices'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ],
                'automator-editor-route-admin' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_route_admin',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Prefixo de Painel'),
                  'value'    => 0,
                  'required' => true,
                  'choices'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ],
                'automator-editor-route-locked' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_route_locked',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Rota bloqueada'),
                  'value'    => 0,
                  'required' => true,
                  'choices'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ],
                'automator-editor-route-area' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_route_area',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Área da rota'),
                  'value'    => 'public',
                  'required' => true,
                  'choices'  => [

                    'public'   => SysAutomator::SysAutomatorGetTranslateWord('Pública'),
                    'restrict' => SysAutomator::SysAutomatorGetTranslateWord('Restrita')

                  ]

                ],
                'automator-editor-route-status' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_route_status',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Status'),
                  'value'    => 'ativo',
                  'required' => true,
                  'choices'  => [

                    'ativo'   => SysAutomator::SysAutomatorGetTranslateWord('Ativo'),
                    'inativo' => SysAutomator::SysAutomatorGetTranslateWord('Inativo')

                  ]

                ],
                'automator-editor-controller' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_route_controller',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Controller'),
                  'value'    => 'AutomatorController',
                  'required' => false

                ],
                'automator-editor-method' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_route_method',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Method'),
                  'value'    => 'viewPage',
                  'required' => false

                ],
                'automator-editor-description' => [

                  'type'     => 'textarea',
                  'name'     => 'tbl_sys_route_description',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Descrição'),
                  'value'    => '',
                  'required' => false

                ]

              ]

            ]

          ]

        ];


        $page = [];

        if(isset($data['pageID'])) {

          $page = SysRoute::where('tbl_sys_route_ID', $data['pageID'])->first();

          if($page) {

            $page = $page->toArray();

            $modal['title'] = SysAutomator::SysAutomatorGetTranslateWord('Editar Página');

            $dadosPageEditor['header']['content']['value']                                           = $page['tbl_sys_route_title'];
            $dadosPageEditor['configs']['page-settings']['fields']['automator-editor-slug']['value'] = $page['tbl_sys_route_name'];

          }

        }


        $blocks = [];

        $grupos = SysAutomator::SysAutomatorRenderPageBuilderFields();

        foreach($grupos as $grupo) {

          foreach($grupo['tbl_sys_field_type_group_fields'] as $field) {

            $blocks[] = SysAutomator::SysAutomatorRenderPageBuilderField($field);

          }

        }


        $views['system-page-editor'] = [

          'view'      => 'system.modals.system-page-editor',
          'title'     => $modal['title'],
          'acao'      => ((isset($data['pageID'])) ? 'update' : 'store'),
          'view_data' => $dadosPageEditor,
          'dados'     => [

            'page'   => $page,
            'blocks' => $blocks,

          ],
          'classes' => [

            'modal-body' => 'p-0'

          ],
          'footer' => null,

        ];


        /*
        |--------------------------------------------------------------------------
        | Editor de formulários
        |--------------------------------------------------------------------------
        */

        $modalForm = [

          'title' => SysAutomator::SysAutomatorGetTranslateWord('Novo Formulário')

        ];


        $dadosFormEditor = [

          'header' => [

            'type'    => 'form-input',
            'content' => [

              'type'      => 'text',
              'id'        => 'tbl_sys_form_title',
              'name'      => 'tbl_sys_form_title',
              'label'     => SysAutomator::SysAutomatorGetTranslateWord('Título do formulário'),
              'required'  => true,
              'value'     => '',
              'have-slug' => [

                'enabled' => true,
                'field'   => '#tbl_sys_form_name',
                'label'   => SysAutomator::SysAutomatorGetTranslateWord('Gerar Nome')

              ],

            ]

          ],

          'configs' => [

            'form-settings' => [

              'default'     => true,
              'label'       => SysAutomator::SysAutomatorGetTranslateWord('Formulário'),
              'description' => SysAutomator::SysAutomatorGetTranslateWord('Configurações principais do formulário'),
              'fields'      => [

                'tbl_sys_form_name' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_form_name',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Nome interno'),
                  'value'    => '',
                  'required' => true

                ],

                'tbl_sys_form_admin' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_form_admin',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Formulário Protegido'),
                  'value'    => 1,
                  'required' => true,
                  'options'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ],

                'tbl_sys_form_method' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_form_method',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Método'),
                  'value'    => '',
                  'required' => false,
                  'options'  => [

                    ''     => '- Selecione -',
                    'POST' => 'POST',
                    'GET'  => 'GET'

                  ]

                ],

                'tbl_sys_form_modal' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_form_modal',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Abrir em modal'),
                  'value'    => 1,
                  'required' => true,
                  'options'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ],

                'tbl_sys_form_submit' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_form_submit',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Texto do botão salvar'),
                  'value'    => SysAutomator::SysAutomatorGetTranslateWord('Salvar'),
                  'required' => false

                ],

                'tbl_sys_form_cancel' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_form_cancel',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Texto do botão cancelar/fechar'),
                  'value'    => SysAutomator::SysAutomatorGetTranslateWord('Cancelar'),
                  'required' => true

                ],

                'tbl_sys_form_route' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_form_route',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Rota de envio'),
                  'value'    => '',
                  'required' => false

                ],

                'tbl_sys_form_validate' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_form_validate',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Validar com senha'),
                  'value'    => 0,
                  'required' => true,
                  'options'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ],

                'tbl_sys_form_locked' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_form_locked',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Bloqueado'),
                  'value'    => 0,
                  'required' => true,
                  'options'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ]

              ]

            ]

          ],

          'fields' => SysAutomator::SysAutomatorRenderFormBuilderFields()

        ];


        $form = [];

        if(isset($data['formID']) && $data['formID'] != '') {

          $form = SysForm::where('tbl_sys_form_ID', $data['formID'])->first();

          if($form) {

            $form = $form->toArray();

            $modalForm['title'] = SysAutomator::SysAutomatorGetTranslateWord('Editar Formulário');

            $dadosFormEditor['header']['content']['value'] = $form['tbl_sys_form_title'] ?? '';

            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_name']['value']     = $form['tbl_sys_form_name'] ?? '';
            // $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_type']['value']     = $form['tbl_sys_form_type'] ?? '';
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_admin']['value']    = $form['tbl_sys_form_admin'] ?? 0;
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_method']['value']   = $form['tbl_sys_form_method'] ?? 'POST';
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_modal']['value']    = $form['tbl_sys_form_modal'] ?? 1;
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_submit']['value']   = $form['tbl_sys_form_submit'] ?? SysAutomator::SysAutomatorGetTranslateWord('Salvar');
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_cancel']['value']   = $form['tbl_sys_form_cancel'] ?? SysAutomator::SysAutomatorGetTranslateWord('Cancelar');
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_route']['value']    = $form['tbl_sys_form_route'] ?? '';
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_validate']['value'] = $form['tbl_sys_form_validate'] ?? 0;
            $dadosFormEditor['configs']['form-settings']['fields']['tbl_sys_form_locked']['value']   = $form['tbl_sys_form_locked'] ?? 0;

          }

        }


        $formBlocks = [];

        foreach($dadosFormEditor['fields'] as $grupo) {

          foreach(($grupo['tbl_sys_field_type_group_fields'] ?? []) as $field) {

            $formBlocks[] = SysAutomator::SysAutomatorRenderPageBuilderField($field);

          }

        }


        $views['system-form-editor'] = [

          'view'      => 'system.modals.system-form-editor',
          'title'     => $modalForm['title'],
          'acao'      => ((isset($data['formID']) && $data['formID'] != '') ? 'update' : 'store'),
          'view_data' => $dadosFormEditor,
          'dados'     => [

            'form'   => $form,
            'blocks' => $formBlocks,

          ],
          'classes' => [

            'modal-body' => 'p-0'

          ],
          'footer' => null,

        ];


        /*
        |--------------------------------------------------------------------------
        | Editor de paginações
        |--------------------------------------------------------------------------
        */


        $modalPagination = [

          'title'   => SysAutomator::SysAutomatorGetTranslateWord('Nova Paginação'),

        ];



        // $_routes = SysAutomator::SysAutomatorRenderPaginationRoutesList('web');


        $tables = [];
        $databaseName = DB::getDatabaseName();

        $rows = DB::select('SHOW TABLES');

        foreach($rows as $row) {

          $row = (array) $row;

          $tableName = array_values($row)[0] ?? '';

          if($tableName == '') {
            continue;
          }

          $tables[] = [
            'value' => $tableName,
            'label' => $tableName,
          ];

        }

        usort($tables, function($a, $b) {
          return strcmp($a['label'], $b['label']);
        });

        $_tables = [];

        foreach ($tables as $_table) {
          
          if(!in_array($_table['value'], $_tables)) {

            $_tables[$_table['value']] = $_table['label'];

          }

        }


        $dadosPaginationEditor = [

          'header' => [

            'type'    => 'form-input',
            'content' => [

              'type'      => 'text',
              'id'        => 'tbl_sys_pagination_title',
              'name'      => 'tbl_sys_pagination_title',
              'label'     => SysAutomator::SysAutomatorGetTranslateWord('Titulo da Paginação'),
              'required'  => true,
              'value'     => '',

            ]

          ],
          'actions' => [
            'inserter' => false,
            'structure' => false,
            'buttons'   => false,
          ],
          'configs' => [

            'pagination-settings' => [

              'default'     => true,
              'disabled'    => false,
              'label'       => SysAutomator::SysAutomatorGetTranslateWord('Configurações'),
              'description' => SysAutomator::SysAutomatorGetTranslateWord('Configurações principais da paginação'),
              'fields'      => [

                'tbl_sys_pagination_name' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_pagination_name',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Nome da paginação'),
                  'value'    => '',
                  'required' => true

                ],

                'pagintarionArgs-page_name' => [

                  'type'        => 'text',
                  'name'        => 'page_name',
                  'class'       => 'form-floating mb-3',
                  'inputClass'  => 'automator-sysfunctions',
                  'label'       => SysAutomator::SysAutomatorGetTranslateWord('Nome da página'),
                  'value'       => '',
                  'placeholder' => "@SysFunctions('sysGetRouteData', ['data' => 'tbl_sys_route_name'])",
                  'required'    => true

                ],

                'tbl_sys_pagination_route' => [

                  'type'      => 'select',
                  'name'      => 'tbl_sys_pagination_route',
                  'class'     => 'form-floating mb-3',
                  'label'     => SysAutomator::SysAutomatorGetTranslateWord('Rota'),
                  'value'     => "",
                  'nullValue' => "- Selecione -",
                  'required'  => true,
                  'options'   => SysAutomator::SysAutomatorRenderPaginationRoutesList('web')
                  // 'options'  => $_routes

                ],

                'tbl_sys_pagination_table' => [

                  'type'      => 'select',
                  'name'      => 'tbl_sys_pagination_table',
                  'class'     => 'form-floating mb-3',
                  'label'     => SysAutomator::SysAutomatorGetTranslateWord('Tabela'),
                  'value'     => "",
                  'nullValue' => "- Selecione -",
                  'disabled'  => false,
                  'required'  => true,
                  'options'   => $_tables

                ],

                'tbl_sys_pagination_index' => [

                  'type'      => 'select',
                  'name'      => 'tbl_sys_pagination_index',
                  'class'     => 'form-floating mb-3',
                  'label'     => SysAutomator::SysAutomatorGetTranslateWord('Chave Primária'),
                  'value'     => "",
                  'nullValue' => "- Selecione a tabela -",
                  'required'  => true,
                  'disabled'  => true,
                  'options'   => []

                ],

                'pagintarionArgs-per_page' => [

                  'type'     => 'select',
                  'name'     => 'per_page',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Itens por página'),
                  'value'    => 15,
                  'required' => true,
                  'choices'  => [

                    10  => '10',
                    15  => '15',
                    25  => '25',
                    50  => '50',
                    100 => '100',

                  ]

                ],

                'tbl_sys_pagination_locked' => [

                  'type'     => 'select',
                  'name'     => 'tbl_sys_pagination_locked',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Bloqueado'),
                  'value'    => 0,
                  'required' => true,
                  'options'  => [

                    1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
                    0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

                  ]

                ],

              ]

            ],
            'pagination-actions' => [

              'default'      => false,
              'disabled'     => true,
              'disabledText' => SysAutomator::SysAutomatorGetTranslateWord("Para liberar esta 'aba' conclua a configuração!"),
              'label'        => SysAutomator::SysAutomatorGetTranslateWord('Ações'),
              'description'  => SysAutomator::SysAutomatorGetTranslateWord('Rotas de ações da paginação'),
              'fields'       => [

                'pagintarionArgs-actions' => [

                  'type'     => 'dynamic-inserter',
                  'name'     => 'actions',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Rotas da paginção'),
                  'value'    => '',
                  'routes'   => SysAutomator::SysAutomatorRenderPaginationRoutesList('api'),
                  'required' => false

                ],

              ]

            ]

          ],

          'fields' => SysAutomator::SysAutomatorRenderPaginationBuilderFields()

        ];


        $pagination = [];

        $paginationID = ( (isset($data['pageID'])) ? ( ($data['pageID'] != '') ? $data['pageID'] : null ) : null );

        if($paginationID != null) {

          $pagination = SysPagination::where('tbl_sys_pagination_ID', $paginationID)->first();
          if($pagination) {

            $pagination = $pagination->toArray();


            $modalPagination['title'] = SysAutomator::SysAutomatorGetTranslateWord('Editar Paginação');

            $dadosPaginationEditor['header']['content']['value']                                                       = $pagination['tbl_sys_pagination_title'] ?? '';
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['tbl_sys_pagination_name']['value']     = $pagination['tbl_sys_pagination_name'] ?? '';
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['pagintarionArgs-page_name']['value']   = '';
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['tbl_sys_pagination_route']['value']    = $pagination['tbl_sys_pagination_route'] ?? '';
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['tbl_sys_pagination_table']['value']    = $pagination['tbl_sys_pagination_table'] ?? '';
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['tbl_sys_pagination_table']['disabled'] = true;

            $columns = Schema::getColumnListing($pagination['tbl_sys_pagination_table']);

            $_columns = [];

            foreach ($columns as $column) {
              
              if(!in_array($column, $_columns)){

                $_columns[$column] = $column;

              }

            }

            $dadosPaginationEditor['configs']['pagination-settings']['fields']['tbl_sys_pagination_index']['choices']  = $_columns;
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['tbl_sys_pagination_index']['value']    = $pagination['tbl_sys_pagination_index'] ?? '';
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['pagintarionArgs-per_page']['value']    = 15;
            $dadosPaginationEditor['configs']['pagination-settings']['fields']['tbl_sys_pagination_locked']['value']   = $pagination['tbl_sys_pagination_locked'] ?? 0;
            

          }

        }


        $paginationBlocks = [];


        foreach($dadosPaginationEditor['fields'] as $grupo) {


          foreach(($grupo['tbl_sys_field_type_group_fields'] ?? []) as $field) {


            $paginationBlock = SysAutomator::SysAutomatorRenderPageBuilderField(

              $field,

              [],

              false

            );


            if(
              is_array($paginationBlock) &&
              count($paginationBlock) >= 1
            ) {

              $paginationBlocks[] = $paginationBlock;

            }


          }


        }

        $paginationEditorSecurityData = $this->preparePaginationEditorSecurityData();


        $paginationEditorData = array_merge(

          [

            'form'       => $pagination,
            'pagination' => $pagination,
            'fields'     => $dadosPaginationEditor['fields'],
            'blocks'     => $paginationBlocks,

          ],

          $paginationEditorSecurityData

        );


        $views['system-pagination-editor'] = [

          'view'  => 'system.modals.system-pagination-editor',
          'title' => $modalPagination['title'],
          'acao'  =>

            (

              $paginationID != null

                ? 'update'

                : 'store'

            ),

          'view_data' => $dadosPaginationEditor,
          'dados'     => $paginationEditorData,
          'classes'   => [

            'modal-body' => 'p-0',

          ],

          'footer' => null,

        ];

        // $paginationEditorSecurityData = $this->preparePaginationEditorSecurityData();


        // $views['system-pagination-editor'] = [

        //   'view'      => 'system.modals.system-pagination-editor',
        //   'title'     => $modalPagination['title'],
        //   'acao'      => (($paginationID != null) ? 'update' : 'store'),
        //   'view_data' => $dadosPaginationEditor,
        //   'dados'     => [

        //     'form'       => $pagination,
        //     'pagination' => $pagination,
        //     'fields'     => $dadosPaginationEditor['fields'],
        //     'blocks'     => $paginationBlocks,
        //     'userTypes' =>

        //       $paginationEditorSecurityData[
        //         'userTypes'
        //       ],

        //     'user_types' =>

        //       $paginationEditorSecurityData[
        //         'user_types'
        //       ],

        //     'currentUser' =>

        //       $paginationEditorSecurityData[
        //         'currentUser'
        //       ],

        //   ],
        //   'classes' => [

        //     'modal-body' => 'p-0'

        //   ],
        //   'footer' => null,

        // ];

      }


      /*
      |--------------------------------------------------------------------------
      | Verifica se a view solicitada existe no mapa
      |--------------------------------------------------------------------------
      */

      if(!isset($views[$view])) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('View não encontrada.'),

        ], 404);

      }

      $viewConfig = $views[$view];


      /*
      |--------------------------------------------------------------------------
      | Renderiza a blade e retorna
      |--------------------------------------------------------------------------
      */

      $viewData = isset($viewConfig['view_data'])
        ? $viewConfig['view_data']
        : (isset($viewConfig['dados']) ? $viewConfig['dados'] : $dados);

      $content = view($viewConfig['view'], $viewData)->render();

      $footer  = ($viewConfig['footer'] !== null)
        ? view($viewConfig['footer'], $data)->render()
        : null;


      return response()->json([

        'status'  => true,
        'title'   => $viewConfig['title'],
        'content' => $content,
        'acao'    => ((isset($viewConfig['acao'])) ? $viewConfig['acao'] : ''),
        'dados'   => ((isset($viewConfig['dados'])) ? $viewConfig['dados'] : []),
        'classes' => [

          'modal-body' => ((isset($viewConfig['classes']['modal-body'])) ? $viewConfig['classes']['modal-body'] : ''),

        ],
        'footer'  => $footer,

      ], 200);


    }



    /*
    |--------------------------------------------------------------------------
    | Retorna os dados de uma rota para o editor de paginação
    |--------------------------------------------------------------------------
    */

    private function getRouteDataForPaginationEditor(
      Request $request
    ) {


      if(!Auth::check()) {

        return response()->json([

          'status'  => false,

          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Sessão expirada ou usuário não autenticado.'
          ),

          'data' => [],

        ], 401);

      }


      $routeName = trim(

        (string) $request->input(

          'route-name',

          $request->input(

            'route_name',

            ''

          )

        )

      );


      if($routeName === '') {

        return response()->json([

          'status' => false,

          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Informe a rota que deseja carregar.'
          ),

          'data' => [],

        ], 400);

      }


      /*
      |--------------------------------------------------------------------------
      | Somente rotas de API podem ser utilizadas nas ações
      |--------------------------------------------------------------------------
      */

      $route = SysRoute::where(

        'tbl_sys_route_name',

        $routeName

      )
        ->where(

          'tbl_sys_route_api',

          true

        )
        ->first();


      if($route === null) {

        return response()->json([

          'status' => false,

          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'A rota informada não foi encontrada.'
          ),

          'data' => [],

        ], 404);

      }


      $routeArgs = trim(

        (string) (

          $route->tbl_sys_route_args

          ?? ''

        )

      );


      $params = [];


      /*
      |--------------------------------------------------------------------------
      | Extrai argumentos registrados no padrão {argumento} ou {argumento?}
      |--------------------------------------------------------------------------
      */

      if($routeArgs !== '') {


        preg_match_all(

          '/\{([^{}]+)\}/',

          $routeArgs,

          $matches

        );


        if(
          isset($matches[1]) &&
          is_array($matches[1])
        ) {


          foreach($matches[1] as $paramName) {


            $paramOriginal = trim(

              (string) $paramName

            );


            $isOptional = str_ends_with(

              $paramOriginal,

              '?'

            );


            $normalizedParamName = trim(

              rtrim(

                $paramOriginal,

                '?'

              )

            );


            if(
              $normalizedParamName === '' ||
              array_key_exists(
                $normalizedParamName,
                $params
              )
            ) {

              continue;

            }


            $params[$normalizedParamName] = [

              'name' => $normalizedParamName,

              'value' => '',

              'required' => !$isOptional,

              'default' => true,

            ];


          }


        }


      }


      return response()->json([

        'status' => true,

        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'Informações da rota carregadas com sucesso.'
        ),

        'data' => [

          'id' =>

            $route->tbl_sys_route_ID,

          'name' =>

            $route->tbl_sys_route_name,

          'title' =>

            $route->tbl_sys_route_title,

          'type' =>

            strtoupper(

              trim(

                (string) (

                  $route->tbl_sys_route_type

                  ?? 'GET'

                )

              )

            ),

          'args' =>

            $routeArgs,

          'params' =>

            array_values(

              $params

            ),

        ],

      ], 200);


    }


    // private function getRouteDataForPaginationEditor(Request $request) {


    //   if(!Auth::check()) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Sessão expirada ou usuário não autenticado.'),
    //       'data'    => [],

    //     ], 401);

    //   }


    //   $routeName = trim((string) $request->input(

    //     'route-name',

    //     $request->input('route_name', '')

    //   ));


    //   if($routeName == '') {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Informe a rota que deseja carregar.'),
    //       'data'    => [],

    //     ], 400);

    //   }


    //   $route = SysRoute::where('tbl_sys_route_name', $routeName)
    //     ->where('tbl_sys_route_api', true)
    //     ->first();


    //   if(!$route) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('A rota informada não foi encontrada.'),
    //       'data'    => [],

    //     ], 404);

    //   }


    //   $routeArgs = trim((string) $route->tbl_sys_route_args);

    //   $params = [];


    //   if($routeArgs != '') {

    //     preg_match_all(

    //       '/\{([^{}]+)\}/',

    //       $routeArgs,

    //       $matches

    //     );


    //     if(
    //       isset($matches[1]) &&
    //       is_array($matches[1]) &&
    //       count($matches[1]) >= 1
    //     ) {

    //       foreach($matches[1] as $paramName) {

    //         $paramOriginal = trim((string) $paramName);

    //         $paramName = trim(

    //           str_replace('?', '', $paramOriginal)

    //         );


    //         if(
    //           $paramName == '' ||
    //           array_key_exists($paramName, $params)
    //         ) {

    //           continue;

    //         }


    //         $params[$paramName] = [

    //           'name'     => $paramName,
    //           'value'    => '',
    //           'required' => substr($paramOriginal, -1) != '?',
    //           'default'  => true,

    //         ];

    //       }

    //     }

    //   }


    //   return response()->json([

    //     'status'  => true,
    //     'message' => SysAutomator::SysAutomatorGetTranslateWord('Informações da rota carregadas com sucesso.'),
    //     'data'    => [

    //       'name'   => $route->tbl_sys_route_name,
    //       'title'  => $route->tbl_sys_route_title,
    //       'type'   => $route->tbl_sys_route_type,
    //       'args'   => $routeArgs,
    //       'params' => array_values($params),

    //     ],

    //   ]);


    // }


    private function preparePaginationEditorSecurityData(): array {


      $userTypes = UsersType::query()
        ->orderBy(
          'tbl_users_type_ID',
          'asc'
        )
        ->get()
        ->map(function($userType) {


          $userTypeID =

            (string) $userType->tbl_users_type_ID;


          $userTypeName =

            (string) $userType->tbl_users_type_name;


          return [

            'id' =>

              $userTypeID,


            'name' =>

              $userTypeName,


            'tbl_users_type_ID' =>

              $userTypeID,


            'tbl_users_type_name' =>

              $userTypeName,


            'isDeveloper' =>

              mb_strtolower(

                trim(

                  $userTypeName

                )

              ) === 'desenvolvedor',

          ];


        })
        ->values()
        ->toArray();


      $currentUser = Auth::user();


      $currentUserTypeID = null;

      $currentUserTypeName = '';


      if($currentUser !== null) {


        $currentUserTypeID =

          $currentUser->tbl_users_type_ID ??

          $currentUser->tbl_user_type_ID ??

          null;


        if($currentUserTypeID !== null) {


          $currentUserTypeName =

            (string) UsersType::where(

              'tbl_users_type_ID',

              $currentUserTypeID

            )->value(

              'tbl_users_type_name'

            );


        }


      }


      /*
      |--------------------------------------------------------------------------
      | Formulários auxiliares do editor de ações
      |--------------------------------------------------------------------------
      */


      $actionBuilderFormNames = [

        'modal-form' =>

          'admin-open-form-modal',

        'modal-view' =>

          'admin-open-view-modal',

      ];


      $actionBuilderForms = [];


      $actionBuilderFormsQuery = SysForm::query()
        ->select([

          'tbl_sys_form_ID',

          'tbl_sys_form_name',

          'tbl_sys_form_title',

        ])
        ->whereIn(

          'tbl_sys_form_name',

          array_values(

            $actionBuilderFormNames

          )

        )
        ->get();


      foreach(
        $actionBuilderFormNames as
        $actionBuilderType =>
        $actionBuilderFormName
      ) {


        $actionBuilderForm =

          $actionBuilderFormsQuery->firstWhere(

            'tbl_sys_form_name',

            $actionBuilderFormName

          );


        if($actionBuilderForm === null) {

          continue;

        }


        $formID =

          (string) $actionBuilderForm->tbl_sys_form_ID;


        $formName =

          (string) $actionBuilderForm->tbl_sys_form_name;


        $formTitle =

          (string) $actionBuilderForm->tbl_sys_form_title;


        $actionBuilderForms[$actionBuilderType] = [

          'id' =>

            $formID,

          'name' =>

            $formName,

          'title' =>

            $formTitle,

          'tbl_sys_form_ID' =>

            $formID,

          'tbl_sys_form_name' =>

            $formName,

          'tbl_sys_form_title' =>

            $formTitle,

        ];


      }


      /*
      |--------------------------------------------------------------------------
      | Formulários disponíveis
      |--------------------------------------------------------------------------
      |
      | Esta lista permite converter:
      |
      | nome do formulário
      |     ↓
      | ID numérico utilizado por AutomatorPaginationCreateModalForm()
      |
      |--------------------------------------------------------------------------
      */


      $availableForms = SysForm::query()
        ->select([

          'tbl_sys_form_ID',

          'tbl_sys_form_name',

          'tbl_sys_form_title',

        ])
        ->orderBy(

          'tbl_sys_form_title',

          'asc'

        )
        ->get()
        ->map(function($form) {


          $formID =

            (string) $form->tbl_sys_form_ID;


          $formName =

            (string) $form->tbl_sys_form_name;


          $formTitle =

            (string) $form->tbl_sys_form_title;


          return [

            'id' =>

              $formID,

            'name' =>

              $formName,

            'title' =>

              $formTitle,

            'tbl_sys_form_ID' =>

              $formID,

            'tbl_sys_form_name' =>

              $formName,

            'tbl_sys_form_title' =>

              $formTitle,

          ];


        })
        ->values()
        ->toArray();


      $paginationActionBuilder = [

        'forms' =>

          $actionBuilderForms,

        'availableForms' =>

          $availableForms,

        'available_forms' =>

          $availableForms,

      ];


      return [

        'userTypes' =>

          $userTypes,


        'user_types' =>

          $userTypes,


        'currentUser' => [

          'id' =>

            $currentUser->tbl_user_ID ??

            $currentUser->id ??

            null,


          'userTypeID' =>

            $currentUserTypeID !== null

              ? (string) $currentUserTypeID

              : null,


          'isDeveloper' =>

            mb_strtolower(

              trim(

                $currentUserTypeName

              )

            ) === 'desenvolvedor',

        ],


        'paginationActionBuilder' =>

          $paginationActionBuilder,


        'pagination_action_builder' =>

          $paginationActionBuilder,

      ];


    }


    // private function preparePaginationEditorSecurityData(): array {


    //   $userTypes = UsersType::query()
    //     ->orderBy(
    //       'tbl_users_type_ID',
    //       'asc'
    //     )
    //     ->get()
    //     ->map(function($userType) {


    //       $userTypeID =

    //         (string) $userType->tbl_users_type_ID;


    //       $userTypeName =

    //         (string) $userType->tbl_users_type_name;


    //       return [

    //         'id' =>

    //           $userTypeID,


    //         'name' =>

    //           $userTypeName,


    //         'tbl_users_type_ID' =>

    //           $userTypeID,


    //         'tbl_users_type_name' =>

    //           $userTypeName,


    //         'isDeveloper' =>

    //           mb_strtolower(

    //             trim(

    //               $userTypeName

    //             )

    //           ) === 'desenvolvedor',

    //       ];


    //     })
    //     ->values()
    //     ->toArray();


    //   $currentUser = Auth::user();


    //   $currentUserTypeID = null;

    //   $currentUserTypeName = '';


    //   if($currentUser !== null) {


    //     $currentUserTypeID =

    //       $currentUser->tbl_users_type_ID ??

    //       $currentUser->tbl_user_type_ID ??

    //       null;


    //     if($currentUserTypeID !== null) {


    //       $currentUserTypeName =

    //         (string) UsersType::where(

    //           'tbl_users_type_ID',

    //           $currentUserTypeID

    //         )->value(

    //           'tbl_users_type_name'

    //         );


    //     }


    //   }


    //   return [

    //     'userTypes' =>

    //       $userTypes,


    //     'user_types' =>

    //       $userTypes,


    //     'currentUser' => [

    //       'id' =>

    //         $currentUser->tbl_user_ID ??

    //         $currentUser->id ??

    //         null,


    //       'userTypeID' =>

    //         $currentUserTypeID !== null

    //           ? (string) $currentUserTypeID

    //           : null,


    //       'isDeveloper' =>

    //         mb_strtolower(

    //           trim(

    //             $currentUserTypeName

    //           )

    //         ) === 'desenvolvedor',

    //     ],

    //   ];


    // }



    /*
    |--------------------------------------------------------------------------
    | Normaliza uma definição simples de parâmetros de função
    |--------------------------------------------------------------------------
    |
    | Exemplos aceitos:
    |
    | { 'data': true }
    | { 'word': true, 'lang': false }
    |
    */

    private function normalizeSysFunctionDefinition(
      $definition
    ): array {


      if(
        $definition === null ||
        $definition === ''
      ) {

        return [];

      }


      if(is_object($definition)) {

        $definition = (array) $definition;

      }


      if(is_array($definition)) {

        return $definition;

      }


      if(!is_string($definition)) {

        return [];

      }


      $definition = trim(

        $definition

      );


      if($definition === '') {

        return [];

      }


      /*
      |--------------------------------------------------------------------------
      | JSON válido
      |--------------------------------------------------------------------------
      */

      $decodedDefinition = json_decode(

        $definition,

        true

      );


      if(
        json_last_error() === JSON_ERROR_NONE &&
        is_array($decodedDefinition)
      ) {

        return $decodedDefinition;

      }


      /*
      |--------------------------------------------------------------------------
      | Estrutura PHP/JavaScript simplificada utilizada pelo Seeder
      |--------------------------------------------------------------------------
      */

      $normalizedDefinition = [];


      preg_match_all(

        '/[\'"]([^\'"]+)[\'"]\s*:\s*([^,}]+)/',

        $definition,

        $definitionMatches,

        PREG_SET_ORDER

      );


      foreach($definitionMatches as $definitionMatch) {


        $definitionKey = trim(

          (string) (

            $definitionMatch[1]

            ?? ''

          )

        );


        $definitionValue = trim(

          (string) (

            $definitionMatch[2]

            ?? ''

          )

        );


        if($definitionKey === '') {

          continue;

        }


        if(
          strcasecmp(
            $definitionValue,
            'true'
          ) === 0
        ) {

          $normalizedDefinition[$definitionKey] = true;

          continue;

        }


        if(
          strcasecmp(
            $definitionValue,
            'false'
          ) === 0
        ) {

          $normalizedDefinition[$definitionKey] = false;

          continue;

        }


        if(
          strcasecmp(
            $definitionValue,
            'null'
          ) === 0
        ) {

          $normalizedDefinition[$definitionKey] = null;

          continue;

        }


        if(
          is_numeric(
            $definitionValue
          )
        ) {

          $normalizedDefinition[$definitionKey] =

            strpos(
              $definitionValue,
              '.'
            ) !== false

              ? (float) $definitionValue

              : (int) $definitionValue;


          continue;

        }


        $normalizedDefinition[$definitionKey] = trim(

          $definitionValue,

          " \t\n\r\0\x0B'\""

        );


      }


      return $normalizedDefinition;


    }


    /*
    |--------------------------------------------------------------------------
    | Normaliza opções retornadas pelas funções auxiliares
    |--------------------------------------------------------------------------
    */

    private function normalizeSysFunctionAutocompleteOptions(
      $options
    ): array {


      if(
        $options instanceof
        \Illuminate\Http\JsonResponse
      ) {

        $options = $options->getData(

          true

        );

      }


      if(
        $options instanceof
        \Illuminate\Support\Collection
      ) {

        $options = $options->toArray();

      }


      if(is_object($options)) {

        $options = (array) $options;

      }


      if(
        is_array($options) &&
        isset($options['data']) &&
        is_array($options['data'])
      ) {

        $options = $options['data'];

      }


      if(!is_array($options)) {

        return [];

      }


      $normalizedOptions = [];


      foreach($options as $optionKey => $optionValue) {


        if(is_object($optionValue)) {

          $optionValue = (array) $optionValue;

        }


        /*
        |--------------------------------------------------------------------------
        | Estrutura value/label
        |--------------------------------------------------------------------------
        */

        if(is_array($optionValue)) {


          $value =

            $optionValue['value']

            ?? $optionValue['id']

            ?? $optionValue['name']

            ?? $optionKey;


          $label =

            $optionValue['label']

            ?? $optionValue['title']

            ?? $optionValue['name']

            ?? $value;


        } else {


          /*
          |--------------------------------------------------------------------------
          | Lista simples ou array associativo
          |--------------------------------------------------------------------------
          */

          if(is_int($optionKey)) {

            $value = $optionValue;

            $label = $optionValue;

          } else {

            $value = $optionKey;

            $label = $optionValue;

          }


        }


        if(
          !is_scalar($value) ||
          !is_scalar($label)
        ) {

          continue;

        }


        $value = trim(

          (string) $value

        );


        $label = trim(

          (string) $label

        );


        if($value === '') {

          continue;

        }


        $normalizedOptions[] = [

          'value' => $value,

          'label' =>

            $label !== ''

              ? $label

              : $value,

        ];


      }


      return array_values(

        $normalizedOptions

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Executa uma função auxiliar registrada
    |--------------------------------------------------------------------------
    */

    private function executeSysFunctionAutocompleteProvider(
      $functionName
    ): array {


      $functionName = trim(

        (string) $functionName

      );


      if($functionName === '') {

        return [];

      }


      $providerFunction = SysFunction::where(

        'tbl_sys_function_name',

        $functionName

      )->first();


      if($providerFunction === null) {

        return [];

      }


      $providerMethod = trim(

        (string) (

          $providerFunction->tbl_sys_function_fn

          ?? ''

        )

      );


      if(
        $providerMethod === '' ||
        !method_exists(
          AutomatorController::class,
          $providerMethod
        )
      ) {

        return [];

      }


      try {


        $reflectionMethod = new \ReflectionMethod(

          AutomatorController::class,

          $providerMethod

        );


        if(
          $reflectionMethod->isPublic() !== true ||
          $reflectionMethod->isStatic() !== true ||
          $reflectionMethod->getNumberOfRequiredParameters() > 0
        ) {

          return [];

        }


        $providerResult = call_user_func(

          [

            AutomatorController::class,

            $providerMethod,

          ]

        );


        return $this->normalizeSysFunctionAutocompleteOptions(

          $providerResult

        );


      } catch(\Throwable $exception) {


        report(

          $exception

        );


        return [];


      }


    }


    /*
    |--------------------------------------------------------------------------
    | Extrai as funções auxiliares configuradas em props
    |--------------------------------------------------------------------------
    |
    | Exemplo:
    |
    | { 'data': @SysFunctions['sysGetRouteDataInfo'] }
    |
    */

    private function getSysFunctionAutocompletePropertyProviders(
      $props
    ): array {


      if(
        $props === null ||
        $props === ''
      ) {

        return [];

      }


      if(!is_string($props)) {

        return [];

      }


      $providers = [];


      preg_match_all(

        '/[\'"]([^\'"]+)[\'"]\s*:\s*@SysFunctions\s*\[\s*[\'"]([^\'"]+)[\'"]\s*\]/i',

        $props,

        $providerMatches,

        PREG_SET_ORDER

      );


      foreach($providerMatches as $providerMatch) {


        $propertyName = trim(

          (string) (

            $providerMatch[1]

            ?? ''

          )

        );


        $providerName = trim(

          (string) (

            $providerMatch[2]

            ?? ''

          )

        );


        if(
          $propertyName === '' ||
          $providerName === ''
        ) {

          continue;

        }


        $providers[$propertyName] =

          $providerName;


      }


      return $providers;


    }


    /*
    |--------------------------------------------------------------------------
    | Monta a sintaxe sugerida para uma função
    |--------------------------------------------------------------------------
    */

    private function buildSysFunctionAutocompleteSyntax(
      $functionName,
      array $params = []
    ): string {


      $functionName = trim(

        (string) $functionName

      );


      if($functionName === '') {

        return '';

      }


      if(count($params) <= 0) {

        return (

          "@SysFunctions('" .

          str_replace(

            "'",

            "\\'",

            $functionName

          ) .

          "')"

        );

      }


      $paramsSyntax = [];


      foreach($params as $paramName => $paramRequired) {


        $paramName = trim(

          (string) $paramName

        );


        if($paramName === '') {

          continue;

        }


        $paramsSyntax[] =

          "'" .

          str_replace(

            "'",

            "\\'",

            $paramName

          ) .

          "' => ''";


      }


      return (

        "@SysFunctions('" .

        str_replace(

          "'",

          "\\'",

          $functionName

        ) .

        "', [" .

        implode(

          ', ',

          $paramsSyntax

        ) .

        "])"

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Retorna as funções internas disponíveis para autocomplete
    |--------------------------------------------------------------------------
    */

    private function getSysFunctionsAutocomplete(
      Request $request
    ) {


      if(!Auth::check()) {

        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'message'         => SysAutomator::SysAutomatorGetTranslateWord(
            'Sua sessão expirou. Faça o login novamente para continuar.'
          ),
          'data'            => [],

        ], 401);

      }


      $functions = SysFunction::query()
        ->orderBy(
          'tbl_sys_function_name',
          'asc'
        )
        ->get();


      $responseFunctions = [];


      foreach($functions as $function) {


        $functionName = trim(

          (string) (

            $function->tbl_sys_function_name

            ?? ''

          )

        );


        if($functionName === '') {

          continue;

        }


        $functionParams =

          $this->normalizeSysFunctionDefinition(

            $function->tbl_sys_function_params

            ?? ''

          );


        $propertyProviders =

          $this->getSysFunctionAutocompletePropertyProviders(

            $function->tbl_sys_function_props

            ?? ''

          );


        $normalizedParams = [];


        foreach($functionParams as $paramName => $paramRequired) {


          $paramName = trim(

            (string) $paramName

          );


          if($paramName === '') {

            continue;

          }


          $providerName = trim(

            (string) (

              $propertyProviders[$paramName]

              ?? ''

            )

          );


          $normalizedParams[] = [

            'name' => $paramName,

            'required' => in_array(

              $paramRequired,

              [

                true,
                1,
                '1',
                'true',
                'TRUE',
                'required',

              ],

              true

            ),

            'provider' => $providerName,

            'options' =>

              $providerName !== ''

                ? $this->executeSysFunctionAutocompleteProvider(

                    $providerName

                  )

                : [],

          ];


        }


        $responseFunctions[] = [

          'id' =>

            $function->tbl_sys_function_ID

            ?? null,

          'type' =>

            (string) (

              $function->tbl_sys_function_type

              ?? ''

            ),

          'name' => $functionName,

          'method' =>

            (string) (

              $function->tbl_sys_function_fn

              ?? ''

            ),

          'syntax' =>

            $this->buildSysFunctionAutocompleteSyntax(

              $functionName,

              $functionParams

            ),

          'params' =>

            $normalizedParams,

        ];


      }


      return response()->json([

        'status'    => true,
        'message'   => SysAutomator::SysAutomatorGetTranslateWord(
          'Funções internas carregadas com sucesso.'
        ),
        'trigger'   => '@SysFunctions',
        'functions' => $responseFunctions,
        'data'      => $responseFunctions,

      ]);


    }



    public function configs(Request $request) {

      $slug = $request->route('pageSlug');

      $configs = SysConfig::get()->toArray();

      return SysAutomator::SysAutomatoRenderRouteContent($slug, ['configs' => $configs], 'restrict');

    }



    // private function createMenu() {
      
    //   $sidebar = [

    //       [

    //         'tbl_sys_menu_ID'             => 1,
    //         'tbl_sys_menu_item_index'     => '',
    //         'tbl_sys_menu_item_icon'      => 'copy',
    //         'tbl_sys_menu_item_class'     => 'sidebar-link',
    //         'tbl_sys_menu_item_title'     => 'Posts',
    //         'tbl_sys_menu_item_type'      => 'button',
    //         'tbl_sys_menu_item_link'      => '',
    //         'tbl_sys_menu_item_props'     => json_encode([
    //             'data-sidebar-title' => 'Posts'
    //         ]),
    //         'tbl_sys_menu_item_status'    => 'ativo',
    //         'tbl_sys_menu_item_parent_id' => 0,
    //         'tbl_sys_menu_item_locked'    => false,
    //         'tbl_sys_menu_item_admin'     => true,
    //         'tbl_sys_menu_item_ordem'     => 7,
    //         'user_rules'                  => [1],
    //         'user_types'                  => [1, 2],

    //       ],

    //       [

    //         'tbl_sys_menu_ID'             => 1,
    //         'tbl_sys_menu_item_index'     => '',
    //         'tbl_sys_menu_item_icon'      => '',
    //         'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
    //         'tbl_sys_menu_item_title'     => 'Categorias',
    //         'tbl_sys_menu_item_type'      => 'route',

    //         // CORRIGIDO
    //         'tbl_sys_route_ID'            => 'admin-post-categories',

    //         'tbl_sys_menu_item_link'      => '',
    //         'tbl_sys_menu_item_props'     => '',
    //         // 'tbl_sys_menu_item_parent_id' => DB::table('tbl_sys_routes')->where('tbl_sys_route_title', 'Posts')->value('tbl_sys_route_ID'),
    //         'tbl_sys_menu_item_parent_id' => 31,
    //         'tbl_sys_menu_item_status'    => 'ativo',
    //         'tbl_sys_menu_item_locked'    => false,
    //         'tbl_sys_menu_item_admin'     => true,
    //         'tbl_sys_menu_item_ordem'     => 1,
    //         'user_rules'                  => [1],
    //         'user_types'                  => [1, 2]

    //     ],

    //     [

    //         'tbl_sys_menu_ID'             => 1,
    //         'tbl_sys_menu_item_index'     => '',
    //         'tbl_sys_menu_item_icon'      => '',
    //         'tbl_sys_menu_item_class'     => 'sidebar-submenu-link',
    //         'tbl_sys_menu_item_title'     => 'Posts',
    //         'tbl_sys_menu_item_type'      => 'route',
    //         'tbl_sys_route_ID'            => 'admin-post',
    //         'tbl_sys_menu_item_link'      => '',
    //         'tbl_sys_menu_item_props'     => '',
    //         'tbl_sys_menu_item_parent_id' => 31,
    //         'tbl_sys_menu_item_status'    => 'ativo',
    //         'tbl_sys_menu_item_locked'    => false,
    //         'tbl_sys_menu_item_admin'     => true,
    //         'tbl_sys_menu_item_ordem'     => 2,
    //         'user_rules'                  => [1],
    //         'user_types'                  => [1, 2]

    //     ]

    //   ];


    //   foreach ($sidebar as $item) {


    //       $usersRules = $item['user_rules'];
    //       $usersTypes = $item['user_types'];


    //       unset($item['user_rules']);
    //       unset($item['user_types']);

    //       if(isset($item['tbl_sys_route_ID'])) {

    //         $routeID = DB::table('tbl_sys_routes')->where('tbl_sys_route_name', $item['tbl_sys_route_ID'])->value('tbl_sys_route_ID');

    //       } else {

    //         $routeID = null;
    //       }

    //       $item['tbl_sys_route_ID'] = $routeID;



    //       /*
    //       |--------------------------------------------------------------------------
    //       | Criar item principal do menu
    //       |--------------------------------------------------------------------------
    //       */

    //       $sideItemID = DB::table('tbl_sys_menus_items')
    //           ->insertGetId($item);



    //       echo $sideItemID . ' = [<br />';
          
    //       /*
    //       |--------------------------------------------------------------------------
    //       | Permissões por tipo de usuário
    //       |--------------------------------------------------------------------------
    //       */

    //       foreach ($usersTypes as $userTypeID) {


    //           $userTypesID = DB::table('tbl_sys_menus_item_access')
    //               ->insertGetId([

    //                   'tbl_users_type_ID'    => $userTypeID,
    //                   'tbl_sys_menu_item_ID' => $sideItemID,

    //               ]);

    //           echo $userTypesID . '<br />';


    //       }
    //       echo '<br />]';


    //       /*
    //       |--------------------------------------------------------------------------
    //       | Regras de acesso
    //       |--------------------------------------------------------------------------
    //       */

    //       foreach ($usersRules as $userRuleID) {


    //           DB::table('tbl_sys_menus_item_access')
    //               ->insert([

    //                   'tbl_users_type_ID'    => $userRuleID,
    //                   'tbl_sys_menu_item_ID' => $sideItemID,

    //               ]);


    //       }


    //   }
    //   // foreach ($sidebar as $item) {

    //   //   $users_rules = $item['user_rules'];
    //   //   $users_types = $item['user_types'];
    //   //   $submenus    = $item['submenus'];
    //   //   unset($item['user_rules']);
    //   //   unset($item['user_types']);
    //   //   unset($item['submenus']);
        
    //   //   $sideItem = SysMenusItem::create($item);

    //   //   $sideItemID = $sideItem->getKey();

    //   //   foreach ($users_types as $userTypeID) {

    //   //     SysMenusItemsAccess::create([

    //   //       'tbl_users_type_ID'     => $userTypeID,
    //   //       'tbl_sys_menu_item_ID'  => $sideItemID,

    //   //     ]);
          
    //   //   }


    //   //   foreach ($users_rules as $userRuleID) {

    //   //     SysMenusItemAccess::create([

    //   //       'tbl_users_type_ID'     => $userRuleID,
    //   //       'tbl_sys_menu_item_ID'  => $sideItemID,

    //   //     ]);
          
    //   //   }


    //   //   foreach ($submenus as $submenu) {
          
    //   //     $SUBusers_rules = $submenu['user_rules'];
    //   //     $SUBusers_types = $submenu['user_types'];
    //   //     unset($submenu['user_rules']);
    //   //     unset($submenu['user_types']);

    //   //     $submenu['tbl_sys_menu_item_parent_id'] = $sideItemID;
          
    //   //     $SUBsideItem = SysMenusItem::create($submenu);

    //   //     $SUBsideItemID = $SUBsideItem->getKey();

    //   //     foreach ($SUBusers_types as $SUBuserTypeID) {

    //   //       SysMenusItemsAccess::create([

    //   //         'tbl_users_type_ID'     => $SUBuserTypeID,
    //   //         'tbl_sys_menu_item_ID'  => $SUBsideItemID,

    //   //       ]);
            
    //   //     }


    //   //     foreach ($SUBusers_rules as $SUBuserRuleID) {

    //   //       SysMenusItemAccess::create([

    //   //         'tbl_users_type_ID'     => $SUBuserRuleID,
    //   //         'tbl_sys_menu_item_ID'  => $SUBsideItemID,

    //   //       ]);
            
    //   //     }

    //   //   }

    //   // }


    // }


  }

