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


}