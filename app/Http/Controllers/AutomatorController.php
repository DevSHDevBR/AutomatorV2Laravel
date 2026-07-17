<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Schema;
  use Illuminate\Support\Str;
  use Illuminate\Database\Eloquent\Model;



  use App\Models\SysRoute;


  use App\Helpers\SysAutomator;



  class AutomatorController extends Controller {



    private function getUniqueColumns(string $table): array {

      $uniqueColumns = [];

      try {

        // Utiliza SQL nativo para buscar índices únicos, evitando dependência do Doctrine DBAL
        $indexes = DB::select("SHOW INDEX FROM {$table} WHERE Non_unique = 0 AND Key_name != 'PRIMARY'");

        if(is_array($indexes) && count($indexes) > 0) {

          foreach($indexes as $index) {

            // Para simplificação, consideramos apenas índices únicos de coluna única
            // Em MySQL/MariaDB o objeto retornado tem a propriedade Column_name
            $columnName = $index->Column_name ?? $index->column_name ?? null;

            if($columnName && !in_array($columnName, $uniqueColumns)) {

              $uniqueColumns[] = $columnName;

            }

          }

        }

      } catch (\Throwable $e) {

        // Caso falhe o SHOW INDEX (ex: outro banco que não MySQL), retorna vazio para não travar o sistema
        return [];

      }

      return $uniqueColumns;

    }

    private function getAutomatorRouteAttributes(Request $request, $shortcodeParams = []) {


      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);

      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

      $attributes = [];


      if($route && isset($route->tbl_sys_route_content)) {

        $attributes = SysAutomator::SysAutomatorGetShortcodeAttributes($route->tbl_sys_route_content);

      }


      if(is_array($shortcodeParams) && count($shortcodeParams) >= 1) {

        foreach($shortcodeParams as $paramKey => $paramValue) {

          $attributes[$paramKey] = $paramValue;

        }

      }


      return $attributes;


    }



    private function getAutomatorModelClassByTable($table) {


      if($table === null || $table === '') {

        return null;

      }


      $modelsPath = app_path('Models');


      if(!is_dir($modelsPath)) {

        return null;

      }


      $files = new \RecursiveIteratorIterator(

        new \RecursiveDirectoryIterator($modelsPath)

      );


      foreach($files as $file) {


        if(!$file->isFile()) {

          continue;

        }


        if($file->getExtension() !== 'php') {

          continue;

        }


        $relativePath = str_replace($modelsPath . DIRECTORY_SEPARATOR, '', $file->getPathname());

        $className = str_replace(

          [DIRECTORY_SEPARATOR, '.php'],
          ['\\', ''],
          $relativePath

        );

        $modelClass = 'App\\Models\\' . $className;


        if(!class_exists($modelClass)) {

          continue;

        }


        if(!is_subclass_of($modelClass, Model::class)) {

          continue;

        }


        try {

          $modelInstance = new $modelClass;


          if($modelInstance->getTable() == $table) {

            return $modelClass;

          }

        } catch(\Throwable $e) {

          continue;

        }


      }


      return null;


    }



    private function getAutomatorModelClassByName($model) {


      if($model === null || $model === '') {

        return null;

      }


      $model = trim($model);
      $model = ltrim($model, '\\');


      if(strpos($model, '\\') === false) {

        $modelClass = 'App\\Models\\' . $model;

      } else {

        $modelClass = $model;

      }


      if(strpos($modelClass, 'App\\Models\\') !== 0) {

        return null;

      }


      if(!class_exists($modelClass)) {

        return null;

      }


      if(!is_subclass_of($modelClass, Model::class)) {

        return null;

      }


      return $modelClass;


    }



    private function getAutomatorRequestID(Request $request, $shortcodeParams = [], $index = null) {


      $id = null;


      if($index !== null && $index !== '') {

        $id = $request->route($index) ?? $request->get($index) ?? $request->input($index) ?? null;

      }


      if($id === null || $id === '') {

        $id = $request->route('id') ?? $request->get('id') ?? $request->input('id') ?? null;

      }


      if(($id === null || $id === '') && !is_array($shortcodeParams)) {

        $id = $shortcodeParams;

      }


      return $id;


    }



    public function getDataByTableModel(Request $request, $shortcodeParams = []) {


      $attributes = $this->getAutomatorRouteAttributes($request, $shortcodeParams);

      $table = $attributes['table'] ?? null;
      $index = $attributes['index'] ?? null;


      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([

          'status'  => false,
          'message' => 'Tabela inválida.'

        ], 400);

      }


      $modelClass = $this->getAutomatorModelClassByTable($table);


      if($modelClass === null) {

        return response()->json([

          'status'  => false,
          'message' => 'Nenhuma Model foi encontrada para a tabela informada.'

        ], 400);

      }


      $modelInstance = new $modelClass;


      if($index === null || $index === '') {

        $index = $modelInstance->getKeyName();

      }


      if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

        return response()->json([

          'status'  => false,
          'message' => 'Índice inválido.'

        ], 400);

      }


      $id = $this->getAutomatorRequestID($request, $shortcodeParams, $index);


      if($id !== null && $id !== '') {

        $item = $modelClass::where($index, $id)->first();

        $item = $this->prepareAutomatorModelDataForResponse($item);


        return response()->json([

          'status' => ($item !== null),
          'data'   => $item

        ]);

      }


      $items = $modelClass::get();

      $items = $this->prepareAutomatorModelDataForResponse($items);


      return response()->json([

        'status' => true,
        'data'   => $items

      ]);


    }



    public function getDataByTableModelName(Request $request, $shortcodeParams = []) {


      return $this->getDataByTableModel($request, $shortcodeParams);


    }


    public function getDataByModel(Request $request, $shortcodeParams = []) {


      $attributes = $this->getAutomatorRouteAttributes($request, $shortcodeParams);

      $model = $attributes['model'] ?? null;

      $modelClass = $this->getAutomatorModelClassByName($model);


      if($modelClass === null) {

        return response()->json([

          'status'  => false,
          'message' => 'Model inválida.'

        ], 400);

      }


      $modelInstance = new $modelClass;

      $table = $modelInstance->getTable();

      $index = $attributes['index'] ?? null;


      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([

          'status'  => false,
          'message' => 'Tabela da Model inválida.'

        ], 400);

      }


      if($index === null || $index === '') {

        $index = $modelInstance->getKeyName();

      }


      if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

        return response()->json([

          'status'  => false,
          'message' => 'Índice inválido.'

        ], 400);

      }


      $id = $this->getAutomatorRequestID($request, $shortcodeParams, $index);

      $query = $modelClass::query();


      /*
      |--------------------------------------------------------------------------
      | Relacionamentos via shortcode
      |--------------------------------------------------------------------------
      |
      | Exemplos:
      |
      | [automator function="getDataByModel" model="User" with="UserGetTypes"]
      | [automator function="getDataByModel" model="User" with="UserGetTypes:ids"]
      | [automator function="getDataByModel" model="User" with="UserGetTypes,OutroRelacionamento"]
      | [automator function="getDataByModel" model="User" with="UserGetTypes:ids,OutroRelacionamento:ids"]
      |
      */

      $with = $attributes['with'] ?? null;

      $relationships = [];
      $relationshipsIDs = [];


      if($with !== null && $with !== '') {

        if(is_string($with)) {

          $with = explode(',', $with);

        }


        if(is_array($with) && count($with) >= 1) {

          foreach($with as $relationshipConfig) {

            $relationshipConfig = trim($relationshipConfig);

            if($relationshipConfig === '') {

              continue;

            }


            $relationshipName = $relationshipConfig;
            $relationshipMode = null;


            if(strpos($relationshipConfig, ':') !== false) {

              $relationshipParts = explode(':', $relationshipConfig);

              $relationshipName = trim($relationshipParts[0] ?? '');
              $relationshipMode = trim($relationshipParts[1] ?? '');

            }


            if($relationshipName === '') {

              continue;

            }


            if(!method_exists($modelInstance, $relationshipName)) {

              continue;

            }


            if(!in_array($relationshipName, $relationships)) {

              $relationships[] = $relationshipName;

            }


            if($relationshipMode === 'ids') {

              $relationshipsIDs[] = $relationshipName;

            }

          }


          if(count($relationships) >= 1) {

            $query->with($relationships);

          }

        }

      }


      if($id !== null && $id !== '') {

        $item = $query->where($index, $id)->first();

        if($item !== null && count($relationshipsIDs) >= 1) {

          $itemArray = $this->prepareAutomatorModelDataForResponse($item);

          foreach($relationshipsIDs as $relationshipName) {

            $idsMethod = $relationshipName . 'IDs';

            if(method_exists($item, $idsMethod)) {

              $itemArray[$idsMethod] = $item->{$idsMethod}();

            }

          }

          $item = $itemArray;

        }


        return response()->json([

          'status' => ($item !== null),
          'data'   => $item

        ]);

      }


      $items = $this->prepareAutomatorModelDataForResponse($query->get());


      if(count($relationshipsIDs) >= 1) {

        $items = $items->map(function($item) use ($relationshipsIDs) {

          $itemArray = $this->prepareAutomatorModelDataForResponse($item);

          foreach($relationshipsIDs as $relationshipName) {

            $idsMethod = $relationshipName . 'IDs';

            if(method_exists($item, $idsMethod)) {

              $itemArray[$idsMethod] = $item->{$idsMethod}();

            }

          }

          return $itemArray;

        });

      }


      return response()->json([

        'status' => true,
        'data'   => $items

      ]);


    }


    // public function getDataByModel(Request $request, $shortcodeParams = []) {


    //   $attributes = $this->getAutomatorRouteAttributes($request, $shortcodeParams);

    //   $model = $attributes['model'] ?? null;

    //   $modelClass = $this->getAutomatorModelClassByName($model);


    //   if($modelClass === null) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Model inválida.'

    //     ], 400);

    //   }


    //   $modelInstance = new $modelClass;

    //   $table = $modelInstance->getTable();

    //   $index = $attributes['index'] ?? null;


    //   if($table === null || $table === '' || !Schema::hasTable($table)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Tabela da Model inválida.'

    //     ], 400);

    //   }


    //   if($index === null || $index === '') {

    //     $index = $modelInstance->getKeyName();

    //   }


    //   if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Índice inválido.'

    //     ], 400);

    //   }


    //   $id = $this->getAutomatorRequestID($request, $shortcodeParams, $index);


    //   if($id !== null && $id !== '') {

    //     $item = $modelClass::where($index, $id)->first();

    //     return response()->json([

    //       'status' => ($item !== null),
    //       'data'   => $item

    //     ]);

    //   }


    //   $items = $modelClass::get();


    //   return response()->json([

    //     'status' => true,
    //     'data'   => $items

    //   ]);


    // }


    public function getAutomatorFormFieldNameByFormID($formID, $column) {


      $retorno = $column;

      $query = DB::table('tbl_sys_forms_fields')
                 ->where('tbl_sys_form_ID', $formID)
                 ->where('tbl_sys_forms_field_name', $column)->first();

      if($query) {

        $query = ( (array) $query );
        $retorno = $query['tbl_sys_forms_field_title'];

      }

      return $retorno;


    }


    public function getFunction(Request $request, $shortcodeParams = []) {


      /*
      |--------------------------------------------------------------------------
      | Recupera os parâmetros do shortcode
      |--------------------------------------------------------------------------
      */

      if(!is_array($shortcodeParams)) {

        $shortcodeParams = [];

      }


      if(count($shortcodeParams) <= 0) {

        $requestShortcodeParams = $request->attributes->get(

          'automator_shortcode_params',

          []

        );


        if(is_array($requestShortcodeParams)) {

          $shortcodeParams = $requestShortcodeParams;

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Executa uma função informada no shortcode
      |--------------------------------------------------------------------------
      |
      | Exemplo:
      |
      | [automator function="pagination" name="teste"]
      |
      */

      if(

        isset($shortcodeParams['function']) &&

        is_scalar($shortcodeParams['function'])

      ) {

        $function = trim(

          (string) $shortcodeParams['function']

        );


        if($function === '') {

          return '';

        }


        /*
        |--------------------------------------------------------------------------
        | Normaliza nomes em kebab-case
        |--------------------------------------------------------------------------
        |
        | pagination  => pagination
        | get-data    => getData
        | store-data  => storeData
        | update-data => updateData
        | delete-data => deleteData
        |
        */

        $method = Str::camel(

          $function

        );


        /*
        |--------------------------------------------------------------------------
        | Métodos permitidos pelo shortcode automator
        |--------------------------------------------------------------------------
        */

        $allowedMethods = [

          'pagination',
          'getData',
          'getDataByTableModel',
          'getDataByTableModelName',
          'getDataByModel',
          'storeData',
          'updateData',
          'deleteData',

        ];


        if(!in_array($method, $allowedMethods, true)) {

          return '';

        }


        if(!method_exists($this, $method)) {

          return '';

        }


        return $this->{$method}(

          $request,

          $shortcodeParams

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Execução direta da rota
      |--------------------------------------------------------------------------
      */

      $slug = $request->route('pageSlug');


      if($slug === null || $slug === '') {

        return '';

      }


      return SysAutomator::SysAutomatorSearchShortcode(

        $slug,

        [

          'request' => $request

        ]

      );


    }
    // public function getFunction(Request $request, $shortcodeParams = []) {


    //   // return $request;
    //   /*
    //   |--------------------------------------------------------------------------
    //   | Quando vier de um shortcode
    //   |--------------------------------------------------------------------------
    //   |
    //   | Exemplo:
    //   | [automator function="pagination" name="shortcodes-pagination"]
    //   |
    //   | O shortcode é cadastrado no banco como:
    //   | class  = AutomatorController
    //   | method = getFunction
    //   |
    //   | Então esta função precisa identificar o atributo "function" e chamar
    //   | a função correspondente dentro deste mesmo controller.
    //   |
    //   */

    //   if(!is_array($shortcodeParams) || count($shortcodeParams) <= 0) {

    //     $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

    //   }



    //   if(is_array($shortcodeParams) && count($shortcodeParams) >= 1 && isset($shortcodeParams['function'])) {


    //     // return $shortcodeParams;
    //     $function = trim($shortcodeParams['function']);


    //     if($function == '') {

    //       return '';

    //     }


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Normaliza nomes com hífen
    //     |--------------------------------------------------------------------------
    //     |
    //     | pagination  => pagination
    //     | get-data    => getData
    //     | store-data  => storeData
    //     | update-data => updateData
    //     | delete-data => deleteData
    //     |
    //     */

    //     $method = Str::camel($function);

    //     // return $method;


    //     /*
    //     |--------------------------------------------------------------------------
    //     | Lista de funções permitidas para shortcode automator
    //     |--------------------------------------------------------------------------
    //     |
    //     | Evita que qualquer método público do controller seja chamado apenas
    //     | alterando o conteúdo do shortcode no banco.
    //     |
    //     */

    //     $allowedMethods = [

    //       'pagination',
    //       'getData',
    //       'getDataByTableModel',
    //       'getDataByTableModelName',
    //       'getDataByModel',
    //       'storeData',
    //       'updateData',
    //       'deleteData',

    //     ];


    //     if(!in_array($method, $allowedMethods)) {

    //       return '';

    //     }


    //     if(!method_exists($this, $method)) {

    //       return '';

    //     }


    //     return $this->{$method}($request, $shortcodeParams);


    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Quando vier diretamente da rota
    //   |--------------------------------------------------------------------------
    //   |
    //   | Exemplo:
    //   | rota admin-shortcodes chama AutomatorController@getFunction.
    //   | Nesse caso, renderiza o conteúdo da rota e processa os shortcodes
    //   | cadastrados dentro da coluna tbl_sys_route_content.
    //   |
    //   */

    //   $slug = $request->route('pageSlug');

    //   // return $slug;

    //   return SysAutomator::SysAutomatorSearchShortcode($slug, [

    //     'request' => $request

    //   ]);


    // }



    public function pagination(Request $request, $shortcodeParams = []) {


      /*
      |--------------------------------------------------------------------------
      | Normaliza os parâmetros
      |--------------------------------------------------------------------------
      */

      if(!is_array($shortcodeParams)) {

        $shortcodeParams = $request->attributes->get(

          'automator_shortcode_params',

          []

        );

      }


      if(!is_array($shortcodeParams)) {

        $shortcodeParams = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Nome da paginação
      |--------------------------------------------------------------------------
      */

      $name =

        $shortcodeParams['name']

        ?? $request->attributes->get('name')

        ?? $request->input('name')

        ?? $request->query('name')

        ?? null;


      if(

        $name === null ||

        !is_scalar($name) ||

        trim((string) $name) === ''

      ) {

        return '';

      }


      $name = trim(

        (string) $name

      );


      /*
      |--------------------------------------------------------------------------
      | Argumentos da requisição
      |--------------------------------------------------------------------------
      */

      $requestArgs = $request->all();


      if(!is_array($requestArgs)) {

        $requestArgs = [];

      }


      foreach($shortcodeParams as $paramKey => $paramValue) {

        if($paramKey === 'function') {

          continue;

        }


        if(!array_key_exists($paramKey, $requestArgs)) {

          $requestArgs[$paramKey] = $paramValue;

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Renderiza a paginação
      |--------------------------------------------------------------------------
      */

      $response = SysAutomator::SysAutomatorRenderPaginationByName(

        $name,

        $requestArgs

      );


      /*
      |--------------------------------------------------------------------------
      | Retorno HTML válido
      |--------------------------------------------------------------------------
      */

      if(is_array($response)) {


        if(

          isset($response['html']) &&

          is_scalar($response['html'])

        ) {

          return (string) $response['html'];

        }


        if(

          isset($response['status']) &&

          $response['status'] === false

        ) {

          $message =

            $response['message']

            ?? 'A configuração desta paginação não foi encontrada.';


          $html = '<div class="text-center py-10">' . "\n";

            $html .= '<h2 class="text-3xl font-bold text-gray-800 mb-4">' . e($message) . '</h2>' . "\n";

            $html .= '<p class="text-gray-600">A página utiliza a automação de paginação de resultados <strong>' . e($name) . '</strong>, porém a configuração desta paginação não foi encontrada ou não está disponível.</p>' . "\n";

            $html .= '<p class="text-gray-600">Verifique o nome registrado ou as configurações da paginação.</p>' . "\n";

          $html .= '</div>' . "\n";


          return $html;

        }


        return '';

      }


      /*
      |--------------------------------------------------------------------------
      | Compatibilidade com retorno direto em HTML
      |--------------------------------------------------------------------------
      */

      if(is_scalar($response)) {

        return (string) $response;

      }


      return '';


    }
    // public function pagination(Request $request, $shortcodeParams = []) {


    //   if(!is_array($shortcodeParams)) {

    //     $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

    //   }


    //   if(!is_array($shortcodeParams)) {

    //     $shortcodeParams = [];

    //   }


    //   $name = $shortcodeParams['name'] ?? $request->get('name') ?? null;


    //   if($name === null || $name === '') {

    //     return '';

    //   }


    //   $requestArgs = $request->all();


    //   foreach($shortcodeParams as $paramKey => $paramValue) {

    //     if(!array_key_exists($paramKey, $requestArgs)) {

    //       $requestArgs[$paramKey] = $paramValue;

    //     }

    //   }

    //   // dd($requestArgs);
    //   $response = SysAutomator::SysAutomatorRenderPaginationByName($name, $requestArgs);


    //   if(is_array($response) && isset($response['html'])) {

    //     return $response['html'];

    //   } else {

    //     if($response['status'] == false) {
          
    //       $html = '<div class="text-center py-10">' . "\n";

    //         $html .= '<h2 class="text-3xl font-bold text-gray-800 mb-4">' . $response['message'] . '</h2>' . "\n";
    //         $html .= '<p class="text-gray-600">A página utiliza a automação de paginação de resultados <strong>' . $name . '</strong> porem a configuração desta página não foi encontrada ou não está disponível.</p>' . "\n";
    //         $html .= '<p class="text-gray-600">Por favor, verifique o endereço ou entre em contato com o suporte.</p>' . "\n";
            
    //       $html .= '</div>' . "\n";
    //       return $html;

    //     }

    //   }


    //   return '';


    // }



    public function getData(Request $request, $shortcodeParams = []) {


      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);

      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

      $atributes = SysAutomator::SysAutomatorGetShortcodeAttributes($route->tbl_sys_route_content);

      $table = $atributes['table'] ?? null;
      $index = $atributes['index'] ?? null;
      $id    = $shortcodeParams;

      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([

          'status'  => false,
          'message' => 'Tabela inválida.'

        ], 400);

      }


      if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

        return response()->json([

          'status'  => false,
          'message' => 'Índice inválido.'

        ], 400);

      }


      if($id !== null && $id !== '') {

        $item = DB::table($table)->where($index, $id)->first();

        return response()->json([

          'status' => ($item !== null),
          'data'   => $item

        ]);

      }


      $items = DB::table($table)->get();


      return response()->json([

        'status' => true,
        'data'   => $items

      ]);


    }


    private function validateAutomatorFormData(array $data, array $formRules, string $table, $currentID = null, $index = null) {


      foreach($formRules as $fieldName => $fieldRules) {

        $fieldTitle = $fieldRules['title'] ?? $fieldName;
        $required   = $fieldRules['required'] ?? false;
        $props      = $fieldRules['props'] ?? [];

        $valueExists = array_key_exists($fieldName, $data);
        $value       = $valueExists ? $data[$fieldName] : null;


        if($required) {

          if(
            !$valueExists ||
            $value === null ||
            $value === '' ||
            (is_array($value) && count($value) <= 0)
          ) {

            return response()->json([

              'status'  => false,
              'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
              'message' => "O campo '{$fieldTitle}' é obrigatório."

            ], 400);

          }

        }


        if(!$valueExists || $value === null || $value === '' || is_array($value)) {

          continue;

        }


        $valueLength = mb_strlen((string) $value);


        $minLength = $props['minlenght'] ?? $props['minlength'] ?? null;

        if($minLength !== null && $valueLength < (int) $minLength) {

          return response()->json([

            'status'  => false,
            'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
            'message' => "O campo '{$fieldTitle}' deve ter no mínimo {$minLength} caracteres."

          ], 400);

        }


        $maxLength = $props['maxlenght'] ?? $props['maxlength'] ?? null;

        if($maxLength !== null && $valueLength > (int) $maxLength) {

          return response()->json([

            'status'  => false,
            'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
            'message' => "O campo '{$fieldTitle}' deve ter no máximo {$maxLength} caracteres."

          ], 400);

        }


        if(isset($props['unique']) && is_array($props['unique'])) {

          $uniqueTable  = $props['unique']['table'] ?? $table;
          $uniqueColumn = $props['unique']['column'] ?? $fieldName;


          if(
            $uniqueTable !== null &&
            $uniqueTable !== '' &&
            $uniqueColumn !== null &&
            $uniqueColumn !== '' &&
            Schema::hasTable($uniqueTable) &&
            Schema::hasColumn($uniqueTable, $uniqueColumn)
          ) {

            $uniqueQuery = DB::table($uniqueTable)->where($uniqueColumn, $value);


            if($currentID !== null && $currentID !== '' && $index !== null && $index !== '') {

              if($uniqueTable === $table && Schema::hasColumn($uniqueTable, $index)) {

                $currentValue = DB::table($table)
                                  ->where($index, $currentID)
                                  ->value($uniqueColumn);


                if((string) $currentValue === (string) $value) {

                  continue;

                }


                $uniqueQuery->where($index, '!=', $currentID);

              }

            }


            if($uniqueQuery->exists()) {

              return response()->json([

                'status'  => false,
                'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
                'message' => "O valor para o campo '{$fieldTitle}' já existe."

              ], 400);

            }

          }

        }

      }


      return null;


    }


    private function prepareAutomatorModelDataForResponse($data) {


      if($data === null) {

        return null;

      }


      if($data instanceof \Illuminate\Database\Eloquent\Collection || $data instanceof \Illuminate\Support\Collection) {

        return $data->map(function($item) {

          return $this->prepareAutomatorModelDataForResponse($item);

        });

      }


      if($data instanceof Model) {

        $itemArray = $data->toArray();

        foreach($data->getAttributes() as $field => $value) {

          if(array_key_exists($field, $itemArray)) {

            $itemArray[$field] = $data->getRawOriginal($field);

          }

        }

        return $itemArray;

      }


      return $data;


    }


    private function getAutomatorFormFieldsRules($formID): array {


      $rules = [];


      if($formID === null || $formID === '') {

        return $rules;

      }


      if(!Schema::hasTable('tbl_sys_forms_fields')) {

        return $rules;

      }


      $formFields = DB::table('tbl_sys_forms_fields')
                      ->where('tbl_sys_form_ID', $formID)
                      ->get();


      foreach($formFields as $formField) {

        $formField = (array) $formField;

        $fieldName = $formField['tbl_sys_forms_field_name'] ?? null;


        if($fieldName === null || $fieldName === '') {

          continue;

        }


        $props = [];

        if(isset($formField['tbl_sys_forms_field_props']) && $formField['tbl_sys_forms_field_props'] !== '') {

          $decodedProps = json_decode($formField['tbl_sys_forms_field_props'], true);

          if(is_array($decodedProps)) {

            $props = $decodedProps;

          }

        }


        $rules[$fieldName] = [

          'title'    => $formField['tbl_sys_forms_field_title'] ?? $fieldName,
          'required' => (bool) ($formField['tbl_sys_forms_field_required'] ?? false),
          'props'    => $props

        ];

      }


      return $rules;


    }



    public function storeData(Request $request, $shortcodeParams = []) {


      $attributes = $this->getAutomatorRouteAttributes($request, $shortcodeParams);

      $table = $attributes['table'] ?? null;


      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([

          'status'  => false,
          'message' => 'Tabela inválida.'

        ], 400);

      }


      $formID = $request->input('automatorFormID');

      $formRules = $this->getAutomatorFormFieldsRules($formID);


      $data = $request->except([

        '_token',
        '_method',
        'automatorFormID',
        'id'

      ]);


      $validationResponse = $this->validateAutomatorFormData($data, $formRules, $table);

      if($validationResponse !== null) {

        return $validationResponse;

      }


      $modelClass = null;
      $modelInstance = null;


      if(isset($attributes['model']) && $attributes['model'] !== '') {

        $modelClass = $this->getAutomatorModelClassByName($attributes['model']);

      }


      if($modelClass === null) {

        $modelClass = $this->getAutomatorModelClassByTable($table);

      }


      if($modelClass !== null) {

        $modelInstance = new $modelClass;

      }


      $with = $attributes['with'] ?? null;

      $syncRelationships = [];


      if($with !== null && $with !== '') {

        if(is_string($with)) {

          $with = explode(',', $with);

        }


        if(is_array($with)) {

          foreach($with as $relationshipConfig) {

            $relationshipConfig = trim($relationshipConfig);

            if($relationshipConfig === '') {

              continue;

            }


            $relationshipName = $relationshipConfig;
            $relationshipMode = null;


            if(strpos($relationshipConfig, ':') !== false) {

              $relationshipParts = explode(':', $relationshipConfig);

              $relationshipName = trim($relationshipParts[0] ?? '');
              $relationshipMode = trim($relationshipParts[1] ?? '');

            }


            if($relationshipName === '' || $relationshipMode !== 'ids') {

              continue;

            }


            $syncRelationships[] = [

              'relationship' => $relationshipName,
              'field'        => $relationshipName . 'IDs'

            ];

          }

        }

      }


      $insertData = [];


      foreach($data as $field => $value) {

        if(!Schema::hasColumn($table, $field)) {

          continue;

        }


        $fieldRules = $formRules[$field] ?? [];
        $props      = $fieldRules['props'] ?? [];
        $required   = $fieldRules['required'] ?? false;


        if(($value === null || $value === '') && !$required) {

          continue;

        }


        if(is_array($value)) {

          continue;

        }


        if(isset($props['cast']) && $props['cast'] === 'hash') {

          if($value !== null && $value !== '') {

            $value = Hash::make($value);

          }

        }


        $insertData[$field] = $value;

      }


      if(count($insertData) <= 0 && count($syncRelationships) <= 0) {

        return response()->json([

          'status'  => false,
          'message' => 'Nenhum dado válido foi enviado.'

        ], 400);

      }


      try {

        DB::beginTransaction();


        $id = DB::table($table)->insertGetId($insertData);


        if(count($syncRelationships) >= 1) {

          if($modelClass === null || $modelInstance === null) {

            DB::rollBack();

            return response()->json([

              'status'  => false,
              'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
              'message' => 'Nenhuma Model foi encontrada para sincronizar os relacionamentos.'

            ], 400);

          }


          $index = $modelInstance->getKeyName();

          $modelItem = $modelClass::where($index, $id)->first();


          if(!$modelItem) {

            DB::rollBack();

            return response()->json([

              'status'  => false,
              'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
              'message' => 'Registro criado, mas não encontrado para sincronizar os relacionamentos.'

            ], 404);

          }


          foreach($syncRelationships as $syncRelationship) {

            $relationshipName = $syncRelationship['relationship'];
            $fieldName        = $syncRelationship['field'];


            if(!method_exists($modelItem, $relationshipName)) {

              continue;

            }


            $fieldWasSent = $request->has($fieldName);
            $fieldRequired = isset($formRules[$fieldName]) && ($formRules[$fieldName]['required'] ?? false);


            if(!$fieldWasSent && !$fieldRequired) {

              continue;

            }


            $ids = $request->input($fieldName, []);


            if($ids === null || $ids === '') {

              $ids = [];

            }


            if(!is_array($ids)) {

              $ids = [$ids];

            }


            $ids = array_values(array_filter($ids, function($value) {

              return $value !== null && $value !== '';

            }));


            $ids = array_map(function($value) {

              return (int) $value;

            }, $ids);


            $ids = array_values(array_unique($ids));


            $modelItem->{$relationshipName}()->sync($ids);

          }

        }


        DB::commit();


        return response()->json([

          'status'  => true,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('SUCESSO'),
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Registro cadastrado com sucesso.'),
          'id'      => $id

        ]);


      } catch(\Throwable $e) {

        DB::rollBack();

        return response()->json([

          'status'  => false,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
          'message' => $e->getMessage()

        ], 500);

      }


    }
    // public function storeData(Request $request, $shortcodeParams = []) {


    //   $slug = $request->route('pageSlug');

    //   $routeName = str_replace('page-', '', $slug);

    //   $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

    //   $atributes = SysAutomator::SysAutomatorGetShortcodeAttributes($route->tbl_sys_route_content);

    //   if(!is_array($shortcodeParams)) {

    //     $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

    //   }


    //   $table = ( ( isset($shortcodeParams['table']) ) ? $shortcodeParams['table'] : ( ($atributes['table']) ? $atributes['table'] : null ) );
    //   // $form  = ( ( isset($shortcodeParams['form']) )  ? $shortcodeParams['form']  : ( ($atributes['form'])  ? $atributes['form']  : null ) );


    //   if($table === null || $table === '' || !Schema::hasTable($table)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Tabela inválida.'

    //     ], 400);

    //   }


    //   $formID = $request->input('automatorFormID');
    //   $data   = $request->except([

    //     '_token',
    //     '_method',
    //     'automatorFormID',
    //     'id'

    //   ]);


    //   $insertData = [];


    //   foreach($data as $field => $value) {

    //     if(Schema::hasColumn($table, $field)) {

    //       $insertData[$field] = $value;

    //     }

    //   }


    //   if(count($insertData) <= 0) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Nenhum dado válido foi enviado.'

    //     ], 400);

    //   }


    //   // Validação de colunas únicas para storeData
    //   $uniqueColumns = $this->getUniqueColumns($table);
    //   foreach ($uniqueColumns as $column) {
    //     if (isset($insertData[$column])) {
    //       if (DB::table($table)->where($column, $insertData[$column])->exists()) {
    //         return response()->json([
    //           'status'  => false,
    //           'message' => 'O valor para o campo \'' . self::getAutomatorFormFieldNameByFormID($formID, $column) . '\' já existe.'
    //         ], 400);
    //       }
    //     }
    //   }

    //   $id = DB::table($table)->insertGetId($insertData);


    //   return response()->json([

    //     'status'  => true,
    //     'message' => 'Registro cadastrado com sucesso.',
    //     'id'      => $id

    //   ]);


    // }


    public function updateData(Request $request, $shortcodeParams = []) {


      $attributes = $this->getAutomatorRouteAttributes($request, $shortcodeParams);

      $table = $attributes['table'] ?? null;
      $index = $attributes['index'] ?? null;


      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([
          'status'  => false,
          'message' => 'Tabela inválida.'
        ], 400);

      }


      $modelClass = null;
      $modelInstance = null;


      if(isset($attributes['model']) && $attributes['model'] !== '') {

        $modelClass = $this->getAutomatorModelClassByName($attributes['model']);

      }


      if($modelClass === null) {

        $modelClass = $this->getAutomatorModelClassByTable($table);

      }


      if($modelClass !== null) {

        $modelInstance = new $modelClass;

      }


      if(($index === null || $index === '') && $modelInstance !== null) {

        $index = $modelInstance->getKeyName();

      }


      if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

        return response()->json([
          'status'  => false,
          'message' => 'Índice inválido.'
        ], 400);

      }


      $id = $request->input($index)
            ?? $request->route($index)
            ?? $request->get($index)
            ?? $request->input('id')
            ?? $request->route('id')
            ?? $request->get('id')
            ?? null;


      if($id === null || $id === '') {

        return response()->json([
          'status'  => false,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
          'message' => SysAutomator::SysAutomatorGetTranslateWord('ID não informado.'),
          'data'    => $request->all()
        ], 400);

      }


      $formID = $request->input('automatorFormID');

      $formRules = $this->getAutomatorFormFieldsRules($formID);

      $data = $request->except([
        '_token',
        '_method',
        'automatorFormID',
        'id'
      ]);


      $validationResponse = $this->validateAutomatorFormData($data, $formRules, $table, $id, $index);

      if($validationResponse !== null) {

        return $validationResponse;

      }


      $with = $attributes['with'] ?? null;

      $syncRelationships = [];


      if($with !== null && $with !== '') {

        if(is_string($with)) {

          $with = explode(',', $with);

        }


        if(is_array($with)) {

          foreach($with as $relationshipConfig) {

            $relationshipConfig = trim($relationshipConfig);

            if($relationshipConfig === '') {

              continue;

            }


            $relationshipName = $relationshipConfig;
            $relationshipMode = null;


            if(strpos($relationshipConfig, ':') !== false) {

              $relationshipParts = explode(':', $relationshipConfig);

              $relationshipName = trim($relationshipParts[0] ?? '');
              $relationshipMode = trim($relationshipParts[1] ?? '');

            }


            if($relationshipName === '' || $relationshipMode !== 'ids') {

              continue;

            }


            $syncRelationships[] = [
              'relationship' => $relationshipName,
              'field'        => $relationshipName . 'IDs'
            ];

          }

        }

      }


      $updateData = [];


      foreach($data as $field => $value) {

        if(!Schema::hasColumn($table, $field) || $field == $index) {

          continue;

        }


        $fieldRules = $formRules[$field] ?? [];
        $props      = $fieldRules['props'] ?? [];
        $required   = $fieldRules['required'] ?? false;


        if(($value === null || $value === '') && !$required) {

          continue;

        }


        if(is_array($value)) {

          continue;

        }


        if(isset($props['cast']) && $props['cast'] === 'hash') {

          if($value !== null && $value !== '') {

            $value = Hash::make($value);

          }

        }


        $updateData[$field] = $value;

      }


      $filteredSyncRelationships = [];


      foreach($syncRelationships as $syncRelationship) {

        $fieldName = $syncRelationship['field'];

        $fieldWasSent = $request->has($fieldName);
        $fieldRequired = isset($formRules[$fieldName]) && ($formRules[$fieldName]['required'] ?? false);


        if(!$fieldWasSent && !$fieldRequired) {

          continue;

        }


        $filteredSyncRelationships[] = $syncRelationship;

      }


      $syncRelationships = $filteredSyncRelationships;

      $hasRelationshipSync = count($syncRelationships) >= 1;


      if(count($updateData) <= 0 && !$hasRelationshipSync) {

        return response()->json([
          'status'  => false,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Nenhuma informação válida foi enviada.')
        ], 400);

      }


      try {

        DB::beginTransaction();


        if(count($updateData) >= 1) {

          DB::table($table)->where($index, $id)->update($updateData);

        }


        if($hasRelationshipSync) {

          if($modelClass === null || $modelInstance === null) {

            DB::rollBack();

            return response()->json([
              'status'  => false,
              'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
              'message' => 'Nenhuma Model foi encontrada para sincronizar os relacionamentos.'
            ], 400);

          }


          $modelItem = $modelClass::where($index, $id)->first();


          if(!$modelItem) {

            DB::rollBack();

            return response()->json([
              'status'  => false,
              'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
              'message' => 'Registro não encontrado para sincronizar os relacionamentos.'
            ], 404);

          }


          foreach($syncRelationships as $syncRelationship) {

            $relationshipName = $syncRelationship['relationship'];
            $fieldName        = $syncRelationship['field'];


            if(!method_exists($modelItem, $relationshipName)) {

              continue;

            }


            $ids = $request->input($fieldName, []);


            if($ids === null || $ids === '') {

              $ids = [];

            }


            if(!is_array($ids)) {

              $ids = [$ids];

            }


            $ids = array_values(array_filter($ids, function($value) {
              return $value !== null && $value !== '';
            }));


            $ids = array_map(function($value) {
              return (int) $value;
            }, $ids);


            $ids = array_values(array_unique($ids));


            $modelItem->{$relationshipName}()->sync($ids);

          }

        }


        DB::commit();


        return response()->json([
          'status'  => true,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('SUCESSO'),
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Registro atualizado com sucesso.')
        ]);


      } catch(\Throwable $e) {

        DB::rollBack();

        return response()->json([
          'status'  => false,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
          'message' => $e->getMessage()
        ], 500);

      }


    }

    // Update 2
    // public function updateData(Request $request, $shortcodeParams = []) {


    //   $slug = $request->route('pageSlug');

    //   $routeName = str_replace('page-', '', $slug);

    //   $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

    //   $atributes = [];

    //   if($route && isset($route->tbl_sys_route_content)) {

    //     $atributes = SysAutomator::SysAutomatorGetShortcodeAttributes($route->tbl_sys_route_content);

    //   }


    //   if(!is_array($shortcodeParams)) {

    //     $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

    //   }


    //   if(is_array($shortcodeParams) && count($shortcodeParams) >= 1) {

    //     foreach($shortcodeParams as $paramKey => $paramValue) {

    //       $atributes[$paramKey] = $paramValue;

    //     }

    //   }


    //   $table = $atributes['table'] ?? null;
    //   $index = $atributes['index'] ?? null;


    //   if($table === null || $table === '' || !Schema::hasTable($table)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Tabela inválida.'

    //     ], 400);

    //   }


    //   $modelClass = null;
    //   $modelInstance = null;


    //   if(isset($atributes['model']) && $atributes['model'] !== '') {

    //     $modelClass = $this->getAutomatorModelClassByName($atributes['model']);

    //   }


    //   if($modelClass === null) {

    //     $modelClass = $this->getAutomatorModelClassByTable($table);

    //   }


    //   if($modelClass !== null) {

    //     $modelInstance = new $modelClass;

    //   }


    //   if(($index === null || $index === '') && $modelInstance !== null) {

    //     $index = $modelInstance->getKeyName();

    //   }


    //   if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Índice inválido.'

    //     ], 400);

    //   }


    //   $id = $request->input($index) ?? $request->route($index) ?? $request->get($index) ?? $request->input('id') ?? $request->route('id') ?? $request->get('id') ?? null;


    //   if($id === null || $id === '') {

    //     return response()->json([

    //       'status'  => false,
    //       'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('ID não informado.'),
    //       'data'    => $request->all()

    //     ], 400);

    //   }


    //   $formID = $request->input('automatorFormID');

    //   $data = $request->except([

    //     '_token',
    //     '_method',
    //     'automatorFormID',
    //     'id'

    //   ]);


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Relacionamentos enviados pelo shortcode
    //   |--------------------------------------------------------------------------
    //   |
    //   | Exemplo:
    //   | [automator function="update-data" table="tbl_users" index="tbl_user_ID" with="UserGetTypes:ids"]
    //   |
    //   | O campo esperado no formulário será:
    //   | UserGetTypesIDs[]
    //   |
    //   */

    //   $with = $atributes['with'] ?? null;

    //   $syncRelationships = [];


    //   if($with !== null && $with !== '') {

    //     if(is_string($with)) {

    //       $with = explode(',', $with);

    //     }


    //     if(is_array($with) && count($with) >= 1) {

    //       foreach($with as $relationshipConfig) {

    //         $relationshipConfig = trim($relationshipConfig);

    //         if($relationshipConfig === '') {

    //           continue;

    //         }


    //         $relationshipName = $relationshipConfig;
    //         $relationshipMode = null;


    //         if(strpos($relationshipConfig, ':') !== false) {

    //           $relationshipParts = explode(':', $relationshipConfig);

    //           $relationshipName = trim($relationshipParts[0] ?? '');
    //           $relationshipMode = trim($relationshipParts[1] ?? '');

    //         }


    //         if($relationshipName === '' || $relationshipMode !== 'ids') {

    //           continue;

    //         }


    //         $fieldName = $relationshipName . 'IDs';


    //         $syncRelationships[] = [

    //           'relationship' => $relationshipName,
    //           'field'        => $fieldName

    //         ];

    //       }

    //     }

    //   }


    //   $updateData = [];


    //   foreach($data as $field => $value) {

    //     if(Schema::hasColumn($table, $field) && $field != $index) {

    //       $updateData[$field] = $value;

    //     }

    //   }


    //   $hasRelationshipSync = count($syncRelationships) >= 1;


    //   if(count($updateData) <= 0 && !$hasRelationshipSync) {

    //     return response()->json([

    //       'status'  => false,
    //       'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Nenhuma informação válida foi enviada.')

    //     ], 400);

    //   }


    //   $uniqueColumns = $this->getUniqueColumns($table);

    //   foreach($uniqueColumns as $column) {

    //     if(isset($updateData[$column])) {

    //       $query = DB::table($table)->where($column, $updateData[$column]);

    //       $query->where($index, '!=', $id);

    //       if($query->exists()) {

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('O valor para o campo') . " '" . self::getAutomatorFormFieldNameByFormID($formID, $column) . "' " . SysAutomator::SysAutomatorGetTranslateWord('já existe em outro registro.')

    //         ], 400);

    //       }

    //     }

    //   }


    //   try {

    //     DB::beginTransaction();


    //     if(count($updateData) >= 1) {

    //       DB::table($table)->where($index, $id)->update($updateData);

    //     }


    //     if($hasRelationshipSync) {

    //       if($modelClass === null || $modelInstance === null) {

    //         DB::rollBack();

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //           'message' => 'Nenhuma Model foi encontrada para sincronizar os relacionamentos.'

    //         ], 400);

    //       }


    //       $modelItem = $modelClass::where($index, $id)->first();


    //       if(!$modelItem) {

    //         DB::rollBack();

    //         return response()->json([

    //           'status'  => false,
    //           'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //           'message' => 'Registro não encontrado para sincronizar os relacionamentos.'

    //         ], 404);

    //       }


    //       foreach($syncRelationships as $syncRelationship) {

    //         $relationshipName = $syncRelationship['relationship'];
    //         $fieldName        = $syncRelationship['field'];


    //         if(!method_exists($modelItem, $relationshipName)) {

    //           continue;

    //         }


    //         $ids = $request->input($fieldName, []);


    //         if($ids === null || $ids === '') {

    //           $ids = [];

    //         }


    //         if(!is_array($ids)) {

    //           $ids = [$ids];

    //         }


    //         $ids = array_values(array_filter($ids, function($value) {

    //           return $value !== null && $value !== '';

    //         }));


    //         $ids = array_map(function($value) {

    //           return (int) $value;

    //         }, $ids);


    //         $modelItem->{$relationshipName}()->sync($ids);

    //       }

    //     }


    //     DB::commit();


    //     return response()->json([

    //       'status'  => true,
    //       'title'   => SysAutomator::SysAutomatorGetTranslateWord('SUCESSO'),
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Registro atualizado com sucesso.')

    //     ]);


    //   } catch(\Throwable $e) {

    //     DB::rollBack();

    //     return response()->json([

    //       'status'  => false,
    //       'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //       'message' => $e->getMessage()

    //     ], 500);

    //   }


    // }

    // public function updateData(Request $request, $shortcodeParams = []) {


    //   $slug = $request->route('pageSlug');

    //   $routeName = str_replace('page-', '', $slug);

    //   $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

    //   $atributes = SysAutomator::SysAutomatorGetShortcodeAttributes($route->tbl_sys_route_content);

    //   if(!is_array($shortcodeParams)) {

    //     $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

    //   }


    //   $table = ( ( isset($shortcodeParams['table']) ) ? $shortcodeParams['table'] : ( ($atributes['table']) ? $atributes['table'] : null ) );
    //   $index = ( ( isset($shortcodeParams['index']) ) ? $shortcodeParams['index'] : ( ($atributes['index']) ? $atributes['index'] : null ) );
    //   $id = $request->input($atributes['index']) ?? null;
    //   // $id    = ( ($request->route('id')) ? $request->route('id') : ( ($request->get('id')) ? $request->get('id') : ( ($request->input($atributes['index'])) ? $request->input($atributes['index']) : null ) ) );
    //   // $table = $shortcodeParams['table'] ?? null;
    //   // $index = $shortcodeParams['index'] ?? null;
    //   // $id    = $request->route('id') ?? $request->get('id') ?? null;


    //   if($table === null || $table === '' || !Schema::hasTable($table)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Tabela inválida.'

    //     ], 400);

    //   }


    //   if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Índice inválido.'

    //     ], 400);

    //   }


    //   if($id === null || $id === '') {

    //     return response()->json([

    //       'status'  => false,
    //       'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('ID não informado.'),
    //       'data' => $request->all()

    //     ], 400);

    //   }


    //   $formID = $request->input('automatorFormID');
    //   $data   = $request->except([

    //     '_token',
    //     '_method',
    //     'automatorFormID',
    //     'id'

    //   ]);


    //   $updateData = [];


    //   foreach($data as $field => $value) {

    //     if(Schema::hasColumn($table, $field) && $field != $index) {

    //       $updateData[$field] = $value;

    //     }

    //   }


    //   if(count($updateData) <= 0) {

    //     return response()->json([

    //       'status'  => false,
    //       'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //       'message' => SysAutomator::SysAutomatorGetTranslateWord('Nenhuma informação válida foi enviada.')

    //     ], 400);

    //   }


    //   // Validação de colunas únicas para updateData
    //   $uniqueColumns = $this->getUniqueColumns($table);
    //   foreach ($uniqueColumns as $column) {
    //     if (isset($updateData[$column])) {
    //       $query = DB::table($table)->where($column, $updateData[$column]);
    //       // Excluir o registro atual da validação
    //       $query->where($index, '!=', $id);
    //       if ($query->exists()) {
    //         return response()->json([
    //           'status'  => false,
    //           'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
    //           'message' => SysAutomator::SysAutomatorGetTranslateWord('O valor para o campo') . " '" . self::getAutomatorFormFieldNameByFormID($formID, $column) . "' " . SysAutomator::SysAutomatorGetTranslateWord('já existe em outro registro.')
    //         ], 400);
    //       }
    //     }
    //   }

    //   DB::table($table)->where($index, $id)->update($updateData);


    //   return response()->json([

    //     'status'  => true,
    //     'title'   => SysAutomator::SysAutomatorGetTranslateWord('SUCESSO'),
    //     'message' => SysAutomator::SysAutomatorGetTranslateWord('Registro atualizado com sucesso.')

    //   ]);


    // }



    public function deleteData(Request $request, $shortcodeParams = []) {


      if(!is_array($shortcodeParams)) {

        $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

      }


      $table = $shortcodeParams['table'] ?? null;
      $index = $shortcodeParams['index'] ?? null;
      $id    = $request->route('id') ?? $request->get('id') ?? null;


      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([

          'status'  => false,
          'message' => 'Tabela inválida.'

        ], 400);

      }


      if($index === null || $index === '' || !Schema::hasColumn($table, $index)) {

        return response()->json([

          'status'  => false,
          'message' => 'Índice inválido.'

        ], 400);

      }


      if($id === null || $id === '') {

        return response()->json([

          'status'  => false,
          'message' => 'ID não informado.'

        ], 400);

      }


      DB::table($table)->where($index, $id)->delete();


      return response()->json([

        'status'  => true,
        'message' => 'Registro removido com sucesso.'

      ]);


    }



  }