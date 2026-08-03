<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Storage;
  use Illuminate\Support\Str;

  use App\Models\SysUpload;
  use App\Models\SysUploadsTemp;
  use Posts\Models\Post;
  use Posts\Models\PostsAccess;
  use Posts\Models\PostCategorie;
  use Posts\Models\PostCategoriesAccess;



  class PostsController extends Controller {



    private function promoteFeaturedImage($value) {


      if($value === null || trim((string) $value) === '') {

        return null;

      }


      $temporaryFile = is_array($value)
        ? $value
        : json_decode($value, true);


      if(
        !is_array($temporaryFile) ||
        empty($temporaryFile['temp_id'])
      ) {

        return null;

      }


      $temporaryUpload = SysUploadsTemp::where(

        'tbl_sys_upload_temp_ID',

        (int) $temporaryFile['temp_id']

      )
        ->where(

          'tbl_user_ID',

          Auth::id()

        )
        ->first();


      if(!$temporaryUpload) {

        throw new \RuntimeException(

          'A imagem de destaque temporária não foi encontrada.'

        );

      }


      $disk = 'public';

      $temporaryDirectory = trim(

        (string) $temporaryUpload->tbl_sys_upload_temp_directory,

        '/'

      );

      $temporaryFileName = basename(

        (string) $temporaryUpload->tbl_sys_upload_temp_file

      );

      $temporaryPath = $temporaryDirectory . '/' . $temporaryFileName;


      if(!Storage::disk($disk)->exists($temporaryPath)) {

        throw new \RuntimeException(

          'O arquivo temporário da imagem de destaque não existe mais.'

        );

      }


      $finalDirectory = implode(

        '/',

        [

          'uploads',
          now()->format('Y'),
          now()->format('m'),

        ]

      );

      $finalFileName = $temporaryFileName;
      $finalPath = $finalDirectory . '/' . $finalFileName;


      if(Storage::disk($disk)->exists($finalPath)) {

        $extension = pathinfo($temporaryFileName, PATHINFO_EXTENSION);
        $baseName = pathinfo($temporaryFileName, PATHINFO_FILENAME);

        $finalFileName = $baseName . '-' . Str::uuid()->toString()
          . ($extension !== '' ? '.' . $extension : '');

        $finalPath = $finalDirectory . '/' . $finalFileName;

      }


      if(!Storage::disk($disk)->move($temporaryPath, $finalPath)) {

        throw new \RuntimeException(

          'Não foi possível mover a imagem de destaque para os uploads públicos.'

        );

      }


      try {


        $upload = SysUpload::create([

          'tbl_sys_uploads_type_ID' =>
            $temporaryUpload->tbl_sys_uploads_type_ID,

          'tbl_sys_upload_file' =>
            $finalFileName,

          'tbl_sys_upload_title' =>
            $temporaryFile['original_name'] ?? $temporaryFileName,

          'tbl_sys_upload_directory' =>
            $finalDirectory,

          'tbl_user_ID' =>
            Auth::id(),

          'tbl_sys_upload_access' =>
            'public',

        ]);


        $temporaryUpload->delete();


      } catch(\Throwable $exception) {


        if(
          Storage::disk($disk)->exists($finalPath) &&
          !Storage::disk($disk)->exists($temporaryPath)
        ) {

          Storage::disk($disk)->move($finalPath, $temporaryPath);

        }


        throw $exception;


      }


      return [

        'upload_id' =>
          $upload->tbl_sys_upload_ID,

        'type_id' =>
          $upload->tbl_sys_uploads_type_ID,

        'name' =>
          $upload->tbl_sys_upload_file,

        'original_name' =>
          $upload->tbl_sys_upload_title,

        'directory' =>
          $upload->tbl_sys_upload_directory,

        'url' =>
          Storage::disk($disk)->url($finalPath),

        'access' =>
          $upload->tbl_sys_upload_access,

      ];


    }



    public function storeData(Request $request) {


      $data = $request->only([

        'tbl_post_slug',
        'tbl_post_title',
        'tbl_post_content',
        'tbl_post_status',
        'tbl_post_access',

      ]);


      $request->validate([

        'tbl_post_slug'   => ['required', 'string', 'max:255'],
        'tbl_post_title'  => ['required', 'string', 'max:255'],
        'tbl_post_status' => ['required', 'in:lixeira,rascunho,publicado'],
        'tbl_post_access' => ['required', 'in:public,restrict'],

      ]);


      try {


        DB::beginTransaction();


        $featuredImage = $this->promoteFeaturedImage(

          $request->input('tbl_post_featured_image')

        );


        if($featuredImage !== null) {

          $data['tbl_post_featured_image'] = json_encode($featuredImage);

        }


        $data['tbl_user_ID'] = Auth::id();

        $post = Post::create($data);


        $post->GetPostCategories()->sync(

          array_filter((array) $request->input('GetPostCategoriesIDs', []))

        );


        $post->GetPostUserTypes()->sync(

          array_filter((array) $request->input('GetPostUserTypesIDs', []))

        );


        DB::commit();


        return response()->json([

          'status'  => true,
          'message' => 'Registro cadastrado com sucesso.',
          'id'      => $post->tbl_post_ID,

        ]);


      } catch(\Throwable $exception) {


        DB::rollBack();


        return response()->json([

          'status'  => false,
          'message' => $exception->getMessage(),

        ], 500);


      }


    }



    public function updateData(Request $request, $id = null) {


      $id = $request->input('tbl_post_ID')
        ?? $request->input('id')
        ?? $id;

      $post = Post::where('tbl_post_ID', $id)->first();


      if(!$post) {

        return response()->json([

          'status'  => false,
          'message' => 'Post não encontrado.',

        ], 404);

      }


      $data = $request->only([

        'tbl_post_slug',
        'tbl_post_title',
        'tbl_post_content',
        'tbl_post_status',
        'tbl_post_access',

      ]);


      try {


        DB::beginTransaction();


        if($request->has('tbl_post_featured_image')) {

          $featuredImageValue = $request->input('tbl_post_featured_image');
          $featuredImage = $this->promoteFeaturedImage($featuredImageValue);

          if($featuredImage !== null) {

            $data['tbl_post_featured_image'] = json_encode($featuredImage);

          } elseif(
            $featuredImageValue === null ||
            trim((string) $featuredImageValue) === ''
          ) {

            $data['tbl_post_featured_image'] = null;

          }

        }


        $post->fill($data);
        $post->save();


        $post->GetPostCategories()->sync(

          array_filter((array) $request->input('GetPostCategoriesIDs', []))

        );


        $post->GetPostUserTypes()->sync(

          array_filter((array) $request->input('GetPostUserTypesIDs', []))

        );


        DB::commit();


        return response()->json([

          'status'  => true,
          'message' => 'Registro atualizado com sucesso.',
          'id'      => $post->tbl_post_ID,

        ]);


      } catch(\Throwable $exception) {


        DB::rollBack();


        return response()->json([

          'status'  => false,
          'message' => $exception->getMessage(),

        ], 500);


      }


    }



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
