<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Str;

  use App\Helpers\SysAutomator;
  use App\Models\SysRoute;
  use App\Models\User;
  use App\Models\UsersType;
  use App\Models\SysUpload;
  use App\Models\SysUploadsType;
  use App\Models\SysUploadsAccess;



  class UploadsController extends Controller {


    public function index(
      Request $request
    ) {


      $currentPerPage =

        $this->resolveUploadsPerPage(

          $request

        );


      $perPageOptions = [

        4,
        10,
        20,
        40,
        80,
        100,

      ];


      /*
      |--------------------------------------------------------------------------
      | Busca
      |--------------------------------------------------------------------------
      */

      $searchFields = [

        'tbl_sys_upload_ID'        => 'ID',
        'tbl_sys_uploads_type_ID'  => 'Tipo',
        'tbl_sys_upload_title'     => 'Nome',
        'tbl_sys_upload_directory' => 'Diretório',
        'tbl_user_ID'              => 'Usuário',

      ];


      $uploadsQuery = SysUpload::query()
        ->orderBy(

          'tbl_sys_upload_ID',

          'desc'

        );


      $this->applyUploadsSearchFilters(

        $uploadsQuery,

        $request

      );


      /*
      |--------------------------------------------------------------------------
      | Carrega somente a primeira página
      |--------------------------------------------------------------------------
      |
      | Busca um registro adicional para determinar se existe próxima página,
      | sem executar uma segunda consulta COUNT.
      |
      */

      $uploadsCollection = $uploadsQuery
        ->limit(

          $currentPerPage + 1

        )
        ->get();


      $hasMore = (

        $uploadsCollection->count() >

        $currentPerPage

      );


      $uploads = $uploadsCollection
        ->take(

          $currentPerPage

        )
        ->map(

          function($upload) {


            return $this->formatUploadResponse(

              $upload

            );


          }

        )
        ->values()
        ->toArray();


      /*
      |--------------------------------------------------------------------------
      | Tipos permitidos
      |--------------------------------------------------------------------------
      */

      $uploadTypes = SysUploadsType::query()
        ->orderBy(

          'tbl_sys_uploads_type_name',

          'asc'

        )
        ->get()
        ->map(

          function($uploadType) {


            return [

              'id' =>

                (int) $uploadType->tbl_sys_uploads_type_ID,

              'mime' =>

                strtolower(

                  trim(

                    (string) $uploadType->tbl_sys_uploads_type_mine

                  )

                ),

              'extension' =>

                strtolower(

                  trim(

                    (string) $uploadType->tbl_sys_uploads_type_name

                  )

                ),

              'title' =>

                (string) $uploadType->tbl_sys_uploads_type_title,

              'description' =>

                (string) $uploadType->tbl_sys_uploads_type_description,

              'icon' =>

                (string) (

                  $uploadType->tbl_sys_uploads_type_icon

                  ?: 'file'

                ),

            ];


          }

        )
        ->values()
        ->toArray();


      /*
      |--------------------------------------------------------------------------
      | Diretório padrão
      |--------------------------------------------------------------------------
      */

      $defaultUploadsDirectory = trim(

        (string) SysAutomator::SysAutomatorGetConfigValue(

          'system-default-uploads-dir',

          'uploads'

        )

      );


      if($defaultUploadsDirectory === '') {

        $defaultUploadsDirectory = 'uploads';

      }


      $defaultUploadsDirectory =

        $this->normalizeUploadDirectory(

          $defaultUploadsDirectory

        );


      $slug = $request->route(

        'pageSlug'

      );


      $data = [

        'routes' => [

          'load' =>

            SysAutomator::SysAutomatorGetRouteLinkByName(

              'admin-api-galeria-uploads-load',

              [],

              true

            ),

          'get' =>

            SysAutomator::SysAutomatorGetRouteLinkByName(

              'admin-api-galeria-uploads-get',

              [],

              true

            ),

          'store' =>

            SysAutomator::SysAutomatorGetRouteLinkByName(

              'admin-api-galeria-uploads-store',

              [],

              true

            ),

          'update' =>

            SysAutomator::SysAutomatorGetRouteLinkByName(

              'admin-api-galeria-uploads-update',

              [],

              true

            ),

          'delete' =>

            SysAutomator::SysAutomatorGetRouteLinkByName(

              'admin-api-galeria-uploads-delete',

              [],

              true

            ),

        ],

        'search_fields' =>

          $searchFields,

        'currentPerPage' =>

          $currentPerPage,

        'perPageOptions' =>

          $perPageOptions,

        'deleteMessageConfirm' =>

          'Tem certeza de que deseja excluir os itens selecionados?',

        'itens' =>

          $uploads,

        'page' =>

          1,

        'hasMore' =>

          $hasMore,

        'uploadTypes' =>

          $uploadTypes,

        'defaultUploadsDirectory' =>

          $defaultUploadsDirectory,

        'currentUserID' =>

          Auth::id(),

      ];


      return SysAutomator::SysAutomatoRenderRouteContent(

        $slug,

        $data,

        'restrict'

      );


    }


    public function getUpload(
      Request $request,
      $id = null
    ) {


      if(

        Auth::check() !== true ||

        Auth::id() === null

      ) {


        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'title'           => 'Sessão expirada',
          'message'         => SysAutomator::SysAutomatorGetTranslateWord(
            'Sua sessão expirou. Faça o login novamente para continuar.'
          ),

        ], 401);


      }


      $uploadID = $id

        ?: $request->route(

          'id'

        )

        ?: $request->input(

          'id'

        )

        ?: $request->input(

          'tbl_sys_upload_ID'

        );


      if(

        $uploadID === null ||

        $uploadID === '' ||

        !is_numeric(

          $uploadID

        )

      ) {


        return response()->json([

          'status'  => false,
          'data'    => null,
          'title'   => 'Arquivo inválido',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Não foi possível identificar o arquivo solicitado.'
          ),

        ], 422);


      }


      $upload = SysUpload::where(

        'tbl_sys_upload_ID',

        (int) $uploadID

      )->first();


      if(!$upload) {


        return response()->json([

          'status'  => false,
          'data'    => null,
          'title'   => 'Arquivo não encontrado',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'O arquivo solicitado não foi encontrado.'
          ),

        ], 404);


      }


      return response()->json([

        'status'  => true,
        'title'   => 'Arquivo localizado',
        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'Os dados do arquivo foram carregados com sucesso.'
        ),
        'data'    => $this->formatUploadResponse(
          $upload
        ),

      ], 200);


    }


    public function loadMore(
      Request $request
    ) {


      /*
      |--------------------------------------------------------------------------
      | Sessão
      |--------------------------------------------------------------------------
      */

      if(

        Auth::check() !== true ||

        Auth::id() === null

      ) {


        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'title'           => 'Sessão expirada',
          'message'         => SysAutomator::SysAutomatorGetTranslateWord(
            'Sua sessão expirou. Faça o login novamente para continuar.'
          ),

        ], 401);


      }


      /*
      |--------------------------------------------------------------------------
      | Quantidade por carregamento
      |--------------------------------------------------------------------------
      */

      $perPage =

        $this->resolveUploadsPerPage(

          $request

        );


      /*
      |--------------------------------------------------------------------------
      | IDs que já estão sendo exibidos
      |--------------------------------------------------------------------------
      */

      $loadedIDs = $request->input(

        'loaded_ids',

        []

      );


      if(!is_array($loadedIDs)) {

        $loadedIDs = [];

      }


      $loadedIDs = array_values(

        array_unique(

          array_filter(

            array_map(

              function($uploadID) {


                if(

                  !is_numeric(

                    $uploadID

                  )

                ) {

                  return null;

                }


                $uploadID = (int) $uploadID;


                return $uploadID > 0

                  ? $uploadID

                  : null;


              },

              $loadedIDs

            ),

            function($uploadID) {


              return $uploadID !== null;


            }

          )

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Consulta
      |--------------------------------------------------------------------------
      */

      $uploadsQuery = SysUpload::query()
        ->orderBy(

          'tbl_sys_upload_ID',

          'desc'

        );


      /*
      |--------------------------------------------------------------------------
      | Mantém os filtros de busca atuais
      |--------------------------------------------------------------------------
      */

      $this->applyUploadsSearchFilters(

        $uploadsQuery,

        $request

      );


      /*
      |--------------------------------------------------------------------------
      | Não retorna itens que já estão na tela
      |--------------------------------------------------------------------------
      */

      if(count($loadedIDs) >= 1) {


        $uploadsQuery->whereNotIn(

          'tbl_sys_upload_ID',

          $loadedIDs

        );


      }


      /*
      |--------------------------------------------------------------------------
      | Busca um registro adicional
      |--------------------------------------------------------------------------
      |
      | O registro adicional permite determinar se ainda existem resultados sem
      | precisar executar uma consulta COUNT separada.
      |
      */

      $uploadsCollection = $uploadsQuery
        ->limit(

          $perPage + 1

        )
        ->get();


      $hasMore = (

        $uploadsCollection->count() >

        $perPage

      );


      $items = $uploadsCollection
        ->take(

          $perPage

        )
        ->map(

          function($upload) {


            return $this->formatUploadResponse(

              $upload

            );


          }

        )
        ->values()
        ->toArray();


      /*
      |--------------------------------------------------------------------------
      | IDs retornados
      |--------------------------------------------------------------------------
      */

      $returnedIDs = array_values(

        array_map(

          function($item) {


            return (int) (

              $item['tbl_sys_upload_ID']

              ?? 0

            );


          },

          $items

        )

      );


      return response()->json([

        'status' => true,

        'title' =>

          'Uploads carregados',

        'message' =>

          count($items) >= 1

            ? SysAutomator::SysAutomatorGetTranslateWord(
                'Os arquivos foram carregados com sucesso.'
              )

            : SysAutomator::SysAutomatorGetTranslateWord(
                'Não existem mais arquivos para carregar.'
              ),

        'data' => [

          'items' =>

            $items,

          'returned_ids' =>

            $returnedIDs,

          'loaded_count' =>

            count($loadedIDs) +

            count($returnedIDs),

          'per_page' =>

            $perPage,

          'has_more' =>

            $hasMore,

        ],

      ], 200);


    }



    private function normalizeUploadDirectory(
      $directory
    ): string {


      if(

        $directory === null ||

        !is_scalar($directory)

      ) {

        $directory = '';

      }


      $directory = str_replace(

        '\\',

        '/',

        trim(

          (string) $directory

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Remove barras externas
      |--------------------------------------------------------------------------
      */

      $directory = trim(

        $directory,

        '/'

      );


      /*
      |--------------------------------------------------------------------------
      | Remove repetições de barras
      |--------------------------------------------------------------------------
      */

      $directory = preg_replace(

        '#/+#',

        '/',

        $directory

      );


      /*
      |--------------------------------------------------------------------------
      | Diretório padrão
      |--------------------------------------------------------------------------
      */

      if($directory === '') {

        $directory = trim(

          (string) SysAutomator::SysAutomatorGetConfigValue(

            'system-default-uploads-dir',

            'uploads'

          ),

          '/'

        );

      }


      if($directory === '') {

        $directory = 'uploads';

      }


      /*
      |--------------------------------------------------------------------------
      | Impede navegação para diretórios superiores
      |--------------------------------------------------------------------------
      */

      $directoryParts = explode(

        '/',

        $directory

      );


      $normalizedParts = [];


      foreach(

        $directoryParts as $directoryPart

      ) {


        $directoryPart = trim(

          $directoryPart

        );


        if(

          $directoryPart === '' ||

          $directoryPart === '.' ||

          $directoryPart === '..'

        ) {

          continue;

        }


        /*
        |--------------------------------------------------------------------------
        | Mantém somente caracteres seguros
        |--------------------------------------------------------------------------
        */

        $directoryPart = preg_replace(

          '/[^a-zA-Z0-9_\-]/',

          '-',

          $directoryPart

        );


        $directoryPart = preg_replace(

          '/-+/',

          '-',

          $directoryPart

        );


        $directoryPart = trim(

          $directoryPart,

          '-'

        );


        if($directoryPart === '') {

          continue;

        }


        $normalizedParts[] =

          $directoryPart;


      }


      if(count($normalizedParts) <= 0) {

        return 'uploads';

      }


      return implode(

        '/',

        $normalizedParts

      );


    }


    private function resolveUploadType(
      $file,
      $requestedTypeID = null
    ) {


      if(!$file) {

        return null;

      }


      $mimeType = strtolower(

        trim(

          (string) (

            $file->getMimeType()

            ?: $file->getClientMimeType()

            ?: ''

          )

        )

      );


      $extension = strtolower(

        trim(

          (string) (

            $file->getClientOriginalExtension()

            ?: $file->extension()

            ?: ''

          )

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Tipo informado pelo formulário
      |--------------------------------------------------------------------------
      |
      | O valor é aceito somente quando também corresponde ao arquivo recebido.
      |
      */

      if(

        $requestedTypeID !== null &&

        $requestedTypeID !== ''

      ) {


        $requestedType = SysUploadsType::where(

          'tbl_sys_uploads_type_ID',

          $requestedTypeID

        )->first();


        if($requestedType) {


          $requestedMime = strtolower(

            trim(

              (string) $requestedType->tbl_sys_uploads_type_mine

            )

          );


          $requestedExtension = strtolower(

            trim(

              (string) $requestedType->tbl_sys_uploads_type_name

            )

          );


          if(

            (
              $mimeType !== '' &&

              $requestedMime === $mimeType
            ) ||

            (
              $extension !== '' &&

              $requestedExtension === $extension
            )

          ) {

            return $requestedType;

          }


        }


      }


      /*
      |--------------------------------------------------------------------------
      | Busca pelo MIME Type
      |--------------------------------------------------------------------------
      */

      if($mimeType !== '') {


        $typeByMime = SysUploadsType::whereRaw(

          'LOWER(tbl_sys_uploads_type_mine) = ?',

          [

            $mimeType,

          ]

        )->first();


        if($typeByMime) {

          return $typeByMime;

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Busca pela extensão
      |--------------------------------------------------------------------------
      */

      if($extension !== '') {


        $typeByExtension = SysUploadsType::whereRaw(

          'LOWER(tbl_sys_uploads_type_name) = ?',

          [

            $extension,

          ]

        )->first();


        if($typeByExtension) {

          return $typeByExtension;

        }


      }


      return null;


    }


    private function getUploadPublicURL(
      $directory,
      $fileName
    ): string {


      $directory =

        $this->normalizeUploadDirectory(

          $directory

        );


      $fileName = basename(

        (string) $fileName

      );


      if($fileName === '') {

        return '';

      }


      return asset(

        trim(

          $directory,

          '/'

        ) .

        '/' .

        $fileName

      );


    }


    public function storeUpload(
      Request $request
    ) {


      /*
      |--------------------------------------------------------------------------
      | Sessão
      |--------------------------------------------------------------------------
      */

      if(

        Auth::check() !== true ||

        Auth::id() === null

      ) {


        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'title'           => 'Sessão expirada',
          'message'         => SysAutomator::SysAutomatorGetTranslateWord(
            'Sua sessão expirou. Faça o login novamente para continuar.'
          ),
          'login_url'       => SysAutomator::SysAutomatorGetRouteLinkByName(
            'admin-login',
            [],
            true
          ),

        ], 401);


      }


      /*
      |--------------------------------------------------------------------------
      | Validação inicial
      |--------------------------------------------------------------------------
      */

      $validatedData = $request->validate(

        [

          'file' => [

            'required',
            'file',

          ],

          'tbl_sys_uploads_type_ID' => [

            'required',
            'integer',

          ],

          'tbl_sys_upload_title' => [

            'required',
            'string',
            'max:255',

          ],

          'tbl_sys_upload_directory' => [

            'required',
            'string',
            'max:255',

          ],

          'tbl_sys_upload_access' => [

            'required',
            'string',
            'in:public,restrict',

          ],

        ],

        [

          'file.required' =>

            'Selecione um arquivo para realizar o upload.',

          'file.file' =>

            'O arquivo selecionado não é válido.',

          'tbl_sys_uploads_type_ID.required' =>

            'Não foi possível identificar o tipo do arquivo.',

          'tbl_sys_uploads_type_ID.integer' =>

            'O tipo informado para o arquivo é inválido.',

          'tbl_sys_upload_title.required' =>

            'Informe um título para o arquivo.',

          'tbl_sys_upload_title.max' =>

            'O título do arquivo deve possuir no máximo 255 caracteres.',

          'tbl_sys_upload_directory.required' =>

            'Informe o diretório do upload.',

          'tbl_sys_upload_directory.max' =>

            'O diretório deve possuir no máximo 255 caracteres.',

          'tbl_sys_upload_access.required' =>

            'Informe o acesso do arquivo.',

          'tbl_sys_upload_access.in' =>

            'O acesso do arquivo deve ser público ou restrito.',

        ]

      );


      $uploadedFile = $request->file(

        'file'

      );


      /*
      |--------------------------------------------------------------------------
      | Tipo real do arquivo
      |--------------------------------------------------------------------------
      */

      $uploadType =

        $this->resolveUploadType(

          $uploadedFile,

          $validatedData['tbl_sys_uploads_type_ID']

          ?? null

        );


      if(!$uploadType) {


        return response()->json([

          'status'  => false,
          'title'   => 'Tipo não permitido',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'O tipo do arquivo selecionado não está cadastrado ou não é permitido.'
          ),

        ], 422);


      }


      /*
      |--------------------------------------------------------------------------
      | Diretório
      |--------------------------------------------------------------------------
      */

      $directory =

        $this->normalizeUploadDirectory(

          $validatedData['tbl_sys_upload_directory']

          ?? ''

        );


      $absoluteDirectory = public_path(

        str_replace(

          '/',

          DIRECTORY_SEPARATOR,

          $directory

        )

      );


      if(

        !is_dir(

          $absoluteDirectory

        )

      ) {


        $directoryCreated = @mkdir(

          $absoluteDirectory,

          0755,

          true

        );


        if(

          $directoryCreated !== true &&

          !is_dir(

            $absoluteDirectory

          )

        ) {


          return response()->json([

            'status'  => false,
            'title'   => 'Diretório indisponível',
            'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Não foi possível criar o diretório destinado ao upload.'
            ),

          ], 500);


        }


      }


      /*
      |--------------------------------------------------------------------------
      | Extensão
      |--------------------------------------------------------------------------
      */

      $extension = strtolower(

        trim(

          (string) $uploadType->tbl_sys_uploads_type_name

        )

      );


      if($extension === '') {


        $extension = strtolower(

          trim(

            (string) $uploadedFile->getClientOriginalExtension()

          )

        );


      }


      $extension = preg_replace(

        '/[^a-zA-Z0-9]/',

        '',

        $extension

      );


      if($extension === '') {


        return response()->json([

          'status'  => false,
          'title'   => 'Arquivo inválido',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Não foi possível identificar a extensão do arquivo.'
          ),

        ], 422);


      }


      /*
      |--------------------------------------------------------------------------
      | Nome físico
      |--------------------------------------------------------------------------
      */

      $fileName =

        hash(

          'sha256',

          Auth::id() .

          '|' .

          microtime(true) .

          '|' .

          Str::random(64) .

          '|' .

          $uploadedFile->getClientOriginalName()

        ) .

        '.' .

        $extension;


      $storedFilePath =

        $absoluteDirectory .

        DIRECTORY_SEPARATOR .

        $fileName;


      try {


        /*
        |--------------------------------------------------------------------------
        | Move o arquivo
        |--------------------------------------------------------------------------
        */

        $uploadedFile->move(

          $absoluteDirectory,

          $fileName

        );


        /*
        |--------------------------------------------------------------------------
        | Salva o registro
        |--------------------------------------------------------------------------
        */

        $upload = DB::transaction(

          function() use (

            $uploadType,

            $fileName,

            $validatedData,

            $directory

          ) {


            return SysUpload::create([

              'tbl_sys_uploads_type_ID' =>

                $uploadType->tbl_sys_uploads_type_ID,

              'tbl_sys_upload_file' =>

                $fileName,

              'tbl_sys_upload_title' =>

                trim(

                  (string) $validatedData['tbl_sys_upload_title']

                ),

              'tbl_sys_upload_directory' =>

                $directory,

              /*
              |--------------------------------------------------------------------------
              | Nunca confia no ID enviado pelo navegador
              |--------------------------------------------------------------------------
              */

              'tbl_user_ID' =>

                Auth::id(),

              'tbl_sys_upload_access' =>

                $validatedData['tbl_sys_upload_access'],

            ]);


          }

        );


      } catch(\Throwable $exception) {


        /*
        |--------------------------------------------------------------------------
        | Remove o arquivo caso o banco falhe
        |--------------------------------------------------------------------------
        */

        if(

          is_file(

            $storedFilePath

          )

        ) {

          @unlink(

            $storedFilePath

          );

        }


        report(

          $exception

        );


        return response()->json([

          'status'  => false,
          'title'   => 'Erro ao enviar arquivo',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Não foi possível concluir o upload do arquivo.'
          ),

        ], 500);


      }


      /*
      |--------------------------------------------------------------------------
      | Resposta
      |--------------------------------------------------------------------------
      */

      return response()->json([

        'status'  => true,
        'title'   => 'Upload concluído',
        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'O arquivo foi enviado com sucesso.'
        ),

        'data' => [

          'tbl_sys_upload_ID' =>

            $upload->tbl_sys_upload_ID,

          'tbl_sys_uploads_type_ID' =>

            $upload->tbl_sys_uploads_type_ID,

          'tbl_sys_upload_file' =>

            $upload->tbl_sys_upload_file,

          'tbl_sys_upload_title' =>

            $upload->tbl_sys_upload_title,

          'tbl_sys_upload_directory' =>

            $upload->tbl_sys_upload_directory,

          'tbl_user_ID' =>

            $upload->tbl_user_ID,

          'tbl_sys_upload_access' =>

            $upload->tbl_sys_upload_access,

          'file_url' =>

            $this->getUploadPublicURL(

              $upload->tbl_sys_upload_directory,

              $upload->tbl_sys_upload_file

            ),

          'type' => [

            'id' =>

              $uploadType->tbl_sys_uploads_type_ID,

            'mime' =>

              $uploadType->tbl_sys_uploads_type_mine,

            'extension' =>

              $uploadType->tbl_sys_uploads_type_name,

            'title' =>

              $uploadType->tbl_sys_uploads_type_title,

            'icon' =>

              $uploadType->tbl_sys_uploads_type_icon,

          ],

        ],

      ], 201);


    }


    private function applyUploadsSearchFilters(
      $query,
      Request $request
    ) {


      $searchFields = [

        'tbl_sys_upload_ID',
        'tbl_sys_uploads_type_ID',
        'tbl_sys_upload_title',
        'tbl_sys_upload_directory',
        'tbl_user_ID',

      ];


      $search = trim(

        (string) $request->input(

          'search',

          ''

        )

      );


      $searchIn = $request->input(

        'search_in',

        $searchFields

      );


      if(!is_array($searchIn)) {

        $searchIn = [];

      }


      $searchIn = array_values(

        array_intersect(

          $searchIn,

          $searchFields

        )

      );


      if(

        $search === '' ||

        count($searchIn) <= 0

      ) {

        return $query;

      }


      $query->where(

        function($searchQuery) use (

          $search,

          $searchIn

        ) {


          foreach(

            $searchIn as $searchField

          ) {


            $searchQuery->orWhere(

              $searchField,

              'LIKE',

              '%' .

              $search .

              '%'

            );


          }


        }

      );


      return $query;


    }


    private function formatUploadResponse(
      $upload
    ): array {


      if(!$upload) {

        return [];

      }


      $uploadType = null;


      if(

        isset(

          $upload->uploadType

        ) &&

        $upload->uploadType

      ) {


        $uploadType =

          $upload->uploadType;


      } else {


        $uploadType =

          SysUploadsType::where(

            'tbl_sys_uploads_type_ID',

            $upload->tbl_sys_uploads_type_ID

          )->first();


      }


      $typeData = null;


      if($uploadType) {


        $typeData = [

          'id' =>

            (int) $uploadType->tbl_sys_uploads_type_ID,

          'tbl_sys_uploads_type_ID' =>

            (int) $uploadType->tbl_sys_uploads_type_ID,

          'mime' =>

            strtolower(

              trim(

                (string) $uploadType->tbl_sys_uploads_type_mine

              )

            ),

          'tbl_sys_uploads_type_mine' =>

            strtolower(

              trim(

                (string) $uploadType->tbl_sys_uploads_type_mine

              )

            ),

          'extension' =>

            strtolower(

              trim(

                (string) $uploadType->tbl_sys_uploads_type_name

              )

            ),

          'tbl_sys_uploads_type_name' =>

            strtolower(

              trim(

                (string) $uploadType->tbl_sys_uploads_type_name

              )

            ),

          'title' =>

            (string) $uploadType->tbl_sys_uploads_type_title,

          'tbl_sys_uploads_type_title' =>

            (string) $uploadType->tbl_sys_uploads_type_title,

          'description' =>

            (string) $uploadType->tbl_sys_uploads_type_description,

          'tbl_sys_uploads_type_description' =>

            (string) $uploadType->tbl_sys_uploads_type_description,

          'icon' =>

            (string) (

              $uploadType->tbl_sys_uploads_type_icon

              ?: 'file'

            ),

          'tbl_sys_uploads_type_icon' =>

            (string) (

              $uploadType->tbl_sys_uploads_type_icon

              ?: 'file'

            ),

        ];


      }


      return [

        'tbl_sys_upload_ID' =>

          (int) $upload->tbl_sys_upload_ID,

        'tbl_sys_uploads_type_ID' =>

          (int) $upload->tbl_sys_uploads_type_ID,

        'tbl_sys_upload_file' =>

          (string) $upload->tbl_sys_upload_file,

        'tbl_sys_upload_title' =>

          (string) $upload->tbl_sys_upload_title,

        'tbl_sys_upload_directory' =>

          (string) $upload->tbl_sys_upload_directory,

        'tbl_user_ID' =>

          (int) $upload->tbl_user_ID,

        'tbl_sys_upload_access' =>

          (string) $upload->tbl_sys_upload_access,

        'file_url' =>

          $this->getUploadPublicURL(

            $upload->tbl_sys_upload_directory,

            $upload->tbl_sys_upload_file

          ),

        /*
        |--------------------------------------------------------------------------
        | Formato normalizado utilizado pelo JavaScript
        |--------------------------------------------------------------------------
        */

        'type' =>

          $typeData,

        /*
        |--------------------------------------------------------------------------
        | Mantém compatibilidade com a renderização inicial atual
        |--------------------------------------------------------------------------
        */

        'upload_type' =>

          $typeData,

      ];


    }


    private function resolveUploadsPerPage(
      Request $request
    ): int {


      $perPageOptions = [

        4,
        10,
        20,
        40,
        80,
        100,

      ];


      $perPage = (int) $request->input(

        'per_page',

        4

      );


      if(

        !in_array(

          $perPage,

          $perPageOptions,

          true

        )

      ) {

        $perPage = 4;

      }


      return $perPage;


    }

    public function deleteUpload(
      Request $request
    ) {


      /*
      |--------------------------------------------------------------------------
      | Sessão
      |--------------------------------------------------------------------------
      */

      if(

        Auth::check() !== true ||

        Auth::id() === null

      ) {


        return response()->json([

          'status'          => false,
          'authenticated'   => false,
          'session_expired' => true,
          'title'           => 'Sessão expirada',
          'message'         => SysAutomator::SysAutomatorGetTranslateWord(
            'Sua sessão expirou. Faça o login novamente para continuar.'
          ),
          'login_url'       => SysAutomator::SysAutomatorGetRouteLinkByName(
            'admin-login',
            [],
            true
          ),

        ], 401);


      }


      /*
      |--------------------------------------------------------------------------
      | Validação
      |--------------------------------------------------------------------------
      */

      $validatedData = $request->validate(

        [

          'uploads' => [

            'required',
            'array',
            'min:1',

          ],

          'uploads.*' => [

            'required',
            'integer',
            'distinct',

          ],

        ],

        [

          'uploads.required' =>

            'Selecione pelo menos um arquivo para realizar a exclusão.',

          'uploads.array' =>

            'A lista de arquivos informada é inválida.',

          'uploads.min' =>

            'Selecione pelo menos um arquivo para realizar a exclusão.',

          'uploads.*.required' =>

            'Não foi possível identificar um dos arquivos selecionados.',

          'uploads.*.integer' =>

            'Um dos arquivos informados possui um identificador inválido.',

          'uploads.*.distinct' =>

            'A lista contém arquivos repetidos.',

        ]

      );


      /*
      |--------------------------------------------------------------------------
      | Normaliza os IDs
      |--------------------------------------------------------------------------
      */

      $uploadIDs = array_values(

        array_unique(

          array_filter(

            array_map(

              function($uploadID) {


                if(!is_numeric($uploadID)) {

                  return null;

                }


                $uploadID = (int) $uploadID;


                return $uploadID > 0

                  ? $uploadID

                  : null;


              },

              $validatedData['uploads']

              ?? []

            ),

            function($uploadID) {


              return $uploadID !== null;


            }

          )

        )

      );


      if(count($uploadIDs) <= 0) {


        return response()->json([

          'status'  => false,
          'title'   => 'Arquivos inválidos',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Não foi possível identificar os arquivos que devem ser excluídos.'
          ),

        ], 422);


      }


      /*
      |--------------------------------------------------------------------------
      | Localiza os registros
      |--------------------------------------------------------------------------
      */

      $uploads = SysUpload::whereIn(

        'tbl_sys_upload_ID',

        $uploadIDs

      )->get();


      if($uploads->count() <= 0) {


        return response()->json([

          'status'  => false,
          'title'   => 'Arquivos não encontrados',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Nenhum dos arquivos selecionados foi encontrado.'
          ),

        ], 404);


      }


      /*
      |--------------------------------------------------------------------------
      | Diretório público
      |--------------------------------------------------------------------------
      */

      $publicDirectory = realpath(

        public_path()

      );


      if($publicDirectory === false) {


        return response()->json([

          'status'  => false,
          'title'   => 'Diretório indisponível',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Não foi possível acessar o diretório público do sistema.'
          ),

        ], 500);


      }


      $publicDirectory = rtrim(

        str_replace(

          '\\',

          '/',

          $publicDirectory

        ),

        '/'

      );


      /*
      |--------------------------------------------------------------------------
      | Prepara os arquivos para exclusão
      |--------------------------------------------------------------------------
      |
      | Antes de excluir os registros no banco, cada arquivo físico é renomeado
      | temporariamente. Se a transação do banco falhar, os arquivos poderão ser
      | restaurados para seus nomes originais.
      |
      */

      $temporaryFiles = [];


      try {


        foreach($uploads as $upload) {


          $directory = $this->normalizeUploadDirectory(

            $upload->tbl_sys_upload_directory

          );


          $fileName = basename(

            (string) $upload->tbl_sys_upload_file

          );


          if($fileName === '') {

            continue;

          }


          $absoluteFilePath = public_path(

            str_replace(

              '/',

              DIRECTORY_SEPARATOR,

              $directory

            ) .

            DIRECTORY_SEPARATOR .

            $fileName

          );


          $absoluteFilePathNormalized = str_replace(

            '\\',

            '/',

            $absoluteFilePath

          );


          /*
          |--------------------------------------------------------------------------
          | Proteção contra caminhos externos ao diretório público
          |--------------------------------------------------------------------------
          */

          if(

            !str_starts_with(

              $absoluteFilePathNormalized,

              $publicDirectory . '/'

            )

          ) {


            throw new \RuntimeException(

              'O caminho físico do arquivo não pertence ao diretório público.'

            );


          }


          if(!is_file($absoluteFilePath)) {

            continue;

          }


          $temporaryFileName =

            '.automator-delete-' .

            Str::uuid()->toString() .

            '-' .

            $fileName;


          $temporaryFilePath =

            dirname($absoluteFilePath) .

            DIRECTORY_SEPARATOR .

            $temporaryFileName;


          if(

            @rename(

              $absoluteFilePath,

              $temporaryFilePath

            ) !== true

          ) {


            throw new \RuntimeException(

              'Não foi possível preparar o arquivo para exclusão.'

            );


          }


          $temporaryFiles[] = [

            'original' =>

              $absoluteFilePath,

            'temporary' =>

              $temporaryFilePath,

          ];


        }


        /*
        |--------------------------------------------------------------------------
        | Exclui os registros
        |--------------------------------------------------------------------------
        */

        DB::transaction(

          function() use (

            $uploads

          ) {


            foreach($uploads as $upload) {


              $upload->delete();


            }


          }

        );


      } catch(\Throwable $exception) {


        /*
        |--------------------------------------------------------------------------
        | Restaura os arquivos físicos
        |--------------------------------------------------------------------------
        */

        foreach(

          array_reverse(

            $temporaryFiles

          ) as $temporaryFile

        ) {


          if(

            is_file(

              $temporaryFile['temporary']

            ) &&

            !is_file(

              $temporaryFile['original']

            )

          ) {


            @rename(

              $temporaryFile['temporary'],

              $temporaryFile['original']

            );


          }


        }


        report(

          $exception

        );


        return response()->json([

          'status'  => false,
          'title'   => 'Erro ao excluir arquivos',
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'Não foi possível concluir a exclusão dos arquivos selecionados.'
          ),

        ], 500);


      }


      /*
      |--------------------------------------------------------------------------
      | Remove definitivamente os arquivos temporários
      |--------------------------------------------------------------------------
      */

      foreach($temporaryFiles as $temporaryFile) {


        if(

          is_file(

            $temporaryFile['temporary']

          )

        ) {


          try {


            @unlink(

              $temporaryFile['temporary']

            );


          } catch(\Throwable $exception) {


            report(

              $exception

            );


          }


        }


      }


      $deletedIDs = $uploads
        ->pluck(

          'tbl_sys_upload_ID'

        )
        ->map(

          function($uploadID) {


            return (int) $uploadID;


          }

        )
        ->values()
        ->toArray();


      $deletedCount = count(

        $deletedIDs

      );


      return response()->json([

        'status' => true,

        'title' =>

          $deletedCount > 1

            ? 'Arquivos excluídos'

            : 'Arquivo excluído',

        'message' =>

          $deletedCount > 1

            ? SysAutomator::SysAutomatorGetTranslateWord(
                'Os arquivos selecionados foram excluídos com sucesso.'
              )

            : SysAutomator::SysAutomatorGetTranslateWord(
                'O arquivo selecionado foi excluído com sucesso.'
              ),

        'data' => [

          'deleted_ids' =>

            $deletedIDs,

          'deleted_count' =>

            $deletedCount,

        ],

      ], 200);


    }



  }