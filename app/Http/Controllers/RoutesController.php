<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\Hash;

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



  }