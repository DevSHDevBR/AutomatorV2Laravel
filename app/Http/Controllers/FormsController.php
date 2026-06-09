<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Validation\ValidationException;

  use App\Helpers\SysAutomator;



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


      /*
      |--------------------------------------------------------------------------
      | Valida permissão de acesso ao formulário
      |--------------------------------------------------------------------------
      */

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



      /*
      |--------------------------------------------------------------------------
      | Valores opcionais para pré-preencher o formulário
      |--------------------------------------------------------------------------
      |
      | Normalmente virá vazio, pois no fluxo do modal a segunda requisição AJAX
      | poderá capturar os dados do registro e popular os campos depois.
      |
      | Mas caso futuramente você queira chamar essa API já passando dados,
      | ela aceita:
      |
      | values[tbl_campo]=valor
      |
      */

      $values = $request->input('values', []);


      if(!is_array($values)) {

        $values = [];

      }



      /*
      |--------------------------------------------------------------------------
      | Renderiza formulário
      |--------------------------------------------------------------------------
      */

      $response = SysAutomator::SysAutomatorRenderFormByID($id, $values);



      /*
      |--------------------------------------------------------------------------
      | Falha ao localizar/renderizar formulário
      |--------------------------------------------------------------------------
      */

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



      /*
      |--------------------------------------------------------------------------
      | Garante estrutura compatível com AJAX e Blade
      |--------------------------------------------------------------------------
      */

      if(!isset($response['html'])) {

        $response['html'] = '';

      }


      if(!isset($response['data'])) {

        $response['data'] = $values;

      }


      if(!isset($response['populate']) || !is_array($response['populate'])) {

        $response['populate'] = [

          'enabled' => true,
          'source'  => 'external',
          'action'  => null,
          'id'      => null,
          'values'  => $values,

        ];

      }



      /*
      |--------------------------------------------------------------------------
      | Informações auxiliares para o JS
      |--------------------------------------------------------------------------
      */

      $response['request'] = [

        'form_id' => $id,
        'values'  => $values,

      ];



      /*
      |--------------------------------------------------------------------------
      | Retorno final
      |--------------------------------------------------------------------------
      */

      return response()->json($response, 200);


    }



    public function getFormEditorField(Request $request) {


      $fieldID = $request->input('fieldTypeID');

      $response = [
        'status' => true,
        'title'  => 'OK',
        'message' => 'Foi',
        'automator' => SysAutomator::SysAutomatorRenderPageBuilderField($fieldID, []),
        'campo' => $fieldID
      ];

      return response()->json($response, 200);


    }



  }