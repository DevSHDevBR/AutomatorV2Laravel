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



  class FieldsTypesController extends Controller {



    public function index(Request $request) {


      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);

      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first()->toArray();

      // dd($route);

      $params = [
        'table' => 'tbl_users_types',
        'per_page' => 15,
        'page_name' => $route['tbl_sys_route_name'],
        'columns' => [
          'tbl_users_type_ID'     => [

            'label'    => 'ID',
            'sortable' => true,
            'header'   => ['classes' => 'text-center'],
            'body'     => ['classes' => 'text-center'],

          ],
          'tbl_users_type_name' => [
            'label' => 'Nome',
            'sortable' => true
          ]
        ]
      ];


      return view('layouts.painel-restrict', [

        'content' => SysAutomator::SysAutomatorPaginateDynamic($params, $request),
        'title'   => $route['tbl_sys_route_title'],
        'page'    => $route['tbl_sys_route_name']
        
      ]);

    }



  }