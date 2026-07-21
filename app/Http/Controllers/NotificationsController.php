<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;

  use App\Helpers\SysAutomator;
  use App\Models\SysNotification;
  use App\Models\SysRoute;
  use App\Models\User;
  use App\Models\UsersType;



  class NotificationsController extends Controller {



    public function index(Request $request) {


      if(Auth::check()) {


        $_user = Auth::user();

        if($_user->tbl_user_actived == 1) {
          
          if($_user->tbl_user_status == 'ativo') {

            if($_user->tbl_user_blocked == 0) {

              

            } else {

              Auth::logout();
              $request->session()->invalidate();
              $request->session()->regenerateToken();
              return redirect()->route('page.admin-login')->with('status', 'Usuário bloqueado!');

            }

          } else {

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('page.admin-login')->with('status', 'Usuário inativo!');
          
          }

        } else {

          Auth::logout();
          $request->session()->invalidate();
          $request->session()->regenerateToken();

          return redirect()->route('page.admin-login')->with('status', 'Cadastro do Usuário não ativado!');

        }


      } else {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('page.admin-login')->with('status', 'Sessão expirada!');

      }


    }



  }