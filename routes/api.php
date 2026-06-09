<?php

// use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Schema;

// use App\Helpers\SysAutomator;
// use App\Models\SysRoute;

// if (Schema::hasTable('tbl_sys_routes')) {


//   $webRoutesAPI = [

//     'admin-api-login',
//     'admin-api-logout',

//   ];


//   $routes = SysRoute::getRoutes([

//     'where' => [

//       'tbl_sys_route_status' => 'ativo',
//       'tbl_sys_route_api'    => true,

//     ],

//     'whereNotIn' => [

//       'tbl_sys_route_name' => $webRoutesAPI,

//     ],

//   ]);


//   SysAutomator::SysAutomatorRegisterDynamicRoutes($routes, [

//     'urlPrefix'             => '',
//     'adminPrefix'           => 'admin',
//     'routeNamePrefix'       => 'api.',
//     'pageSlugPrefix'        => 'page-',
//     'restrictMiddleware'    => 'route.access',
//     'useRestrictMiddleware' => true,
//     'onlyAdminRoutes'       => false,
//     'useAdminPrefix'        => true,
//     'invalidRouteResponse'  => 'json',
//     'removeNamePrefixes'    => [

//       'admin-api-',
//       'api-',
//       'admin-',

//     ],

//   ]);


// }

// Route::fallback(function () {

//   return response()->json([

//     'status'  => false,
//     'message' => 'Endpoint não encontrado.',

//   ], 404);

// });