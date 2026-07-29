<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Support\Facades\Schema;

  use App\Helpers\SysAutomator;
  use App\Models\SysRoutesAccess;
  use App\Models\SysRoute;
  use App\Models\UsersType;



  class RoutesController extends Controller {



    public function getRouteAccess(Request $request, $id) {


      /*
      |--------------------------------------------------------------------------
      | Valida ID
      |--------------------------------------------------------------------------
      */

      if($id === null || $id === '' || $id == 0) {

        return response()->json([

          'status'  => false,
          'title'   => 'ERRO',
          'message' => SysAutomator::SysAutomatorGetTranslateWord('ID da Página/Rota inválida.'),
          'data'    => [],

        ], 400);

      }


      /*
      |--------------------------------------------------------------------------
      | Busca a rota pelo ID
      |--------------------------------------------------------------------------
      */

      $route = SysRoute::where('tbl_sys_route_ID', $id)->first();

      if($route === null) {

        return response()->json([

          'status'  => false,
          'title'   => 'ERRO',
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Página/Rota não encontrada.'),
          'data'    => [],

        ], 404);

      }


      /*
      |--------------------------------------------------------------------------
      | Monta dados compatíveis com preenchimento do formulário via AJAX
      |--------------------------------------------------------------------------
      |
      | As chaves precisam bater exatamente com os names dos campos cadastrados
      | no formulário admin-routes-apis-access.
      |
      */

      $data = [

        'tbl_sys_route_ID'    => $route->tbl_sys_route_ID,
        'tbl_sys_route_title' => $route->tbl_sys_route_title,

      ];


      /*
      |--------------------------------------------------------------------------
      | Busca os tipos de usuário vinculados a esta rota
      |--------------------------------------------------------------------------
      |
      | Usa o relacionamento belongsToMany definido em SysRoute::SysRouteGetUsersTypes()
      | e retorna os IDs como array de strings, assim como getUserType() faz
      | com tbl_sys_route_ID no UsersTypesController.
      |
      */

      $data['tbl_users_type_ID'] = $route->SysRouteGetUsersTypes()
        ->pluck('tbl_users_types.tbl_users_type_ID')
        ->map(function($usersTypeID) {

          return (string) $usersTypeID;

        })->toArray();


      return response()->json([

        'status'  => true,
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Página/Rota encontrada.'),
        'data'    => $data,

      ], 200);


    }



    public function storeRoute(Request $request) {

      $payload = $this->prepareRouteEditorPayload($request);

      $validation = $this->validateRouteEditorPayload($payload);

      if($validation['result'] == false) {
        return response()->json($validation);
      }

      $route = new SysRoute();

      $this->assignRouteEditorPayload($route, $payload);

      $route->save();

      return response()->json([

        'status'  => true,
        'result'  => true,
        'title'   => SysAutomator::SysAutomatorGetTranslateWord('Página criada'),
        'message' => SysAutomator::SysAutomatorGetTranslateWord('A página foi criada com sucesso.'),
        'data'    => [
          'id' => $route->tbl_sys_route_ID,
        ],

      ]);

    }



    public function updateRoute(Request $request, $id = null) {


      /*
      |--------------------------------------------------------------------------
      | Resolve o ID real da página
      |--------------------------------------------------------------------------
      |
      | As rotas dinâmicas registram parâmetros internos como pageSlug e
      | sysRouteName. Dependendo da forma como o Laravel injeta os parâmetros
      | no método do controller, o argumento $id pode receber um desses valores.
      |
      | Por esse motivo, o ID enviado explicitamente pelo formulário deve ter
      | prioridade sobre o argumento recebido no método.
      |
      */

      $routeID = $this->resolveRouteEditorID(
        $request,
        $id
      );


      /*
      |--------------------------------------------------------------------------
      | Valida o ID
      |--------------------------------------------------------------------------
      */

      if($routeID === null) {

        return response()->json([

          'status'  => false,
          'result'  => false,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord(
            'Página inválida'
          ),
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'ID da página não informado ou inválido.'
          ),

        ]);

      }


      /*
      |--------------------------------------------------------------------------
      | Localiza a página
      |--------------------------------------------------------------------------
      */

      $route = SysRoute::where(
        'tbl_sys_route_ID',
        $routeID
      )->first();


      if($route === null) {

        return response()->json([

          'status'  => false,
          'result'  => false,
          'id'      => $routeID,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord(
            'Página não encontrada'
          ),
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'A página que você está tentando editar não foi encontrada.'
          ),

        ]);

      }


      /*
      |--------------------------------------------------------------------------
      | Prepara os dados recebidos
      |--------------------------------------------------------------------------
      */

      $payload = $this->prepareRouteEditorPayload(
        $request,
        $route
      );


      /*
      |--------------------------------------------------------------------------
      | Valida os dados
      |--------------------------------------------------------------------------
      */

      $validation = $this->validateRouteEditorPayload(
        $payload,
        $route->tbl_sys_route_ID
      );


      if(
        !isset($validation['result']) ||
        $validation['result'] == false
      ) {

        return response()->json(
          $validation
        );

      }


      /*
      |--------------------------------------------------------------------------
      | Atualiza a página
      |--------------------------------------------------------------------------
      */

      $this->assignRouteEditorPayload(
        $route,
        $payload
      );


      $route->save();


      /*
      |--------------------------------------------------------------------------
      | Retorno
      |--------------------------------------------------------------------------
      */

      return response()->json([

        'status'  => true,
        'result'  => true,
        'title'   => SysAutomator::SysAutomatorGetTranslateWord(
          'Página atualizada'
        ),
        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'A página foi atualizada com sucesso.'
        ),
        'data'    => [

          'id' => $route->tbl_sys_route_ID,

        ],

      ]);


    }


    private function resolveRouteEditorID(
      Request $request,
      $methodID = null
    ) {


      /*
      |--------------------------------------------------------------------------
      | Candidatos ao ID
      |--------------------------------------------------------------------------
      |
      | A ordem é importante:
      |
      | 1. tbl_sys_route_ID enviado pelo formulário do editor;
      | 2. id enviado no body da requisição;
      | 3. parâmetro id real da rota;
      | 4. argumento recebido pelo método.
      |
      | Os valores internos pageSlug e sysRouteName não são considerados IDs.
      |
      */

      $candidates = [

        $request->input(
          'tbl_sys_route_ID'
        ),

        $request->input(
          'id'
        ),

        $request->route(
          'id'
        ),

        $methodID,

      ];


      foreach($candidates as $candidate) {


        if(
          $candidate === null ||
          $candidate === ''
        ) {

          continue;

        }


        /*
        |--------------------------------------------------------------------------
        | Aceita somente números inteiros positivos
        |--------------------------------------------------------------------------
        */

        if(
          is_int($candidate) ||
          (
            is_string($candidate) &&
            ctype_digit(trim($candidate))
          )
        ) {

          $candidate = (int) $candidate;


          if($candidate > 0) {

            return $candidate;

          }

        }


      }


      return null;


    }



    private function prepareRouteEditorPayload(Request $request, $currentRoute = null) {

      $name = $this->normalizeRouteEditorSlug(
        $request->input(
          'tbl_sys_route_name',
          $currentRoute ? $currentRoute->tbl_sys_route_name : ''
        )
      );

      $permalink = $this->normalizeRouteEditorPermalink(
        $request->input(
          'tbl_sys_route_permalink',
          $currentRoute ? $currentRoute->tbl_sys_route_permalink : ''
        )
      );

      return [

        'tbl_sys_route_name'        => $name,
        'tbl_sys_route_title'       => trim((string) $request->input('tbl_sys_route_title', $currentRoute ? $currentRoute->tbl_sys_route_title : '')),
        'tbl_sys_route_permalink'   => $permalink,

        'tbl_sys_route_api'         => $this->routeEditorBoolean($request->input('tbl_sys_route_api', $currentRoute ? $currentRoute->tbl_sys_route_api : 0)),
        'tbl_sys_route_admin'       => $this->routeEditorBoolean($request->input('tbl_sys_route_admin', $currentRoute ? $currentRoute->tbl_sys_route_admin : 0)),
        'tbl_sys_route_locked'      => $this->routeEditorBoolean($request->input('tbl_sys_route_locked', $currentRoute ? $currentRoute->tbl_sys_route_locked : 0)),

        'tbl_sys_route_type'        => strtoupper(trim((string) $request->input('tbl_sys_route_type', $currentRoute ? $currentRoute->tbl_sys_route_type : 'GET'))),
        'tbl_sys_route_controller'  => trim((string) $request->input('tbl_sys_route_controller', $currentRoute ? $currentRoute->tbl_sys_route_controller : 'AutomatorController')),
        'tbl_sys_route_method'      => trim((string) $request->input('tbl_sys_route_method', $currentRoute ? $currentRoute->tbl_sys_route_method : 'getFunction')),
        'tbl_sys_route_args'        => trim((string) $request->input('tbl_sys_route_args', $currentRoute ? $currentRoute->tbl_sys_route_args : '')),

        'tbl_sys_route_content'     => (string) $request->input('tbl_sys_route_content', $currentRoute ? $currentRoute->tbl_sys_route_content : ''),
        'tbl_sys_route_css'         => (string) $request->input('tbl_sys_route_css', $currentRoute && isset($currentRoute->tbl_sys_route_css) ? $currentRoute->tbl_sys_route_css : ''),

        'tbl_sys_route_description' => (string) $request->input('tbl_sys_route_description', $currentRoute ? $currentRoute->tbl_sys_route_description : ''),
        'tbl_sys_route_area'        => trim((string) $request->input('tbl_sys_route_area', $currentRoute ? $currentRoute->tbl_sys_route_area : 'restrict')),
        'tbl_sys_route_status'      => trim((string) $request->input('tbl_sys_route_status', $currentRoute ? $currentRoute->tbl_sys_route_status : 'ativo')),
        'tbl_sys_route_parent_id'   => $request->input('tbl_sys_route_parent_id', $currentRoute ? $currentRoute->tbl_sys_route_parent_id : null),

      ];

    }



    private function validateRouteEditorPayload(array $payload, $ignoreID = null) {

      if($payload['tbl_sys_route_title'] == '') {

        return $this->routeEditorResponse(
          false,
          'Atenção',
          'Informe o título da página.'
        );

      }

      if($payload['tbl_sys_route_name'] == '') {

        return $this->routeEditorResponse(
          false,
          'Atenção',
          'Informe o nome da página.'
        );

      }

      if(!in_array($payload['tbl_sys_route_type'], ['GET', 'POST'])) {

        return $this->routeEditorResponse(
          false,
          'Atenção',
          'Tipo de rota inválido.'
        );

      }

      if(!in_array($payload['tbl_sys_route_area'], ['public', 'restrict'])) {

        return $this->routeEditorResponse(
          false,
          'Atenção',
          'Área da rota inválida.'
        );

      }

      if(!in_array($payload['tbl_sys_route_status'], ['ativo', 'inativo'])) {

        return $this->routeEditorResponse(
          false,
          'Atenção',
          'Status da rota inválido.'
        );

      }

      $nameQuery = SysRoute::where('tbl_sys_route_name', $payload['tbl_sys_route_name']);

      if($ignoreID !== null && $ignoreID !== '') {
        $nameQuery->where('tbl_sys_route_ID', '!=', $ignoreID);
      }

      if($nameQuery->exists()) {

        return $this->routeEditorResponse(
          false,
          'Atenção',
          'Já existe uma página/rota cadastrada com este nome.'
        );

      }

      if($payload['tbl_sys_route_permalink'] !== '') {

        $permalinkQuery = SysRoute::where('tbl_sys_route_permalink', $payload['tbl_sys_route_permalink']);

        if($ignoreID !== null && $ignoreID !== '') {
          $permalinkQuery->where('tbl_sys_route_ID', '!=', $ignoreID);
        }

        if($permalinkQuery->exists()) {

          return $this->routeEditorResponse(
            false,
            'Atenção',
            'Já existe uma página/rota cadastrada com este link permanente.'
          );

        }

      }

      return [
        'status' => true,
        'result' => true,
      ];

    }



    private function assignRouteEditorPayload(SysRoute $route, array $payload) {

      $route->tbl_sys_route_name        = $payload['tbl_sys_route_name'];
      $route->tbl_sys_route_title       = $payload['tbl_sys_route_title'];
      $route->tbl_sys_route_permalink   = $payload['tbl_sys_route_permalink'];
      $route->tbl_sys_route_api         = $payload['tbl_sys_route_api'];
      $route->tbl_sys_route_admin       = $payload['tbl_sys_route_admin'];
      $route->tbl_sys_route_locked      = $payload['tbl_sys_route_locked'];
      $route->tbl_sys_route_type        = $payload['tbl_sys_route_type'];
      $route->tbl_sys_route_controller  = $payload['tbl_sys_route_controller'];
      $route->tbl_sys_route_method      = $payload['tbl_sys_route_method'];
      $route->tbl_sys_route_args        = $payload['tbl_sys_route_args'];
      $route->tbl_sys_route_content     = $payload['tbl_sys_route_content'];
      $route->tbl_sys_route_description = $payload['tbl_sys_route_description'];
      $route->tbl_sys_route_area        = $payload['tbl_sys_route_area'];
      $route->tbl_sys_route_status      = $payload['tbl_sys_route_status'];
      $route->tbl_sys_route_parent_id   = $payload['tbl_sys_route_parent_id'];

      if(
        Schema::hasColumn('tbl_sys_routes', 'tbl_sys_route_css')
      ) {
        $route->tbl_sys_route_css = $payload['tbl_sys_route_css'];
      }

    }



    private function normalizeRouteEditorSlug($value) {

      $value = trim((string) $value);

      if($value == '') {
        return '';
      }

      $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
      $value = strtolower($value);
      $value = preg_replace('/[^a-z0-9]+/', '-', $value);
      $value = trim($value, '-');

      return $value;

    }



    private function normalizeRouteEditorPermalink($value) {

      $value = trim((string) $value);

      if($value == '' || $value == '/') {
        return $value;
      }

      $value = trim($value, '/');
      $value = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
      $value = strtolower($value);
      $value = preg_replace('/[^a-z0-9\/\-]+/', '-', $value);
      $value = preg_replace('/-+/', '-', $value);
      $value = trim($value, '/-');

      return $value;

    }



    private function routeEditorBoolean($value) {

      return (
        $value === true ||
        $value === 1 ||
        $value === '1' ||
        $value === 'true' ||
        $value === 'TRUE' ||
        $value === 'sim' ||
        $value === 'SIM'
      ) ? 1 : 0;

    }



    private function routeEditorResponse($result, $title, $message) {

      return [

        'status'  => $result ? true : false,
        'result'  => $result ? true : false,
        'title'   => SysAutomator::SysAutomatorGetTranslateWord($title),
        'message' => SysAutomator::SysAutomatorGetTranslateWord($message),

      ];

    }



  }