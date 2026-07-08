<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Auth;

  use App\Helpers\SysAutomator;
  use App\Models\SysFieldType;
  use App\Models\SysForm;
  use App\Models\SysFormsField;
  use App\Models\SysFormsAccess;
  use App\Models\SysFormsFieldsAccess;
  use App\Models\UsersType;



  class FormsController extends Controller {


    protected $FormName = 'admin-forms';

    public function index(Request $request) {


      $slug = $request->route('pageSlug');

      // gerarForm($FormName)


      $params = [

        'page_name'     => '@replace(route["tbl_sys_route_name"])',
        'table'         => 'tbl_sys_forms',
        'index'         => 'tbl_sys_form_ID',
        'per_page'      => 15,
        'actions'       => [

          'get' => [
            'route' => 'forms-get',
            'params' => ['id' => "#ID#"],
            'show' => true,
          ],
          'add' => [
            'route' => 'admin-forms-store',
            'params' => [],
            'show' => false,
          ],
          'edit' => [
            'route' => 'admin-forms-update',
            'params' => [],
            'show' => false,
          ],
          'delete' => [

            'route' => 'admin-forms-delete',
            'params' => [],
            'show' => false,
            'roles' => [

              [

                'key'     => 'tbl_sys_form_locked',
                'compare' => '==',
                'value'   => false
              
              ]

            ]
          
          ]

        ],
        'search_fields' => [

          'tbl_sys_form_ID'   => 'ID',
          'tbl_sys_form_name' => 'Nome',
          'tbl_sys_form_title' => 'Titulo',
        
        ],
        'header_actions' => [

          [

            'type'    => 'button',
            'action'  => 'add',
            'id'      => 'btn-add-form',
            'class'   => 'btn btn-success',
            'icon'    => 'plus',
            'text'    => 'Novo Formulario',
            'onclick' => '',

          ]

        ],
        'list_actions' => [

          [

            'type'    => 'button',
            'action'  => 'edit',
            'id'      => 'btn-edit',
            'class'   => 'btn-primary',
            'icon'    => 'pencil',
            'text'    => 'Editar Formulario',
            'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName($this->FormName) . ", 'get', {id});",

          ],
          [

            'type'    => 'button',
            'action'  => 'delete',
            'id'      => 'btn-delete',
            'class'   => 'btn-danger',
            'icon'    => 'trash',
            'text'    => 'Excluir Formulario',
            'onclick' => '',

          ]

        ],
        'columns'   => [

          'tbl_sys_form_ID'     => [

            'type'     => 'int',
            'label'    => 'ID',
            'sortable' => true,
            'header'   => ['class' => 'text-center'],
            'body'     => ['class' => 'text-center'],

          ],
          'tbl_sys_form_name' => [
            'type'     => 'text',
            'label'    => 'Nome',
            'sortable' => true
          ],
          'tbl_sys_form_title' => [
            'type'     => 'text',
            'label'    => 'Titulo',
            'sortable' => true
          ]

        ]

      ];

      $data = SysAutomator::SysAutomatorPaginationData($params, $request);

      return SysAutomator::SysAutomatoRenderRouteContent($slug, $data);

    }


    public function getForm(Request $request, $id) {

      if($request->input('mode') === 'editor-options') {
        return $this->getFormEditorOptions($request);
      }

      if($request->input('mode') === 'editor') {
        return $this->getFormEditorData($request, $id);
      }

      if(SysAutomator::SysAutomatorGetFormUserAccessByID($id) != true) {

        return response()->json([
          'status'  => false,
          'message' => 'Você não possui permissão para acessar este formulário.',
          'form'    => null,
          'fields'  => [],
          'html'    => '',
          'data'    => [],
        ], 403);

      }

      $values = $request->input('values', []);

      if(!is_array($values)) {
        $values = [];
      }

      $response = SysAutomator::SysAutomatorRenderFormByID($id, $values);

      if(!isset($response['status']) || $response['status'] != true) {

        return response()->json([
          'status'  => false,
          'message' => $response['message'] ?? 'Falha ao encontrar formulário.',
          'form'    => $response['form'] ?? null,
          'fields'  => $response['fields'] ?? [],
          'html'    => $response['html'] ?? '',
          'data'    => $response['data'] ?? [],
        ], 404);

      }

      $response['html'] = $response['html'] ?? '';
      $response['data'] = $response['data'] ?? $values;

      if(!isset($response['populate']) || !is_array($response['populate'])) {

        $response['populate'] = [
          'enabled' => true,
          'source'  => 'external',
          'action'  => null,
          'id'      => null,
          'values'  => $values,
        ];

      }

      $response['request'] = [
        'form_id' => $id,
        'values'  => $values,
      ];

      return response()->json($response, 200);

    }
    // public function getForm(Request $request, $id) {


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Valida permissão de acesso ao formulário
    //   |--------------------------------------------------------------------------
    //   */

    //   if(SysAutomator::SysAutomatorGetFormUserAccessByID($id) != true) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => 'Você não possui permissão para acessar este formulário.',
    //       'form'    => null,
    //       'fields'  => [],
    //       'html'    => '',
    //       'data'    => [],

    //     ], 403);

    //   }


    //   if($request->input('mode') === 'editor') {
    //     return $this->getFormEditorData($request, $id);
    //   }



    //   /*
    //   |--------------------------------------------------------------------------
    //   | Valores opcionais para pré-preencher o formulário
    //   |--------------------------------------------------------------------------
    //   |
    //   | Normalmente virá vazio, pois no fluxo do modal a segunda requisição AJAX
    //   | poderá capturar os dados do registro e popular os campos depois.
    //   |
    //   | Mas caso futuramente você queira chamar essa API já passando dados,
    //   | ela aceita:
    //   |
    //   | values[tbl_campo]=valor
    //   |
    //   */

    //   $values = $request->input('values', []);


    //   if(!is_array($values)) {

    //     $values = [];

    //   }



    //   /*
    //   |--------------------------------------------------------------------------
    //   | Renderiza formulário
    //   |--------------------------------------------------------------------------
    //   */

    //   $response = SysAutomator::SysAutomatorRenderFormByID($id, $values);



    //   /*
    //   |--------------------------------------------------------------------------
    //   | Falha ao localizar/renderizar formulário
    //   |--------------------------------------------------------------------------
    //   */

    //   if(!isset($response['status']) || $response['status'] != true) {

    //     return response()->json([

    //       'status'  => false,
    //       'message' => $response['message'] ?? 'Falha ao encontrar formulário.',
    //       'form'    => $response['form'] ?? null,
    //       'fields'  => $response['fields'] ?? [],
    //       'html'    => $response['html'] ?? '',
    //       'data'    => $response['data'] ?? [],

    //     ], 404);

    //   }



    //   /*
    //   |--------------------------------------------------------------------------
    //   | Garante estrutura compatível com AJAX e Blade
    //   |--------------------------------------------------------------------------
    //   */

    //   if(!isset($response['html'])) {

    //     $response['html'] = '';

    //   }


    //   if(!isset($response['data'])) {

    //     $response['data'] = $values;

    //   }


    //   if(!isset($response['populate']) || !is_array($response['populate'])) {

    //     $response['populate'] = [

    //       'enabled' => true,
    //       'source'  => 'external',
    //       'action'  => null,
    //       'id'      => null,
    //       'values'  => $values,

    //     ];

    //   }



    //   /*
    //   |--------------------------------------------------------------------------
    //   | Informações auxiliares para o JS
    //   |--------------------------------------------------------------------------
    //   */

    //   $response['request'] = [

    //     'form_id' => $id,
    //     'values'  => $values,

    //   ];



    //   /*
    //   |--------------------------------------------------------------------------
    //   | Retorno final
    //   |--------------------------------------------------------------------------
    //   */

    //   return response()->json($response, 200);


    // }


    public function getFormEditorField(Request $request) {


      $mode = $request->input('mode', 'page');

      $mode = strtolower(trim($mode));

      if(!in_array($mode, ['page', 'form'])) {

        $mode = 'page';

      }


      $fieldID = $request->input('fieldTypeID');


      if(empty($fieldID)) {

        return response()->json([

          'status'    => false,
          'title'     => 'Erro',
          'message'   => 'ID do tipo de campo não informado.',
          'mode'      => $mode,
          'automator' => null,
          'field'     => null,
          'data'      => null,
          'campo'     => null,

        ], 400);

      }


      $fieldQuery = SysFieldType::where(
        'tbl_sys_field_type_ID',
        $fieldID
      );


      if($mode === 'form') {

        $fieldQuery->where(
          'tbl_sys_field_type_layout',
          false
        );

      }


      $field = $fieldQuery->first();


      if(!$field) {

        return response()->json([

          'status'    => false,
          'title'     => 'Erro',
          'message'   => ($mode === 'form')
            ? 'Tipo de campo não encontrado ou não permitido para formulários.'
            : 'Tipo de campo não encontrado.',
          'mode'      => $mode,
          'automator' => null,
          'field'     => null,
          'data'      => null,
          'campo'     => null,

        ], 404);

      }


      $fieldData = $field->toArray();


      $automator = SysAutomator::SysAutomatorRenderPageBuilderField(
        $fieldData,
        []
      );


      return response()->json([

        'status'    => true,
        'title'     => 'OK',
        'message'   => ($mode === 'form')
          ? 'Campo de formulário carregado com sucesso.'
          : 'Campo carregado com sucesso.',
        'mode'      => $mode,

        'automator' => $automator,
        'field'     => $automator,
        'data'      => $automator,

        'campo'     => $fieldData,
        'fieldType' => $fieldData,

      ], 200);


    }

    public function getFormEditorData(Request $request, $id) {

      if(empty($id)) {

        return response()->json([
          'status'  => false,
          'title'   => 'Erro',
          'message' => 'ID do formulário não informado.',
          'form'    => null,
          'fields'  => [],
          'data'    => null,
        ], 400);

      }

      if(SysAutomator::SysAutomatorGetFormUserAccessByID($id) != true) {

        return response()->json([
          'status'  => false,
          'title'   => 'Erro',
          'message' => 'Você não possui permissão para acessar este formulário.',
          'form'    => null,
          'fields'  => [],
          'data'    => null,
        ], 403);

      }

      $form = SysForm::where('tbl_sys_form_ID', $id)->first();

      if(!$form) {

        return response()->json([
          'status'  => false,
          'title'   => 'Erro',
          'message' => 'Formulário não encontrado.',
          'form'    => null,
          'fields'  => [],
          'data'    => null,
        ], 404);

      }

      $formData = $form->toArray();

      $formData['form_access'] = SysFormsAccess::where('tbl_sys_form_ID', $id)
        ->pluck('tbl_users_type_ID')
        ->map(function($value) {
          return (string) $value;
        })
        ->values()
        ->toArray();

      $fields = SysFormsField::query()
        ->select(
          'tbl_sys_forms_fields.*',
          'tbl_sys_field_types.tbl_sys_field_type_name',
          'tbl_sys_field_types.tbl_sys_field_type_title',
          'tbl_sys_field_types.tbl_sys_field_type_icon',
          'tbl_sys_field_types.tbl_sys_field_type_params',
          'tbl_sys_field_types.tbl_sys_field_type_layout'
        )
        ->leftJoin(
          'tbl_sys_field_types',
          'tbl_sys_field_types.tbl_sys_field_type_ID',
          '=',
          'tbl_sys_forms_fields.tbl_sys_field_type_ID'
        )
        ->where('tbl_sys_forms_fields.tbl_sys_form_ID', $id)
        ->orderBy('tbl_sys_forms_fields.tbl_sys_forms_field_ordem', 'asc')
        ->get()
        ->map(function($field) {

          $data = $field->toArray();

          $props = [];

          if(!empty($data['tbl_sys_forms_field_props'])) {

            $decoded = json_decode($data['tbl_sys_forms_field_props'], true);

            if(is_array($decoded)) {
              $props = $decoded;
            }

          }

          if(empty($props['input_id']) && !empty($data['tbl_sys_forms_field_attrs'])) {

            if(preg_match('/id=["\']([^"\']+)["\']/', $data['tbl_sys_forms_field_attrs'], $match)) {
              $props['input_id'] = $match[1];
            }

          }

          if(empty($props['input_id'])) {
            $props['input_id'] = 'field_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $data['tbl_sys_forms_field_name'] ?? 'campo');
          }

          if(empty($props['wrapper_class']) && ($data['tbl_sys_field_type_name'] ?? '') !== 'hidden') {
            $props['wrapper_class'] = 'col-12';
          }

          $data['tbl_sys_forms_field_props'] = $props;

          $data['field_access'] = SysFormsFieldsAccess::where(
              'tbl_sys_forms_field_ID',
              $data['tbl_sys_forms_field_ID']
            )
            ->pluck('tbl_users_type_ID')
            ->map(function($value) {
              return (string) $value;
            })
            ->values()
            ->toArray();

          $data['raw'] = [
            'tbl_sys_field_type_ID'     => $data['tbl_sys_field_type_ID'] ?? '',
            'tbl_sys_field_type_name'   => $data['tbl_sys_field_type_name'] ?? '',
            'tbl_sys_field_type_title'  => $data['tbl_sys_field_type_title'] ?? '',
            'tbl_sys_field_type_icon'   => $data['tbl_sys_field_type_icon'] ?? '',
            'tbl_sys_field_type_params' => $data['tbl_sys_field_type_params'] ?? '',
            'tbl_sys_field_type_layout' => $data['tbl_sys_field_type_layout'] ?? false,
          ];

          $data['uid'] = 'form-field-existing-' . ($data['tbl_sys_forms_field_ID'] ?? uniqid());

          return $data;

        })
        ->values()
        ->toArray();

      return response()->json([
        'status'            => true,
        'title'             => 'OK',
        'message'           => 'Formulário carregado para edição.',
        'mode'              => 'editor',
        'formID'            => $id,
        'form'              => $formData,
        'fields'            => $fields,
        'userTypes'         => $this->getEditorUserTypesPayload(),
        'currentUser'       => [
          'isDeveloper'  => $this->currentUserIsDeveloper(),
          'is_developer' => $this->currentUserIsDeveloper(),
        ],
        'data'              => [
          'form'      => $formData,
          'fields'    => $fields,
          'userTypes' => $this->getEditorUserTypesPayload(),
        ],
      ], 200);

    }
    // public function getFormEditorData(Request $request, $id) {

    //   if(empty($id)) {

    //     return response()->json([
    //       'status'  => false,
    //       'title'   => 'Erro',
    //       'message' => 'ID do formulário não informado.',
    //       'form'    => null,
    //       'fields'  => [],
    //       'data'    => null,
    //     ], 400);

    //   }

    //   if(SysAutomator::SysAutomatorGetFormUserAccessByID($id) != true) {

    //     return response()->json([
    //       'status'  => false,
    //       'title'   => 'Erro',
    //       'message' => 'Você não possui permissão para acessar este formulário.',
    //       'form'    => null,
    //       'fields'  => [],
    //       'data'    => null,
    //     ], 403);

    //   }

    //   $form = SysForm::where('tbl_sys_form_ID', $id)->first();

    //   if(!$form) {

    //     return response()->json([
    //       'status'  => false,
    //       'title'   => 'Erro',
    //       'message' => 'Formulário não encontrado.',
    //       'form'    => null,
    //       'fields'  => [],
    //       'data'    => null,
    //     ], 404);

    //   }

    //   $fields = SysFormsField::query()
    //     ->select(
    //       'tbl_sys_forms_fields.*',
    //       'tbl_sys_field_types.tbl_sys_field_type_name',
    //       'tbl_sys_field_types.tbl_sys_field_type_title',
    //       'tbl_sys_field_types.tbl_sys_field_type_icon',
    //       'tbl_sys_field_types.tbl_sys_field_type_params',
    //       'tbl_sys_field_types.tbl_sys_field_type_layout'
    //     )
    //     ->leftJoin(
    //       'tbl_sys_field_types',
    //       'tbl_sys_field_types.tbl_sys_field_type_ID',
    //       '=',
    //       'tbl_sys_forms_fields.tbl_sys_field_type_ID'
    //     )
    //     ->where('tbl_sys_forms_fields.tbl_sys_form_ID', $id)
    //     ->orderBy('tbl_sys_forms_fields.tbl_sys_forms_field_ordem', 'asc')
    //     ->get()
    //     ->map(function($field) {

    //       $data = $field->toArray();

    //       $props = [];

    //       if(!empty($data['tbl_sys_forms_field_props'])) {

    //         $decoded = json_decode($data['tbl_sys_forms_field_props'], true);

    //         if(is_array($decoded)) {
    //           $props = $decoded;
    //         }

    //       }

    //       if(empty($props['input_id']) && !empty($data['tbl_sys_forms_field_attrs'])) {

    //         if(preg_match('/id=["\']([^"\']+)["\']/', $data['tbl_sys_forms_field_attrs'], $match)) {
    //           $props['input_id'] = $match[1];
    //         }

    //       }

    //       if(empty($props['input_id'])) {
    //         $props['input_id'] = 'field_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $data['tbl_sys_forms_field_name'] ?? 'campo');
    //       }

    //       if(empty($props['wrapper_class']) && ($data['tbl_sys_field_type_name'] ?? '') !== 'hidden') {
    //         $props['wrapper_class'] = 'col-12';
    //       }

    //       $data['tbl_sys_forms_field_props'] = $props;

    //       $data['raw'] = [
    //         'tbl_sys_field_type_ID'     => $data['tbl_sys_field_type_ID'] ?? '',
    //         'tbl_sys_field_type_name'   => $data['tbl_sys_field_type_name'] ?? '',
    //         'tbl_sys_field_type_title'  => $data['tbl_sys_field_type_title'] ?? '',
    //         'tbl_sys_field_type_icon'   => $data['tbl_sys_field_type_icon'] ?? '',
    //         'tbl_sys_field_type_params' => $data['tbl_sys_field_type_params'] ?? '',
    //         'tbl_sys_field_type_layout' => $data['tbl_sys_field_type_layout'] ?? false,
    //       ];

    //       $data['uid'] = 'form-field-existing-' . ($data['tbl_sys_forms_field_ID'] ?? uniqid());

    //       return $data;

    //     })
    //     ->values()
    //     ->toArray();

    //   return response()->json([
    //     'status'  => true,
    //     'title'   => 'OK',
    //     'message' => 'Formulário carregado para edição.',
    //     'mode'    => 'editor',
    //     'formID'  => $id,
    //     'form'    => $form->toArray(),
    //     'fields'  => $fields,
    //     'data'    => [
    //       'form'   => $form->toArray(),
    //       'fields' => $fields,
    //     ],
    //   ], 200);

    // }


    public function getFormEditorSecurityOptions(Request $request) {

      $userTypes = UsersType::query()
        ->select(
          'tbl_users_type_ID',
          'tbl_users_type_name',
          'tbl_users_type_status'
        )
        ->orderBy('tbl_users_type_ID', 'asc')
        ->get()
        ->map(function($userType) {

          return [
            'id'           => (int) $userType->tbl_users_type_ID,
            'name'         => $userType->tbl_users_type_name,
            'status'       => $userType->tbl_users_type_status,
            'is_developer' => mb_strtolower(trim($userType->tbl_users_type_name)) === 'desenvolvedor',
          ];

        })
        ->values()
        ->toArray();

      return response()->json([
        'status'     => true,
        'userTypes'  => $userTypes,
        'user_types' => $userTypes,
      ], 200);

    }


    private function getEditorUserTypesPayload(): array {

      return UsersType::query()
        ->select(
          'tbl_users_type_ID',
          'tbl_users_type_name',
          'tbl_users_type_status',
          'tbl_users_type_locked'
        )
        ->orderBy('tbl_users_type_ID', 'asc')
        ->get()
        ->map(function($userType) {

          $name = trim($userType->tbl_users_type_name);

          return [
            'id'           => (string) $userType->tbl_users_type_ID,
            'name'         => $name,
            'status'       => $userType->tbl_users_type_status,
            'locked'       => (bool) $userType->tbl_users_type_locked,
            'isDeveloper'  => mb_strtolower($name) === 'desenvolvedor',
            'is_developer' => mb_strtolower($name) === 'desenvolvedor',
          ];

        })
        ->values()
        ->toArray();

    }


    private function currentUserIsDeveloper(): bool {

      if(!Auth::check()) {
        return false;
      }

      $user = Auth::user();

      if(!$user || !method_exists($user, 'UserHasTypeByName')) {
        return false;
      }

      return $user->UserHasTypeByName('Desenvolvedor');

    }


    public function getFormEditorOptions(Request $request) {

      return response()->json([
        'status'            => true,
        'userTypes'         => $this->getEditorUserTypesPayload(),
        'currentUser'       => [
          'isDeveloper'  => $this->currentUserIsDeveloper(),
          'is_developer' => $this->currentUserIsDeveloper(),
        ],
      ], 200);

    }



    // public function getFormEditorField(Request $request) {


    //   $fieldID = $request->input('fieldTypeID');

    //   $response = [
    //     'status' => true,
    //     'title'  => 'OK',
    //     'message' => 'Foi',
    //     'automator' => SysAutomator::SysAutomatorRenderPageBuilderField($fieldID, []),
    //     'campo' => $fieldID
    //   ];

    //   return response()->json($response, 200);


    // }



  }