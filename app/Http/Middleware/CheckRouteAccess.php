<?php


  namespace App\Http\Middleware;

  use Closure;
  use Illuminate\Http\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Illuminate\Support\Facades\Auth;

  use App\Models\SysRoute;
  use App\Models\SysRoutesAccess;



  class CheckRouteAccess {



    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next) {



      $slug = $request->route('pageSlug');

      if (!$slug) {

        abort(404);

      }



      $routeName = str_replace('page-', '', $slug);



      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

      if (!$route) {

        abort(404);

      }



      /*
      |--------------------------------------------------------------------------
      | Rotas públicas
      |--------------------------------------------------------------------------
      |
      | Caso este middleware seja aplicado por engano em uma rota pública,
      | a rota será liberada.
      |
      */

      if ($route->tbl_sys_route_area == 'public') {

        return $next($request);

      }



      /*
      |--------------------------------------------------------------------------
      | Valida usuário logado
      |--------------------------------------------------------------------------
      */

      if (!Auth::guard('web')->check()) {


        if ($request->isMethod('get') && !$request->expectsJson()) {

          session(['url.intended' => $request->fullUrl()]);

        }


        if ($request->expectsJson() || $request->ajax()) {

          $previousUrl = url()->previous();

          if(!empty($previousUrl) && $previousUrl != $request->fullUrl()) {

            session(['url.intended' => $previousUrl]);

          }

          return response()->json([

            'status'       => false,
            'message'      => 'Sua sessão expirou. Faça login novamente.',
            'redirect_url' => route('page.admin-login'),

          ], 401);

        }


        return redirect()->route('page.admin-login');


      }



      $user = Auth::guard('web')->user();

      if (!$user) {


        if ($request->isMethod('get') && !$request->expectsJson()) {

          session(['url.intended' => $request->fullUrl()]);

        }


        if ($request->expectsJson() || $request->ajax()) {

          $previousUrl = url()->previous();

          if(!empty($previousUrl) && $previousUrl != $request->fullUrl()) {

            session(['url.intended' => $previousUrl]);

          }

          return response()->json([

            'status'       => false,
            'message'      => 'Sua sessão expirou. Faça login novamente.',
            'redirect_url' => route('page.admin-login'),

          ], 401);

        }


        return redirect()->route('page.admin-login');


      }



      /*
      |--------------------------------------------------------------------------
      | Busca os tipos vinculados ao usuário atual
      |--------------------------------------------------------------------------
      |
      | Agora a busca fica centralizada na model User.
      |
      */

      $userTypesIDs = $user->UserGetTypesIDs();

      if (!is_array($userTypesIDs) || count($userTypesIDs) <= 0) {

        abort(403, 'Usuário sem tipo de acesso vinculado.');

      }



      /*
      |--------------------------------------------------------------------------
      | Valida se algum tipo do usuário possui acesso à rota atual
      |--------------------------------------------------------------------------
      */

      $hasRouteAccess = SysRoutesAccess::where('tbl_sys_route_ID', $route->tbl_sys_route_ID)
        ->whereIn('tbl_users_type_ID', $userTypesIDs)
        ->exists();



      if (!$hasRouteAccess) {

        abort(403, 'Você não possui permissão para acessar esta página.');

      }



      return $next($request);



    }



  }