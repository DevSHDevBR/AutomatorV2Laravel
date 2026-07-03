<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\Hash;

  use App\Helpers\SysAutomator;
  use App\Models\SysRoute;
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
      } elseif($acao == 'render-pagination') {
      } elseif($acao == 'render-form') {

      }


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
      |
      | Tudo que vier no payload além de "view" fica disponível
      | como variáveis dentro da blade renderizada.
      |
      */

      $data = $request->except('view');


      /*
      |--------------------------------------------------------------------------
      | Mapeia as views disponíveis
      |--------------------------------------------------------------------------
      |
      | Cada chave corresponde ao valor de "view" enviado no payload pelo JS.
      | O valor é um array com:
      |   'view'    => caminho da blade (resources/views/...)
      |   'title'   => título do modal
      |   'footer'  => HTML do footer (null = sem footer)
      |
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

        $modal = [
          
          'title' => SysAutomator::SysAutomatorGetTranslateWord('Nova Página')

        ];


        $dados = [

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

                ]

              ]

            ]

          ]

        ];


        $page = [];

        if(isset($data['pageID'])) {

          $page = SysRoute::where('tbl_sys_route_ID', $data['pageID'])->first()->toArray();

          $modal['title'] = SysAutomator::SysAutomatorGetTranslateWord('Editar Página');

          $dados['header']['content']['value']                                           = $page['tbl_sys_route_title'];
          $dados['configs']['page-settings']['fields']['automator-editor-slug']['value'] = $page['tbl_sys_route_name'];

        }



        $blocks = [];

        $grupos = SysAutomator::SysAutomatorRenderPageBuilderFields();
        foreach($grupos as $grupo) {

          foreach($grupo['tbl_sys_field_type_group_fields'] as $field) {

            $blocks[] = SysAutomator::SysAutomatorRenderPageBuilderField($field);

          }

        }


        $views['system-page-editor'] = [

          'view'    => 'system.modals.system-page-editor',
          'title'   => $modal['title'],
          'acao'    => ( (isset($data['pageID'])) ? 'update' : 'store' ),
          'dados'   => [
            'page'    => $page,
            'blocks'  => $blocks,
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

      $content = view($viewConfig['view'], $dados)->render();

      $footer  = ($viewConfig['footer'] !== null)
        ? view($viewConfig['footer'], $data)->render()
        : null;


      return response()->json([

        'status'  => true,
        'title'   => $viewConfig['title'],
        'content' => $content,
        'acao'    => ( (isset($viewConfig['acao'])) ? $viewConfig['acao'] : '' ),
        'dados'   => ( (isset($viewConfig['dados'])) ? $viewConfig['dados'] : [] ),
        'classes' => [
          'modal-body' => ( (isset($viewConfig['classes']['modal-body'])) ? $viewConfig['classes']['modal-body'] : '' ),
        ],
        'footer'  => $footer,

      ], 200);


    }




  }

