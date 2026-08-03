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



  class UsersController extends Controller {


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

    
  }