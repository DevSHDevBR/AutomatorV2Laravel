<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
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


      if($id !== null && $id !== '') {

        $item = $modelClass::where($index, $id)->first();

        return response()->json([

          'status' => ($item !== null),
          'data'   => $item

        ]);

      }


      $items = $modelClass::get();


      return response()->json([

        'status' => true,
        'data'   => $items

      ]);


    }


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


      // return $request;
      /*
      |--------------------------------------------------------------------------
      | Quando vier de um shortcode
      |--------------------------------------------------------------------------
      |
      | Exemplo:
      | [automator function="pagination" name="shortcodes-pagination"]
      |
      | O shortcode é cadastrado no banco como:
      | class  = AutomatorController
      | method = getFunction
      |
      | Então esta função precisa identificar o atributo "function" e chamar
      | a função correspondente dentro deste mesmo controller.
      |
      */

      if(!is_array($shortcodeParams) || count($shortcodeParams) <= 0) {

        $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

      }



      if(is_array($shortcodeParams) && count($shortcodeParams) >= 1 && isset($shortcodeParams['function'])) {


        // return $shortcodeParams;
        $function = trim($shortcodeParams['function']);


        if($function == '') {

          return '';

        }


        /*
        |--------------------------------------------------------------------------
        | Normaliza nomes com hífen
        |--------------------------------------------------------------------------
        |
        | pagination  => pagination
        | get-data    => getData
        | store-data  => storeData
        | update-data => updateData
        | delete-data => deleteData
        |
        */

        $method = Str::camel($function);

        // return $method;


        /*
        |--------------------------------------------------------------------------
        | Lista de funções permitidas para shortcode automator
        |--------------------------------------------------------------------------
        |
        | Evita que qualquer método público do controller seja chamado apenas
        | alterando o conteúdo do shortcode no banco.
        |
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


        if(!in_array($method, $allowedMethods)) {

          return '';

        }


        if(!method_exists($this, $method)) {

          return '';

        }


        return $this->{$method}($request, $shortcodeParams);


      }


      /*
      |--------------------------------------------------------------------------
      | Quando vier diretamente da rota
      |--------------------------------------------------------------------------
      |
      | Exemplo:
      | rota admin-shortcodes chama AutomatorController@getFunction.
      | Nesse caso, renderiza o conteúdo da rota e processa os shortcodes
      | cadastrados dentro da coluna tbl_sys_route_content.
      |
      */

      $slug = $request->route('pageSlug');

      // return $slug;

      return SysAutomator::SysAutomatorSearchShortcode($slug, [

        'request' => $request

      ]);


    }



    public function pagination(Request $request, $shortcodeParams = []) {


      if(!is_array($shortcodeParams)) {

        $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

      }


      if(!is_array($shortcodeParams)) {

        $shortcodeParams = [];

      }


      $name = $shortcodeParams['name'] ?? $request->get('name') ?? null;


      if($name === null || $name === '') {

        return '';

      }


      $requestArgs = $request->all();


      foreach($shortcodeParams as $paramKey => $paramValue) {

        if(!array_key_exists($paramKey, $requestArgs)) {

          $requestArgs[$paramKey] = $paramValue;

        }

      }

      // dd($requestArgs);
      $response = SysAutomator::SysAutomatorRenderPaginationByName($name, $requestArgs);


      if(is_array($response) && isset($response['html'])) {

        return $response['html'];

      } else {

        if($response['status'] == false) {
          
          $html = '<div class="text-center py-10">' . "\n";

            $html .= '<h2 class="text-3xl font-bold text-gray-800 mb-4">' . $response['message'] . '</h2>' . "\n";
            $html .= '<p class="text-gray-600">A página utiliza a automação de paginação de resultados <strong>' . $name . '</strong> porem a configuração desta página não foi encontrada ou não está disponível.</p>' . "\n";
            $html .= '<p class="text-gray-600">Por favor, verifique o endereço ou entre em contato com o suporte.</p>' . "\n";
            
          $html .= '</div>' . "\n";
          return $html;

        }

      }


      return '';


    }



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




    public function storeData(Request $request, $shortcodeParams = []) {


      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);

      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

      $atributes = SysAutomator::SysAutomatorGetShortcodeAttributes($route->tbl_sys_route_content);

      if(!is_array($shortcodeParams)) {

        $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

      }


      $table = ( ( isset($shortcodeParams['table']) ) ? $shortcodeParams['table'] : ( ($atributes['table']) ? $atributes['table'] : null ) );
      // $form  = ( ( isset($shortcodeParams['form']) )  ? $shortcodeParams['form']  : ( ($atributes['form'])  ? $atributes['form']  : null ) );


      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([

          'status'  => false,
          'message' => 'Tabela inválida.'

        ], 400);

      }


      $formID = $request->input('automatorFormID');
      $data   = $request->except([

        '_token',
        '_method',
        'automatorFormID',
        'id'

      ]);


      $insertData = [];


      foreach($data as $field => $value) {

        if(Schema::hasColumn($table, $field)) {

          $insertData[$field] = $value;

        }

      }


      if(count($insertData) <= 0) {

        return response()->json([

          'status'  => false,
          'message' => 'Nenhum dado válido foi enviado.'

        ], 400);

      }


      // Validação de colunas únicas para storeData
      $uniqueColumns = $this->getUniqueColumns($table);
      foreach ($uniqueColumns as $column) {
        if (isset($insertData[$column])) {
          if (DB::table($table)->where($column, $insertData[$column])->exists()) {
            return response()->json([
              'status'  => false,
              'message' => 'O valor para o campo \'' . self::getAutomatorFormFieldNameByFormID($formID, $column) . '\' já existe.'
            ], 400);
          }
        }
      }

      $id = DB::table($table)->insertGetId($insertData);


      return response()->json([

        'status'  => true,
        'message' => 'Registro cadastrado com sucesso.',
        'id'      => $id

      ]);


    }



    public function updateData(Request $request, $shortcodeParams = []) {


      $slug = $request->route('pageSlug');

      $routeName = str_replace('page-', '', $slug);

      $route = SysRoute::where('tbl_sys_route_name', $routeName)->first();

      $atributes = SysAutomator::SysAutomatorGetShortcodeAttributes($route->tbl_sys_route_content);

      if(!is_array($shortcodeParams)) {

        $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

      }


      $table = ( ( isset($shortcodeParams['table']) ) ? $shortcodeParams['table'] : ( ($atributes['table']) ? $atributes['table'] : null ) );
      $index = ( ( isset($shortcodeParams['index']) ) ? $shortcodeParams['index'] : ( ($atributes['index']) ? $atributes['index'] : null ) );
      $id = $request->input($atributes['index']) ?? null;
      // $id    = ( ($request->route('id')) ? $request->route('id') : ( ($request->get('id')) ? $request->get('id') : ( ($request->input($atributes['index'])) ? $request->input($atributes['index']) : null ) ) );
      // $table = $shortcodeParams['table'] ?? null;
      // $index = $shortcodeParams['index'] ?? null;
      // $id    = $request->route('id') ?? $request->get('id') ?? null;


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
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
          'message' => SysAutomator::SysAutomatorGetTranslateWord('ID não informado.'),
          'data' => $request->all()

        ], 400);

      }


      $formID = $request->input('automatorFormID');
      $data   = $request->except([

        '_token',
        '_method',
        'automatorFormID',
        'id'

      ]);


      $updateData = [];


      foreach($data as $field => $value) {

        if(Schema::hasColumn($table, $field) && $field != $index) {

          $updateData[$field] = $value;

        }

      }


      if(count($updateData) <= 0) {

        return response()->json([

          'status'  => false,
          'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Nenhuma informação válida foi enviada.')

        ], 400);

      }


      // Validação de colunas únicas para updateData
      $uniqueColumns = $this->getUniqueColumns($table);
      foreach ($uniqueColumns as $column) {
        if (isset($updateData[$column])) {
          $query = DB::table($table)->where($column, $updateData[$column]);
          // Excluir o registro atual da validação
          $query->where($index, '!=', $id);
          if ($query->exists()) {
            return response()->json([
              'status'  => false,
              'title'   => SysAutomator::SysAutomatorGetTranslateWord('ERRO'),
              'message' => SysAutomator::SysAutomatorGetTranslateWord('O valor para o campo') . " '" . self::getAutomatorFormFieldNameByFormID($formID, $column) . "' " . SysAutomator::SysAutomatorGetTranslateWord('já existe em outro registro.')
            ], 400);
          }
        }
      }

      DB::table($table)->where($index, $id)->update($updateData);


      return response()->json([

        'status'  => true,
        'title'   => SysAutomator::SysAutomatorGetTranslateWord('SUCESSO'),
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Registro atualizado com sucesso.')

      ]);


    }



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