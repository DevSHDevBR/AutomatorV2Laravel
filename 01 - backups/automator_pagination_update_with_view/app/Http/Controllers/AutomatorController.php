<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\Cache;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Schema;
  use Illuminate\Support\Str;

  use App\Helpers\SysAutomator;



  class AutomatorController extends Controller {



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


      $response = SysAutomator::SysAutomatorRenderPaginationByName($name, $requestArgs);


      if(is_array($response) && isset($response['html'])) {

        return $response['html'];

      }


      return '';


    }



    public function getFunction(Request $request, $shortcodeParams = []) {


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

      return SysAutomator::SysAutomatorSearchShortcode($slug, [

        'request' => $request

      ]);


    }



    public function getData(Request $request, $shortcodeParams = []) {


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


      if(!is_array($shortcodeParams)) {

        $shortcodeParams = $request->attributes->get('automator_shortcode_params', []);

      }


      $table = $shortcodeParams['table'] ?? null;


      if($table === null || $table === '' || !Schema::hasTable($table)) {

        return response()->json([

          'status'  => false,
          'message' => 'Tabela inválida.'

        ], 400);

      }


      $data = $request->except([

        '_token',
        '_method',
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


      $id = DB::table($table)->insertGetId($insertData);


      return response()->json([

        'status'  => true,
        'message' => 'Registro cadastrado com sucesso.',
        'id'      => $id

      ]);


    }



    public function updateData(Request $request, $shortcodeParams = []) {


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


      $data = $request->except([

        '_token',
        '_method',
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
          'message' => 'Nenhum dado válido foi enviado.'

        ], 400);

      }


      DB::table($table)->where($index, $id)->update($updateData);


      return response()->json([

        'status'  => true,
        'message' => 'Registro atualizado com sucesso.'

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