<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\View;

  use App\Models\Post;
  use App\Models\PostsAccess;
  use App\Models\PostCategorie;
  use App\Models\PostCategoriesAccess;



  class PostsController extends Controller {



    public function viewPost($category = null, $name) {


      $post = Post::where('tbl_post_name', $name)->first();
      if($post) {

        $post = $post->toArray();

        $status = false;
        $access = false;

        if($post['tbl_post_status'] == 'publicado') {

          $status = true;

          if($post['tbl_post_access'] == 'public') {

            $access = true;

          }

        } else {

          if(Auth::check()) {

            $user = Auth::user();

            $status = true;
            $access = true;

          }

        }


        if($status == true) {

          if($access == true) {

            return view('Resources.views.view-post', ['post' => $post]);

          } else {

            return view('layouts.public', [

              'content' => 'Você não possui as permissões necessárias para visualizar este conteudo.',
              'title'   => 'Erro 500',
              'page'    => 'Postagem não encontrada'

            ]);

          }

        } else {

          return view('layouts.public', [

            'content' => 'O Post solicitado não existe.',
            'title'   => 'Erro 404',
            'page'    => 'Postagem não encontrada'

          ]);

        }



      }


    }

  }