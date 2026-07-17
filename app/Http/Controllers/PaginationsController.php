<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Helpers\SysAutomator;

use App\Models\SysFieldType;
use App\Models\SysPagination;
use App\Models\SysPaginationsArg;
use App\Models\SysPaginationsCol;
use App\Models\SysPaginationsColsAccess;
use App\Models\UsersType;


class PaginationsController extends Controller {


  /*
  |--------------------------------------------------------------------------
  | Retorna uma paginação para o editor
  |--------------------------------------------------------------------------
  */

  public function getPagination(
    Request $request,
    $id = null
  ) {


    $paginationID = $this->resolvePaginationEditorID(

      $request,

      $id

    );


    if($paginationID === null) {


      return response()->json([

        'status'  => false,

        'result'  => false,

        'title'   => SysAutomator::SysAutomatorGetTranslateWord(
          'Paginação inválida'
        ),

        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'O ID da paginação não foi informado ou é inválido.'
        ),

        'data' => [],

      ], 400);


    }


    $pagination = SysPagination::where(

      'tbl_sys_pagination_ID',

      $paginationID

    )->first();


    if($pagination === null) {


      return response()->json([

        'status'  => false,

        'result'  => false,

        'title'   => SysAutomator::SysAutomatorGetTranslateWord(
          'Paginação não encontrada'
        ),

        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'A paginação que você está tentando editar não foi encontrada.'
        ),

        'data' => [],

      ], 404);


    }


    $recordData = $this->preparePaginationEditorRecord(

      $pagination

    );


    return response()->json([

      'status'  => true,

      'result'  => true,

      'title'   => SysAutomator::SysAutomatorGetTranslateWord(
        'Paginação encontrada'
      ),

      'message' => SysAutomator::SysAutomatorGetTranslateWord(
        'Os dados da paginação foram carregados com sucesso.'
      ),

      'acao' => 'update',

      'paginationID' => $pagination->tbl_sys_pagination_ID,

      'tbl_sys_pagination_ID' => $pagination->tbl_sys_pagination_ID,

      'data' => $recordData,

    ], 200);


  }


  /*
  |--------------------------------------------------------------------------
  | Resolve o ID utilizado pelo editor
  |--------------------------------------------------------------------------
  */

  private function resolvePaginationEditorID(
    Request $request,
    $methodID = null
  ) {


    $candidates = [

      $request->input(
        'tbl_sys_pagination_ID'
      ),

      $request->input(
        'paginationID'
      ),

      $request->input(
        'pagination_id'
      ),

      $request->input(
        'id'
      ),

      $request->route(
        'id'
      ),

      $methodID,

    ];


    foreach($candidates as $candidate) {


      if(
        $candidate === null ||
        $candidate === ''
      ) {

        continue;

      }


      if(
        is_int($candidate) ||
        (
          is_string($candidate) &&
          ctype_digit(trim($candidate))
        )
      ) {


        $candidate = (int) $candidate;


        if($candidate > 0) {

          return $candidate;

        }


      }


    }


    return null;


  }


  /*
  |--------------------------------------------------------------------------
  | Prepara todos os dados da paginação
  |--------------------------------------------------------------------------
  */

  private function preparePaginationEditorRecord(
    SysPagination $pagination
  ): array {


    $paginationData = $pagination->toArray();


    $paginationData['id'] =

      $pagination->tbl_sys_pagination_ID;


    $paginationData['paginationID'] =

      $pagination->tbl_sys_pagination_ID;


    $paginationData['pagination_id'] =

      $pagination->tbl_sys_pagination_ID;


    $paginationData['tbl_sys_pagination_ID'] =

      $pagination->tbl_sys_pagination_ID;


    /*
    |--------------------------------------------------------------------------
    | Argumentos
    |--------------------------------------------------------------------------
    */

    $arguments = SysPaginationsArg::where(

      'tbl_sys_pagination_ID',

      $pagination->tbl_sys_pagination_ID

    )
      ->orderBy(
        'tbl_sys_paginations_arg_ID',
        'asc'
      )
      ->get();


    $normalizedArguments = [];


    foreach($arguments as $argument) {


      $argumentName = trim((string)

        $argument->tbl_sys_paginations_arg_name

      );


      if($argumentName === '') {

        continue;

      }


      $argumentValue =

        $this->decodePaginationEditorValue(

          $argument->tbl_sys_paginations_arg_value

        );


      $normalizedArguments[$argumentName] =

        $argumentValue;


      /*
      |--------------------------------------------------------------------------
      | Mantém também a chave direta para preencher os campos do editor
      |--------------------------------------------------------------------------
      */

      $paginationData[$argumentName] =

        $argumentValue;


    }


    $paginationData['pagination_args'] =

      $normalizedArguments;


    $paginationData['actions'] =

      $this->normalizePaginationEditorObject(

        $normalizedArguments['actions'] ?? []

      );


    $paginationData['header_actions'] =

      $this->normalizePaginationEditorList(

        $normalizedArguments['header_actions'] ?? []

      );


    $paginationData['list_actions'] =

      $this->normalizePaginationEditorList(

        $normalizedArguments['list_actions'] ?? []

      );


    /*
    |--------------------------------------------------------------------------
    | Colunas
    |--------------------------------------------------------------------------
    */

    $columns = SysPaginationsCol::where(

      'tbl_sys_pagination_ID',

      $pagination->tbl_sys_pagination_ID

    )
      ->orderBy(
        'tbl_sys_paginations_col_ordem',
        'asc'
      )
      ->orderBy(
        'tbl_sys_paginations_col_ID',
        'asc'
      )
      ->get();


    $normalizedColumns = [];


    foreach($columns as $columnIndex => $column) {


      $normalizedColumns[] =

        $this->preparePaginationEditorColumn(

          $column,

          $columnIndex

        );


    }


    $paginationData['columns'] =

      $normalizedColumns;


    $paginationData['cols'] =

      $normalizedColumns;


    $paginationData['pagination_columns'] =

      $normalizedColumns;


    /*
    |--------------------------------------------------------------------------
    | Tipos de usuários
    |--------------------------------------------------------------------------
    */

    $paginationData = array_merge(

      $paginationData,

      $this->preparePaginationEditorSecurityData()

    );


    return $paginationData;


  }


  /*
  |--------------------------------------------------------------------------
  | Prepara uma coluna
  |--------------------------------------------------------------------------
  */

  private function preparePaginationEditorColumn(
    SysPaginationsCol $column,
    int $columnIndex = 0
  ): array {


    $columnData = $column->toArray();


    $fieldType = SysFieldType::where(

      'tbl_sys_field_type_ID',

      $column->tbl_sys_field_type_ID

    )->first();


    $fieldTypeData =

      $fieldType !== null

        ? $fieldType->toArray()

        : [];


    $fieldTypePagination =

      $this->decodePaginationEditorValue(

        $fieldTypeData[
          'tbl_sys_field_type_pagination'
        ] ?? []

      );


    if(!is_array($fieldTypePagination)) {

      $fieldTypePagination = [];

    }


    $access = SysPaginationsColsAccess::where(

      'tbl_sys_paginations_col_ID',

      $column->tbl_sys_paginations_col_ID

    )
      ->pluck(
        'tbl_users_type_ID'
      )
      ->map(function($userTypeID) {

        return (string) $userTypeID;

      })
      ->values()
      ->toArray();


    /*
    |--------------------------------------------------------------------------
    | Estrutura utilizada atualmente pelo JavaScript
    |--------------------------------------------------------------------------
    */

    return [

      'id' =>

        'pagination-column-' .

        $column->tbl_sys_paginations_col_ID,


      'database_id' =>

        $column->tbl_sys_paginations_col_ID,


      'tbl_sys_paginations_col_ID' =>

        $column->tbl_sys_paginations_col_ID,


      'tbl_sys_pagination_ID' =>

        $column->tbl_sys_pagination_ID,


      'type_id' =>

        $column->tbl_sys_field_type_ID,


      'tbl_sys_field_type_ID' =>

        $column->tbl_sys_field_type_ID,


      'type' =>

        $fieldTypeData[
          'tbl_sys_field_type_name'
        ] ?? '',


      'field_type' =>

        $fieldTypeData[
          'tbl_sys_field_type_name'
        ] ?? '',


      'icon' =>

        $fieldTypeData[
          'tbl_sys_field_type_icon'
        ] ?? 'table-columns',


      'type_title' =>

        $fieldTypeData[
          'tbl_sys_field_type_title'
        ] ?? 'Coluna',


      'field_type_title' =>

        $fieldTypeData[
          'tbl_sys_field_type_title'
        ] ?? 'Coluna',


      'name' =>

        $column->tbl_sys_paginations_col_name ?? '',


      'label' =>

        $column->tbl_sys_paginations_col_title ?? '',


      'title' =>

        $column->tbl_sys_paginations_col_title ?? '',


      'order' =>

        $column->tbl_sys_paginations_col_ordem ??

        $columnIndex,


      'pagination' =>

        $fieldTypePagination,


      'values' => [

        'header' =>

          $this->normalizePaginationEditorObject(

            $column->tbl_sys_paginations_col_header ?? []

          ),

        'body' =>

          $this->normalizePaginationEditorObject(

            $column->tbl_sys_paginations_col_body ?? []

          ),

        'props' =>

          $this->normalizePaginationEditorObject(

            $column->tbl_sys_paginations_col_props ?? []

          ),

        'canSearch' => [

          'search' =>

            $this->normalizePaginationEditorBoolean(

              $column->tbl_sys_paginations_col_search ?? false

            ),

        ],

        'canSort' => [

          'sort' =>

            $this->normalizePaginationEditorBoolean(

              $column->tbl_sys_paginations_col_sort ?? false

            ),

        ],

      ],


      'attrs' =>

        $this->normalizePaginationEditorObject(

          $column->tbl_sys_paginations_col_attrs ?? []

        ),


      'access' =>

        $access,


      'user_types' =>

        $access,


      'isActionButtonsColumn' => false,

      'buttons' => [],

    ];


  }


  /*
  |--------------------------------------------------------------------------
  | Tipos de usuário e usuário atual
  |--------------------------------------------------------------------------
  */

  private function preparePaginationEditorSecurityData(): array {


    $userTypes = UsersType::query()
      ->orderBy(
        'tbl_users_type_ID',
        'asc'
      )
      ->get()
      ->map(function($userType) {


        $userTypeID =

          (string) $userType->tbl_users_type_ID;


        $userTypeName =

          (string) $userType->tbl_users_type_name;


        return [

          'id' => $userTypeID,

          'name' => $userTypeName,

          'tbl_users_type_ID' => $userTypeID,

          'tbl_users_type_name' => $userTypeName,

          'isDeveloper' =>

            mb_strtolower(

              trim($userTypeName)

            ) === 'desenvolvedor',

        ];


      })
      ->values()
      ->toArray();


    $currentUser = Auth::user();


    $currentUserTypeName = '';


    if($currentUser !== null) {


      $currentUserTypeID =

        $currentUser->tbl_users_type_ID ??

        $currentUser->tbl_user_type_ID ??

        null;


      if($currentUserTypeID !== null) {


        $currentUserTypeName =

          (string) UsersType::where(

            'tbl_users_type_ID',

            $currentUserTypeID

          )->value(

            'tbl_users_type_name'

          );


      }


    }


    return [

      'userTypes' => $userTypes,

      'user_types' => $userTypes,

      'currentUser' => [

        'id' =>

          $currentUser->tbl_user_ID ??

          $currentUser->id ??

          null,

        'isDeveloper' =>

          mb_strtolower(

            trim($currentUserTypeName)

          ) === 'desenvolvedor',

      ],

    ];


  }


  /*
  |--------------------------------------------------------------------------
  | Decodifica valores JSON sem afetar strings comuns
  |--------------------------------------------------------------------------
  */

  private function decodePaginationEditorValue(
    $value
  ) {


    if(
      $value === null ||
      $value === ''
    ) {

      return $value;

    }


    if(is_array($value)) {

      return $value;

    }


    if(is_object($value)) {

      return (array) $value;

    }


    if(!is_string($value)) {

      return $value;

    }


    $trimmedValue = trim($value);


    if($trimmedValue === '') {

      return '';

    }


    $firstCharacter = substr(

      $trimmedValue,

      0,

      1

    );


    if(
      $firstCharacter !== '{' &&
      $firstCharacter !== '['
    ) {

      return $value;

    }


    $decodedValue = json_decode(

      $trimmedValue,

      true

    );


    if(json_last_error() !== JSON_ERROR_NONE) {

      return $value;

    }


    return $decodedValue;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza objeto
  |--------------------------------------------------------------------------
  */

  private function normalizePaginationEditorObject(
    $value
  ): array {


    $value = $this->decodePaginationEditorValue(

      $value

    );


    if(!is_array($value)) {

      return [];

    }


    return $value;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza lista
  |--------------------------------------------------------------------------
  */

  private function normalizePaginationEditorList(
    $value
  ): array {


    $value = $this->decodePaginationEditorValue(

      $value

    );


    if(!is_array($value)) {

      return [];

    }


    return array_values(

      $value

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza booleano
  |--------------------------------------------------------------------------
  */

  private function normalizePaginationEditorBoolean(
    $value
  ): bool {


    return in_array(

      $value,

      [

        true,
        1,
        '1',
        'true',
        'TRUE',
        'sim',
        'SIM',

      ],

      true

    );


  }



  /*
  |--------------------------------------------------------------------------
  | Cadastra uma paginação
  |--------------------------------------------------------------------------
  */

  public function storePagination(
    Request $request
  ) {


    return $this->persistPaginationEditor(

      $request,

      null

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza uma paginação
  |--------------------------------------------------------------------------
  */

  public function updatePagination(
    Request $request,
    $id = null
  ) {


    $paginationID = $this->resolvePaginationEditorID(

      $request,

      $id

    );


    if($paginationID === null) {


      return response()->json([

        'status' => false,

        'result' => false,

        'title' => SysAutomator::SysAutomatorGetTranslateWord(
          'Paginação inválida'
        ),

        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'O ID da paginação não foi informado ou é inválido.'
        ),

      ], 400);


    }


    return $this->persistPaginationEditor(

      $request,

      $paginationID

    );


  }



  /*
  |--------------------------------------------------------------------------
  | Compatibilidade com rotas REST
  |--------------------------------------------------------------------------
  */

  public function store(
    Request $request
  ) {


    return $this->storePagination(

      $request

    );


  }


  public function update(
    Request $request,
    $id = null
  ) {


    return $this->updatePagination(

      $request,

      $id

    );


  }



  /*
  |--------------------------------------------------------------------------
  | Persiste os dados do editor
  |--------------------------------------------------------------------------
  */

  private function persistPaginationEditor(
    Request $request,
    ?int $paginationID = null
  ) {


    $payload = $this->normalizePaginationEditorPayload(

      $request->all()

    );


    $validationErrors =

      $this->validatePaginationEditorPayload(

        $payload,

        $paginationID

      );


    if(count($validationErrors) > 0) {


      return response()->json([

        'status' => false,

        'result' => false,

        'title' => SysAutomator::SysAutomatorGetTranslateWord(
          'Configurações inválidas'
        ),

        'message' => implode(

          "\n",

          $validationErrors

        ),

        'errors' => $validationErrors,

      ], 422);


    }


    try {


      $pagination = DB::transaction(function() use (
        $payload,
        $paginationID
      ) {


        $paginationData = $payload[

          'pagination'

        ];


        if($paginationID === null) {


          unset(

            $paginationData[
              'tbl_sys_pagination_ID'
            ]

          );


          $pagination = SysPagination::create(

            $paginationData

          );


        } else {


          $pagination = SysPagination::where(

            'tbl_sys_pagination_ID',

            $paginationID

          )
            ->lockForUpdate()
            ->first();


          if($pagination === null) {


            return null;


          }


          $pagination->fill(

            $paginationData

          );


          $pagination->save();


        }


        $this->persistPaginationEditorArguments(

          $pagination,

          $payload[
            'pagination_args'
          ]

        );


        $this->persistPaginationEditorColumns(

          $pagination,

          $payload[
            'pagination_cols'
          ]

        );


        return $pagination;


      });


      if($pagination === null) {


        return response()->json([

          'status' => false,

          'result' => false,

          'title' => SysAutomator::SysAutomatorGetTranslateWord(
            'Paginação não encontrada'
          ),

          'message' => SysAutomator::SysAutomatorGetTranslateWord(
            'A paginação que você está tentando atualizar não foi encontrada.'
          ),

        ], 404);


      }


      return response()->json([

        'status' => true,

        'result' => true,

        'title' => SysAutomator::SysAutomatorGetTranslateWord(
          $paginationID === null
            ? 'Paginação cadastrada'
            : 'Paginação atualizada'
        ),

        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          $paginationID === null
            ? 'A paginação foi cadastrada com sucesso.'
            : 'A paginação foi atualizada com sucesso.'
        ),

        'acao' => 'update',

        'paginationID' =>

          $pagination->tbl_sys_pagination_ID,

        'pagination_id' =>

          $pagination->tbl_sys_pagination_ID,

        'tbl_sys_pagination_ID' =>

          $pagination->tbl_sys_pagination_ID,

        'data' =>

          $this->preparePaginationEditorRecord(

            $pagination->fresh()

          ),

      ], $paginationID === null ? 201 : 200);


    } catch(\Throwable $exception) {


      report(

        $exception

      );


      return response()->json([

        'status' => false,

        'result' => false,

        'title' => SysAutomator::SysAutomatorGetTranslateWord(
          'Erro ao salvar paginação'
        ),

        'message' => SysAutomator::SysAutomatorGetTranslateWord(
          'Não foi possível salvar a paginação.'
        ),

      ], 500);


    }


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza o payload recebido do editor
  |--------------------------------------------------------------------------
  */

  private function normalizePaginationEditorPayload(
    array $payload
  ): array {


    $pagination =

      $this->normalizePaginationEditorObject(

        $payload['pagination'] ?? []

      );


    $paginationArgs =

      $this->normalizePaginationEditorObject(

        $payload['pagination_args'] ?? []

      );


    $paginationCols =

      $this->normalizePaginationEditorList(

        $payload['pagination_cols'] ??

        $payload['columns'] ??

        $payload['cols'] ??

        []

      );


    $paginationFields = [

      'tbl_sys_pagination_name',
      'tbl_sys_pagination_route',
      'tbl_sys_pagination_title',
      'tbl_sys_pagination_table',
      'tbl_sys_pagination_index',
      'tbl_sys_pagination_locked',

    ];


    foreach($paginationFields as $fieldName) {


      if(
        !array_key_exists(
          $fieldName,
          $pagination
        ) &&
        array_key_exists(
          $fieldName,
          $payload
        )
      ) {

        $pagination[$fieldName] =

          $payload[$fieldName];


      }


    }


    $pagination[

      'tbl_sys_pagination_name'

    ] = trim((string) (

      $pagination[
        'tbl_sys_pagination_name'
      ] ?? ''

    ));


    $pagination[

      'tbl_sys_pagination_route'

    ] = trim((string) (

      $pagination[
        'tbl_sys_pagination_route'
      ] ?? ''

    ));


    $pagination[

      'tbl_sys_pagination_title'

    ] = trim((string) (

      $pagination[
        'tbl_sys_pagination_title'
      ] ?? ''

    ));


    $pagination[

      'tbl_sys_pagination_table'

    ] = trim((string) (

      $pagination[
        'tbl_sys_pagination_table'
      ] ?? ''

    ));


    $pagination[

      'tbl_sys_pagination_index'

    ] = trim((string) (

      $pagination[
        'tbl_sys_pagination_index'
      ] ?? ''

    ));


    $pagination[

      'tbl_sys_pagination_locked'

    ] = $this->normalizePaginationEditorBoolean(

      $pagination[
        'tbl_sys_pagination_locked'
      ] ?? false

    );


    $reservedFields = array_merge(

      $paginationFields,

      [

        'id',
        'acao',
        'editorAction',
        'paginationID',
        'pagination_id',
        'tbl_sys_pagination_ID',
        'pagination',
        'pagination_args',
        'pagination_cols',
        'columns',
        'cols',

      ]

    );


    foreach($payload as $key => $value) {


      if(
        in_array(
          $key,
          $reservedFields,
          true
        )
      ) {

        continue;

      }


      if(
        !array_key_exists(
          $key,
          $paginationArgs
        )
      ) {

        $paginationArgs[$key] =

          $value;


      }


    }


    $paginationArgs['page_name'] = trim((string) (

      $paginationArgs['page_name'] ??

      $pagination[
        'tbl_sys_pagination_route'
      ] ??

      $pagination[
        'tbl_sys_pagination_name'
      ] ??

      ''

    ));


    $paginationArgs['per_page'] = (int) (

      $paginationArgs['per_page'] ?? 15

    );


    if($paginationArgs['per_page'] <= 0) {

      $paginationArgs['per_page'] = 15;

    }


    $paginationArgs['actions'] =

      $this->normalizePaginationEditorObject(

        $paginationArgs['actions'] ??

        $payload['actions'] ??

        []

      );


    $paginationArgs['header_actions'] =

      $this->normalizePaginationEditorList(

        $paginationArgs['header_actions'] ??

        $payload['header_actions'] ??

        []

      );


    $paginationArgs['list_actions'] =

      $this->normalizePaginationEditorList(

        $paginationArgs['list_actions'] ??

        $payload['list_actions'] ??

        []

      );


    $normalizedColumns = [];


    foreach($paginationCols as $columnIndex => $column) {


      $column =

        $this->normalizePaginationEditorObject(

          $column

        );


      if(
        $this->normalizePaginationEditorBoolean(

          $column[
            'is_action_buttons_column'
          ] ??

          $column[
            'isActionButtonsColumn'
          ] ??

          false

        )
      ) {

        continue;

      }


      $normalizedColumns[] =

        $this->normalizePaginationEditorColumnPayload(

          $column,

          $columnIndex

        );


    }


    return [

      'pagination' => $pagination,

      'pagination_args' => $paginationArgs,

      'pagination_cols' => $normalizedColumns,

    ];


  }



  /*
  |--------------------------------------------------------------------------
  | Normaliza uma coluna recebida do editor
  |--------------------------------------------------------------------------
  */

  private function normalizePaginationEditorColumnPayload(
    array $column,
    int $columnIndex
  ): array {


    $columnArgs =

      $this->normalizePaginationEditorObject(

        $column[
          'tbl_sys_paginations_col_args'
        ] ??

        $column['values'] ??

        []

      );


    $header =

      $this->normalizePaginationEditorObject(

        $column[
          'tbl_sys_paginations_col_header'
        ] ??

        $columnArgs['header'] ??

        []

      );


    $body =

      $this->normalizePaginationEditorObject(

        $column[
          'tbl_sys_paginations_col_body'
        ] ??

        $columnArgs['body'] ??

        []

      );


    $props =

      $this->normalizePaginationEditorObject(

        $column[
          'tbl_sys_paginations_col_props'
        ] ??

        $columnArgs['props'] ??

        []

      );


    $attrs =

      $this->normalizePaginationEditorObject(

        $column[
          'tbl_sys_paginations_col_attrs'
        ] ??

        $column['attrs'] ??

        []

      );


    $canSearch =

      $this->normalizePaginationEditorObject(

        $columnArgs['canSearch'] ?? []

      );


    $canSort =

      $this->normalizePaginationEditorObject(

        $columnArgs['canSort'] ?? []

      );


    $access =

      $this->normalizePaginationEditorList(

        $column['access'] ??

        $column['user_types'] ??

        $column['cols_access'] ??

        []

      );


    $access = array_values(

      array_unique(

        array_filter(

          array_map(function($userTypeID) {


            return (int) $userTypeID;


          }, $access),

          function($userTypeID) {


            return $userTypeID > 0;


          }

        )

      )

    );


    return [

      'tbl_sys_paginations_col_ID' =>

        isset(
          $column[
            'tbl_sys_paginations_col_ID'
          ]
        ) &&
        is_numeric(
          $column[
            'tbl_sys_paginations_col_ID'
          ]
        )

          ? (int) $column[
              'tbl_sys_paginations_col_ID'
            ]

          : null,


      'tbl_sys_field_type_ID' =>

        (int) (

          $column[
            'tbl_sys_field_type_ID'
          ] ??

          $column['type_id'] ??

          0

        ),


      'tbl_sys_paginations_col_name' =>

        trim((string) (

          $column[
            'tbl_sys_paginations_col_name'
          ] ??

          $column['name'] ??

          ''

        )),


      'tbl_sys_paginations_col_title' =>

        trim((string) (

          $column[
            'tbl_sys_paginations_col_title'
          ] ??

          $column['label'] ??

          $column['title'] ??

          ''

        )),


      'tbl_sys_paginations_col_header' =>

        $header,


      'tbl_sys_paginations_col_body' =>

        $body,


      'tbl_sys_paginations_col_props' =>

        $props,


      'tbl_sys_paginations_col_attrs' =>

        $attrs,


      'tbl_sys_paginations_col_search' =>

        $this->normalizePaginationEditorBoolean(

          $column[
            'tbl_sys_paginations_col_search'
          ] ??

          $canSearch['search'] ??

          false

        ),


      'tbl_sys_paginations_col_sort' =>

        $this->normalizePaginationEditorBoolean(

          $column[
            'tbl_sys_paginations_col_sort'
          ] ??

          $canSort['sort'] ??

          false

        ),


      'tbl_sys_paginations_col_ordem' =>

        (int) (

          $column[
            'tbl_sys_paginations_col_ordem'
          ] ??

          $columnIndex

        ),


      'access' =>

        $access,

    ];


  }



  /*
  |--------------------------------------------------------------------------
  | Valida o payload do editor
  |--------------------------------------------------------------------------
  */

  private function validatePaginationEditorPayload(
    array $payload,
    ?int $paginationID = null
  ): array {


    $errors = [];


    $pagination =

      $payload['pagination'] ?? [];


    $columns =

      $payload['pagination_cols'] ?? [];


    $paginationName = trim((string) (

      $pagination[
        'tbl_sys_pagination_name'
      ] ?? ''

    ));


    $paginationRoute = trim((string) (

      $pagination[
        'tbl_sys_pagination_route'
      ] ?? ''

    ));


    $paginationTitle = trim((string) (

      $pagination[
        'tbl_sys_pagination_title'
      ] ?? ''

    ));


    $paginationTable = trim((string) (

      $pagination[
        'tbl_sys_pagination_table'
      ] ?? ''

    ));


    $paginationIndex = trim((string) (

      $pagination[
        'tbl_sys_pagination_index'
      ] ?? ''

    ));


    if($paginationName === '') {

      $errors[] =

        'Informe o nome da paginação.';

    }


    if(
      mb_strlen(
        $paginationName
      ) > 255
    ) {

      $errors[] =

        'O nome da paginação deve possuir no máximo 255 caracteres.';

    }


    if($paginationRoute === '') {

      $errors[] =

        'Informe a rota da paginação.';

    }


    if($paginationTitle === '') {

      $errors[] =

        'Informe o título da paginação.';

    }


    if($paginationTable === '') {

      $errors[] =

        'Selecione a tabela da paginação.';

    }


    if($paginationIndex === '') {

      $errors[] =

        'Selecione a chave primária da paginação.';

    }


    $duplicatedPagination = SysPagination::where(

      'tbl_sys_pagination_name',

      $paginationName

    );


    if($paginationID !== null) {


      $duplicatedPagination->where(

        'tbl_sys_pagination_ID',

        '!=',

        $paginationID

      );


    }


    if(
      $paginationName !== '' &&
      $duplicatedPagination->exists()
    ) {

      $errors[] =

        'Já existe uma paginação cadastrada com este nome.';

    }


    if(count($columns) <= 0) {

      $errors[] =

        'Adicione pelo menos uma coluna à paginação.';

    }


    foreach($columns as $columnIndex => $column) {


      $fieldTypeID = (int) (

        $column[
          'tbl_sys_field_type_ID'
        ] ?? 0

      );


      $columnName = trim((string) (

        $column[
          'tbl_sys_paginations_col_name'
        ] ?? ''

      ));


      $columnTitle = trim((string) (

        $column[
          'tbl_sys_paginations_col_title'
        ] ?? ''

      ));


      if($fieldTypeID <= 0) {

        $errors[] =

          'O tipo da coluna ' .

          ($columnIndex + 1) .

          ' é inválido.';

      }


      if($columnName === '') {

        $errors[] =

          'Selecione a coluna do banco de dados no item ' .

          ($columnIndex + 1) .

          '.';

      }


      if($columnTitle === '') {

        $errors[] =

          'Informe o título da coluna no item ' .

          ($columnIndex + 1) .

          '.';

      }


      if(
        mb_strlen(
          $columnTitle
        ) > 255
      ) {

        $errors[] =

          'O título da coluna ' .

          ($columnIndex + 1) .

          ' deve possuir no máximo 255 caracteres.';

      }


      if(
        $fieldTypeID > 0 &&
        !SysFieldType::where(

          'tbl_sys_field_type_ID',

          $fieldTypeID

        )->exists()
      ) {

        $errors[] =

          'O tipo da coluna ' .

          ($columnIndex + 1) .

          ' não foi encontrado no sistema.';

      }


    }


    return array_values(

      array_unique(

        $errors

      )

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Persiste argumentos da paginação
  |--------------------------------------------------------------------------
  */

  private function persistPaginationEditorArguments(
    SysPagination $pagination,
    array $arguments
  ): void {


    $argumentNames = [];


    foreach($arguments as $argumentName => $argumentValue) {


      $argumentName = trim((string)

        $argumentName

      );


      if($argumentName === '') {

        continue;

      }


      $argumentNames[] =

        $argumentName;


      SysPaginationsArg::updateOrCreate(

        [

          'tbl_sys_pagination_ID' =>

            $pagination->tbl_sys_pagination_ID,

          'tbl_sys_paginations_arg_name' =>

            $argumentName,

        ],

        [

          'tbl_sys_paginations_arg_value' =>

            $this->encodePaginationEditorValue(

              $argumentValue

            ),

        ]

      );


    }


    $deleteArguments = SysPaginationsArg::where(

      'tbl_sys_pagination_ID',

      $pagination->tbl_sys_pagination_ID

    );


    if(count($argumentNames) > 0) {


      $deleteArguments->whereNotIn(

        'tbl_sys_paginations_arg_name',

        $argumentNames

      );


    }


    $deleteArguments->delete();


  }



  /*
  |--------------------------------------------------------------------------
  | Persiste colunas e permissões
  |--------------------------------------------------------------------------
  */

  private function persistPaginationEditorColumns(
    SysPagination $pagination,
    array $columns
  ): void {


    $persistedColumnIDs = [];


    foreach($columns as $columnIndex => $columnData) {


      $columnID =

        $columnData[
          'tbl_sys_paginations_col_ID'
        ] ?? null;


      $column = null;


      if(
        $columnID !== null &&
        $columnID > 0
      ) {


        $column = SysPaginationsCol::where(

          'tbl_sys_paginations_col_ID',

          $columnID

        )
          ->where(

            'tbl_sys_pagination_ID',

            $pagination->tbl_sys_pagination_ID

          )
          ->first();


      }


      if($column === null) {

        $column = new SysPaginationsCol();

      }


      $column->fill([

        'tbl_sys_pagination_ID' =>

          $pagination->tbl_sys_pagination_ID,


        'tbl_sys_field_type_ID' =>

          $columnData[
            'tbl_sys_field_type_ID'
          ],


        'tbl_sys_paginations_col_name' =>

          $columnData[
            'tbl_sys_paginations_col_name'
          ],


        'tbl_sys_paginations_col_title' =>

          $columnData[
            'tbl_sys_paginations_col_title'
          ],


        'tbl_sys_paginations_col_header' =>

          $this->encodePaginationEditorValue(

            $columnData[
              'tbl_sys_paginations_col_header'
            ]

          ),


        'tbl_sys_paginations_col_body' =>

          $this->encodePaginationEditorValue(

            $columnData[
              'tbl_sys_paginations_col_body'
            ]

          ),


        'tbl_sys_paginations_col_props' =>

          $this->encodePaginationEditorValue(

            $columnData[
              'tbl_sys_paginations_col_props'
            ]

          ),


        'tbl_sys_paginations_col_attrs' =>

          $this->encodePaginationEditorValue(

            $columnData[
              'tbl_sys_paginations_col_attrs'
            ]

          ),


        'tbl_sys_paginations_col_search' =>

          $columnData[
            'tbl_sys_paginations_col_search'
          ],


        'tbl_sys_paginations_col_sort' =>

          $columnData[
            'tbl_sys_paginations_col_sort'
          ],


        'tbl_sys_paginations_col_ordem' =>

          $columnIndex,

      ]);


      $column->save();


      $persistedColumnIDs[] =

        $column->tbl_sys_paginations_col_ID;


      $this->persistPaginationEditorColumnAccess(

        $column,

        $columnData['access'] ?? []

      );


    }


    $columnsToDelete = SysPaginationsCol::where(

      'tbl_sys_pagination_ID',

      $pagination->tbl_sys_pagination_ID

    );


    if(count($persistedColumnIDs) > 0) {


      $columnsToDelete->whereNotIn(

        'tbl_sys_paginations_col_ID',

        $persistedColumnIDs

      );


    }


    $removedColumnIDs = $columnsToDelete
      ->pluck(
        'tbl_sys_paginations_col_ID'
      )
      ->toArray();


    if(count($removedColumnIDs) > 0) {


      SysPaginationsColsAccess::whereIn(

        'tbl_sys_paginations_col_ID',

        $removedColumnIDs

      )->delete();


      SysPaginationsCol::whereIn(

        'tbl_sys_paginations_col_ID',

        $removedColumnIDs

      )->delete();


    }


  }



  /*
  |--------------------------------------------------------------------------
  | Persiste permissões da coluna
  |--------------------------------------------------------------------------
  */

  private function persistPaginationEditorColumnAccess(
    SysPaginationsCol $column,
    array $access
  ): void {


    $access = array_values(

      array_unique(

        array_filter(

          array_map(function($userTypeID) {


            return (int) $userTypeID;


          }, $access),

          function($userTypeID) {


            return $userTypeID > 0;


          }

        )

      )

    );


    SysPaginationsColsAccess::where(

      'tbl_sys_paginations_col_ID',

      $column->tbl_sys_paginations_col_ID

    )->delete();


    foreach($access as $userTypeID) {


      SysPaginationsColsAccess::create([

        'tbl_users_type_ID' =>

          $userTypeID,

        'tbl_sys_paginations_col_ID' =>

          $column->tbl_sys_paginations_col_ID,

      ]);


    }


  }



  /*
  |--------------------------------------------------------------------------
  | Codifica valores estruturados para o banco
  |--------------------------------------------------------------------------
  */

  private function encodePaginationEditorValue(
    $value
  ) {


    if(
      is_array($value) ||
      is_object($value)
    ) {


      return json_encode(

        $value,

        JSON_UNESCAPED_UNICODE |

        JSON_UNESCAPED_SLASHES

      );


    }


    if(is_bool($value)) {

      return $value ? '1' : '0';

    }


    if($value === null) {

      return '';

    }


    return (string) $value;


  }

}