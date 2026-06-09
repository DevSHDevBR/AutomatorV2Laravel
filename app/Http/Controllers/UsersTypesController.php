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
  use App\Models\UsersType;
  use App\Models\User;



  class UsersTypesController extends Controller {


    protected $FormName = 'admin-users-types';

    public function index(Request $request) {


      $slug = $request->route('pageSlug');


      $params = [

        'page_name'     => '@replace(route["tbl_sys_route_name"])',
        'table'         => 'tbl_users_types',
        'index'         => 'tbl_users_type_ID',
        'per_page'      => 15,
        'actions'       => [

          'get' => [

            'route'  => 'admin-users-types-get',
            'params' => ['id' => "#ID#"],
            'show'   => true,

          ],
          'add' => [

            'route'  => 'admin-users-types-store',
            'params' => [],
            'show'   => true,

          ],
          'edit' => [

            'route'  => 'admin-users-types-update',
            'params' => [],
            'show'   => true,

          ],
          'delete' => [

            'route'  => 'admin-users-types-delete',
            'params' => [],
            'show'   => false,
            'roles'  => [

              [

                'key'     => 'tbl_users_type_locked',
                'compare' => '==',
                'value'   => false
              
              ]

            ]
          
          ]

        ],
        'search_fields' => [

          'tbl_users_type_ID'   => 'ID',
          'tbl_users_type_name' => 'Nome'
        
        ],
        'header_actions' => [

          [

            'type'    => 'button',
            'action'  => 'add',
            'id'      => 'btn-add-user-type',
            'class'   => 'btn btn-success',
            'icon'    => 'plus',
            'text'    => 'Novo Tipo de usuário',
            'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName($this->FormName) . ");",

          ]

        ],
        'list_actions' => [

          [

            'type'    => 'button',
            'action'  => 'edit',
            'id'      => 'btn-edit',
            'class'   => 'btn-primary',
            'icon'    => 'pencil',
            'text'    => 'Editar Tipo de usuário',
            'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName($this->FormName) . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'PUT', action: 'edit' }]); });",
            // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName($this->FormName) . ", 'get', {id});",

          ],
          [

            'type'    => 'button',
            'action'  => 'delete',
            'id'      => 'btn-delete',
            'class'   => 'btn-danger',
            'icon'    => 'trash',
            'text'    => 'Excluir Tipo de usuário',
            'onclick' => '',

          ]

        ],
        'columns'   => [

          'tbl_users_type_ID'     => [

            'type'     => 'int',
            'label'    => 'ID',
            'sortable' => true,
            'header'   => ['class' => 'text-center'],
            'body'     => ['class' => 'text-center'],

          ],
          'tbl_users_type_name' => [
            'type'     => 'text',
            'label'    => 'Nome',
            'sortable' => true
          ],
          'tbl_users_type_status' => [
            'type'     => 'text',
            'label'    => 'Status',
            'sortable' => false,
            'header'   => ['class' => 'text-center'],
            'body'     => ['class' => 'text-center'],
            'replaced' => [

              'ativo'   => '<span class="badge text-bg-success">Ativo</span>',
              'inativo' => '<span class="badge text-bg-danger">Inativo</span>'
            
            ]
          ]

        ]

      ];

      $data = SysAutomator::SysAutomatorPaginationData($params, $request);

      return SysAutomator::SysAutomatoRenderRouteContent($slug, $data);

    }



    public function getUserType(Request $request, $id) {


      /*
      |--------------------------------------------------------------------------
      | Valida ID
      |--------------------------------------------------------------------------
      */

      if($id === null || $id === '' || $id == 0) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('ID do tipo de usuário inválido.'),
          'data'    => [],

        ], 400);

      }



      /*
      |--------------------------------------------------------------------------
      | Busca tipo de usuário
      |--------------------------------------------------------------------------
      */

      $userType = UsersType::where('tbl_users_type_ID', $id)->first();


      if($userType === null) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Tipo de usuário não encontrado.'),
          'data'    => [],

        ], 404);

      }



      /*
      |--------------------------------------------------------------------------
      | Monta dados compatíveis com preenchimento do formulário via AJAX
      |--------------------------------------------------------------------------
      |
      | As chaves precisam bater exatamente com os names dos campos cadastrados
      | no formulário admin-users-types.
      |
      */

      $data = [

        'tbl_users_type_ID'          => $userType->tbl_users_type_ID,
        'tbl_users_type_name'        => $userType->tbl_users_type_name,
        'tbl_users_type_description' => $userType->tbl_users_type_description,
        'tbl_users_type_locked'      => $userType->tbl_users_type_locked,
        'tbl_users_type_status'      => $userType->tbl_users_type_status,
        'tbl_sys_route_ID'           => $userType->UsersTypeGetRoutes()->pluck('tbl_sys_routes.tbl_sys_route_ID')->map(function($routeID) {

          return (string) $routeID;

        })->toArray(),

      ];



      /*
      |--------------------------------------------------------------------------
      | Normaliza valores booleanos para campos select
      |--------------------------------------------------------------------------
      |
      | No seeder, o campo tbl_users_type_locked usa opções:
      | true : Sim
      | false: Não
      |
      | Então o valor precisa retornar como string "true" ou "false" para o JS
      | selecionar corretamente o option correspondente.
      |
      */

      if($data['tbl_users_type_locked'] === true || $data['tbl_users_type_locked'] === 1 || $data['tbl_users_type_locked'] === '1') {

        $data['tbl_users_type_locked'] = 'true';

      } else {

        $data['tbl_users_type_locked'] = 'false';

      }



      /*
      |--------------------------------------------------------------------------
      | Retorno final
      |--------------------------------------------------------------------------
      */

      return response()->json([

        'status'  => true,
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Tipo de usuário encontrado.'),
        'data'    => $data,

      ], 200);


    }



    public function getUserTypeAccess(Request $request, $id) {


      /*
      |--------------------------------------------------------------------------
      | Valida ID
      |--------------------------------------------------------------------------
      */

      if($id === null || $id === '' || $id == 0) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('ID do tipo de usuário inválido.'),
          'data'    => [],

        ], 400);

      }


      /*
      |--------------------------------------------------------------------------
      | Busca tipo de usuário
      |--------------------------------------------------------------------------
      */

      $userType = UsersType::where('tbl_users_type_ID', $id)->first();


      if($userType === null) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Tipo de usuário não encontrado.'),
          'data'    => [],

        ], 404);

      }



      /*
      |--------------------------------------------------------------------------
      | Monta dados compatíveis com preenchimento do formulário via AJAX
      |--------------------------------------------------------------------------
      |
      | As chaves precisam bater exatamente com os names dos campos cadastrados
      | no formulário admin-users-types.
      |
      */

      $data = [

        'tbl_users_type_ID'          => $userType->tbl_users_type_ID,
        'tbl_users_type_name'        => $userType->tbl_users_type_name,

      ];


      $userType = UsersType::find($id);

      $routes = $userType->UsersTypeGetRoutes()->get()->toArray();

      $rotas = [];

      if(count($routes) >= 1) {

        foreach ($routes as $route) {
          $rotas[] = (string) $route['tbl_sys_route_ID'];
        }

      }


      $data['tbl_sys_route_ID'] = $rotas;


      return response()->json([

        'status'  => true,
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Tipo de usuário encontrado.'),
        'data'    => $data,

      ], 200);

      // $userType = UsersType::find($id);

      // $routes = $userType->UsersTypeGetRoutes()->get()->toArray();

      // $rotas = [];

      // if(count($routes) >= 1) {

      // }


      // $data['tbl_sys_route_ID'] = $rotas;


    }



  }
