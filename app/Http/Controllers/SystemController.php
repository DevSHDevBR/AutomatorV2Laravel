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

  use App\Helpers\SysAutomator;
  use App\Models\SysRoute;
  use App\Models\SysForm;
  use App\Models\SysFormsAccess;
  use App\Models\User;



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
      // return view('layouts.painel-public', [

      //   'contentView' => 'system.login',
      //   'contentData' => [],
      //   'title'       => $route['tbl_sys_route_title'],
      //   'page'        => $route['tbl_sys_route_name']
        
      // ]);


    }




    public function loginAPI(Request $request) {


      $request->validate([

        'login'    => ['required', 'string'],
        'password' => ['required', 'string'],

      ], [

        'login.required'    => SysAutomator::SysAutomatorGetTranslateWord('Informe seu login.'),
        'password.required' => SysAutomator::SysAutomatorGetTranslateWord('Informe sua senha.'),

      ]);


      $login    = $request->input('login');
      $password = $request->input('password');

      $user = User::where('tbl_user_login', $login)->orWhere('tbl_user_email', $login)->first();

      if (!$user) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

        ], 401);

      }

      if (!Hash::check($password, $user->tbl_user_password)) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

        ], 401);

      }

      if ($user->tbl_user_status != 'ativo') {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário não está ativo.'),

        ], 403);

      }

      if ((bool) $user->tbl_user_blocked === true) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário está bloqueado.'),

        ], 403);

      }

      if ((bool) $user->tbl_user_actived !== true) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário ainda não foi ativado.'),

        ], 403);

      }

      Auth::guard('web')->login($user, $request->boolean('remember'));

      $request->session()->regenerate();

      $request->session()->save();

      return response()->json([

        'status'       => true,
        'auth_check'   => Auth::guard('web')->check(),
        'user_id'      => Auth::guard('web')->id(),
        'message'      => SysAutomator::SysAutomatorGetTranslateWord('Login realizado com sucesso.'),
        'redirect_url' => url('/' . trim(SysAutomator::SysAutomatorGetConfigValue('system-admin', 'admin'), '/')),

      ]);


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


      $acao = $request->input('acao');


      if($acao == 'validar-senha') {

        if(Auth::check()) {

          $user = Auth::user();

          if (!$user) {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

            ], 401);

          }


          $password = $request->input('password');


          if (!Hash::check($password, $user->tbl_user_password)) {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord('Login ou senha inválidos.'),

            ], 401);

          }


          if ($user->tbl_user_status != 'ativo') {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário não está ativo.'),

            ], 403);

          }

          if ((bool) $user->tbl_user_blocked === true) {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário está bloqueado.'),

            ], 403);

          }

          if ((bool) $user->tbl_user_actived !== true) {

            return response()->json([

              'status'  => false,
              'title'   => 'Validação inválida',
              'message' => SysAutomator::SysAutomatorGetTranslateWord('Este usuário ainda não foi ativado.'),

            ], 403);

          }

          return response()->json([

            'status'  => true,
            'title'   => 'Validação realizada',
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Credenciais validadas com sucesso.'),

          ]);

        } else {

          return response()->json([

            'status'  => false,
            'title'   => 'Validação inválida',
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Solicitação inválida!'),

          ], 401);
        
        }

      } elseif($acao == 'get-database-data') {

        return $this->getDatabaseDataForAdminFunctions($request);

      } elseif($acao == 'render-pagination') {

      } elseif($acao == 'render-form') {

      }


    }
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
    //   } elseif($acao == 'render-pagination') {
    //   } elseif($acao == 'render-form') {

    //   }


    // }


    private function getDatabaseDataForAdminFunctions(Request $request) {


      if(!Auth::check()) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Sessão expirada ou usuário não autenticado.'),
          'data'    => [],

        ], 401);

      }


      $dataType = trim((string) $request->input('data-type', ''));


      if($dataType == 'get-tables') {

        try {

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

          return response()->json([

            'status'   => true,
            'message'  => SysAutomator::SysAutomatorGetTranslateWord('Tabelas carregadas com sucesso.'),
            'data'     => $tables,
            'database' => $databaseName,

          ]);

        } catch(\Throwable $e) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Falha ao carregar tabelas do banco de dados.'),
            'data'    => [],

          ], 500);

        }

      }


      if($dataType == 'get-table-columns') {

        $tableName = trim((string) $request->input('table-name', $request->input('table_name', '')));

        if($tableName == '' || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Tabela inválida.'),
            'data'    => [],

          ], 400);

        }

        if(!Schema::hasTable($tableName)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Tabela não encontrada.'),
            'data'    => [],

          ], 404);

        }

        try {

          $columns = Schema::getColumnListing($tableName);

          $data = [];

          foreach($columns as $column) {

            $data[] = [
              'value' => $column,
              'label' => $column,
            ];

          }

          return response()->json([

            'status'  => true,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Colunas carregadas com sucesso.'),
            'table'   => $tableName,
            'data'    => $data,

          ]);

        } catch(\Throwable $e) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Falha ao carregar colunas da tabela.'),
            'data'    => [],

          ], 500);

        }

      }


      if($dataType == 'get-table-options') {

        $tableName   = trim((string) $request->input('table-name', $request->input('table_name', '')));
        $valueColumn = trim((string) $request->input('value-column', $request->input('value_column', '')));
        $labelColumn = trim((string) $request->input('label-column', $request->input('label_column', '')));

        if($tableName == '' || !preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Tabela inválida.'),
            'data'    => [],

          ], 400);

        }

        if($valueColumn == '' || !preg_match('/^[a-zA-Z0-9_]+$/', $valueColumn)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Campo destino inválido.'),
            'data'    => [],

          ], 400);

        }

        if($labelColumn == '' || !preg_match('/^[a-zA-Z0-9_]+$/', $labelColumn)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Label destino inválido.'),
            'data'    => [],

          ], 400);

        }

        if(!Schema::hasTable($tableName)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Tabela não encontrada.'),
            'data'    => [],

          ], 404);

        }

        if(!Schema::hasColumn($tableName, $valueColumn) || !Schema::hasColumn($tableName, $labelColumn)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Coluna inválida.'),
            'data'    => [],

          ], 400);

        }

        try {

          $rows = DB::table($tableName)
            ->select($valueColumn, $labelColumn)
            ->orderBy($labelColumn, 'asc')
            ->get();

          $data = [];

          foreach($rows as $row) {

            $row = (array) $row;

            $value = $row[$valueColumn] ?? '';
            $label = $row[$labelColumn] ?? $value;

            if((string) $value === '') {
              continue;
            }

            $data[] = [
              'value' => $value,
              'label' => $label,
            ];

          }

          return response()->json([

            'status'       => true,
            'message'      => SysAutomator::SysAutomatorGetTranslateWord('Opções carregadas com sucesso.'),
            'table'        => $tableName,
            'value_column' => $valueColumn,
            'label_column' => $labelColumn,
            'data'         => $data,

          ]);

        } catch(\Throwable $e) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Falha ao carregar opções da tabela.'),
            'data'    => [],

          ], 500);

        }

      }


      return response()->json([

        'status'  => false,
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Tipo de dados inválido.'),
        'data'    => [],

      ], 400);


    }

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


      return SysAutomator::SysAutomatoRenderRouteContent($slug, [], 'restrict');

      // $routeName = str_replace('page-', '', $slug);


      // $route = SysRoute::where('tbl_sys_route_name', $routeName)->first()->toArray();

      // $content = SysAutomator::SysAutomatorRenderSystemPageShortcode(
      //   $route['tbl_sys_route_content'],
      //   [
      //     'title' => $route['tbl_sys_route_title'],
      //     'pageName' => $route['tbl_sys_route_name']
      //   ],
      //   'pages.404'
      // );

      // return view('layouts.painel-restrict', [

      //   'content' => $content,
      //   'title'   => $route['tbl_sys_route_title'],
      //   'page'    => $route['tbl_sys_route_name'],

      // ]);
      // dd($route['tbl_sys_route_content']);
      
      // return view('layouts.painel-restrict', [

      //   'contentView' => '',
      //   'contentData' => [],
      //   'title'       => $route['tbl_sys_route_title'],
      //   'page'        => $route['tbl_sys_route_name']
        
      // ]);

      

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

              if(strlen($name) >= 8) {

                if(strlen($name) <= 255) {

                  if(isset($email) && $email != '') {

                    if(strlen($email) >= 12) {

                      if(strlen($email) <= 255) {

                        $continuar = true;
                        if($email != $_user->tbl_user_email) {

                          $continuar = false;
                          $search = User::where('tbl_user_email', $email)->first();
                          if(count($search) <= 0) {

                            $continuar = true;

                          } else {

                            $retorno['message'] = SysAutomator::SysAutomatorGetTranslateWord("O valor informado no campo 'E-mail' ja está sendo utilizado por outro usuário!");

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
                  'value'    => '',
                  'required' => false

                ],
                'automator-editor-method' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_route_method',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Method'),
                  'value'    => '',
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
                  'value'    => 'POST',
                  'required' => true,
                  'options'  => [

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
                  'required' => true

                ],

                'tbl_sys_form_cancel' => [

                  'type'     => 'text',
                  'name'     => 'tbl_sys_form_cancel',
                  'class'    => 'form-floating mb-3',
                  'label'    => SysAutomator::SysAutomatorGetTranslateWord('Texto do botão cancelar'),
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




  }

