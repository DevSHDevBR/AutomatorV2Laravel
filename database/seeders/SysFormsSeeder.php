<?php


  namespace Database\Seeders;

  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;

  use App\Models\SysForm;
  use App\Models\SysFieldType;
  use App\Models\SysFormsField;
  use App\Models\SysFormsFieldsAccess;
  use App\Models\SysFormsAccess;



  class SysFormsSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {



      $formularios = [

        // MINHA CONTA - START

          [

            'tbl_sys_form_name'     => 'admin-minha-conta',
            'tbl_sys_form_title'    => 'Minha Conta',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_route'    => 'admin-api-minha-conta',
            'tbl_sys_form_method'   => 'POST',
            'tbl_sys_form_modal'    => false,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2, 3, 4],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_user_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                // 'tbl_sys_forms_field_default'  => '@replace($currentUser["tbl_user_ID"])',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_user_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght"     => 255,
                  "minlenght"     => 8,
                  "unique"        => [

                    "table"  => "tbl_users",
                    "column" => "tbl_user_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('email', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'E-mail',
                'tbl_sys_forms_field_name'     => 'tbl_user_email',
                'tbl_sys_forms_field_index'    => 'email',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght"     => 255,
                  "minlenght"     => 12,
                  "unique"        => [

                    "table"  => "tbl_users",
                    "column" => "tbl_user_email"

                  ]
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('password', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nova senha',
                'tbl_sys_forms_field_name'     => 'tbl_user_password',
                'tbl_sys_forms_field_index'    => 'new_password',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght"     => 255,
                  "minlenght"     => 8,
                  "hasButton"     => true

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('password', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Confirmar Nova senha',
                'tbl_sys_forms_field_name'     => 'tbl_user_confirm_password',
                'tbl_sys_forms_field_index'    => 'confirm_password',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght"     => 255,
                  "minlenght"     => 8,
                  "hasButton"     => true

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

            ]

          ],

        // MINHA CONTA - END



        // ROUTES / API's - START

          [

            'tbl_sys_form_name'     => 'admin-routes-apis',
            'tbl_sys_form_title'    => "API's",
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght" => 255,
                  "minlenght" => 8,
                  "unique"    => [

                    "table"  => "tbl_sys_routes",
                    "column" => "tbl_sys_route_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Titulo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght" => 255,
                  "minlenght" => 8,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Link Permanente',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_permalink',
                'tbl_sys_forms_field_index'    => 'permalink',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => '',
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Descrição',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_description',
                'tbl_sys_forms_field_index'    => 'description',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Ponto de API',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_api',
                'tbl_sys_forms_field_index'    => 'api',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => true,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Página Administrativa',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_admin',
                'tbl_sys_forms_field_index'    => 'api',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_locked',
                'tbl_sys_forms_field_index'    => 'locked',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tipo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_type',
                'tbl_sys_forms_field_index'    => 'type',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "GET",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "GET"    => "GET",
                    "POST"   => "POST",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Método',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_method',
                'tbl_sys_forms_field_index'    => 'mathod',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 10,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Controller',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_controller',
                'tbl_sys_forms_field_index'    => 'controller',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 11,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Argumentos',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_args',
                'tbl_sys_forms_field_index'    => 'args',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => '',
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 12,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('editor', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Conteúdo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_content',
                'tbl_sys_forms_field_index'    => 'content',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "rows" => 6
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 13,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_area',
                'tbl_sys_forms_field_index'    => 'area',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "public",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "public"   => "Publica",
                    "restrict" => "Restrita"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 14,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_status',
                'tbl_sys_forms_field_index'    => 'status',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "ativo",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "ativo"   => "Ativo",
                    "inativo" => "Inativo"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 15,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],

        // ROUTES / API's - END



        // ROUTES / API's ACCESS - START

          [

            'tbl_sys_form_name'     => 'admin-routes-apis-access',
            'tbl_sys_form_title'    => 'Permissões das Rotas de API',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID da Rota',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => '',
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome da rota',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12",
                  "readonly"      => true,
                  "disabled"      => true
                  
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],
              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Permissões da Rota',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_ID',
                'tbl_sys_forms_field_index'    => 'access',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12",
                  "type"          => "checkbox",
                  "container"     => [

                    "element" => "div",
                    "class"   => ""

                  ],
                  "relation"      => [

                    "table"   => "tbl_users_types",
                    "value"   => "tbl_users_type_ID",

                    /*
                    |----------------------------------------------------------
                    | label como array: faz query secundária para buscar o
                    | display pelo value.
                    |
                    | Estrutura:
                    |   "table"   => tabela onde buscar o label
                    |   "value"   => coluna de chave/FK para fazer o match
                    |   "display" => coluna cujo valor será exibido como label
                    |----------------------------------------------------------
                    */
                    "label"   => [

                      "table"   => "tbl_users_types",
                      "value"   => "tbl_users_type_ID",
                      "display" => "tbl_users_type_name"

                    ],

                    "filters" => [

                      "tbl_users_type_status" => [

                        "inativo" => [

                          "class"   => "disabled",
                          "tooltip" => "Tipo de usuário inativo"

                        ]

                      ]

                    ]

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              // [

              //   'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
              //   'tbl_sys_forms_field_title'    => 'Permissões da Rota',
              //   'tbl_sys_forms_field_name'     => 'tbl_users_type_ID',
              //   'tbl_sys_forms_field_index'    => 'access',
              //   'tbl_sys_forms_field_class'    => '',
              //   'tbl_sys_forms_field_default'  => "",
              //   'tbl_sys_forms_field_props'    => json_encode([
                  
              //     "wrapper_class" => "col-12",
              //     "type"          => "checkbox",
              //     "container"     => [

              //       "element" => "div",
              //       "class"   => ""

              //     ],
              //     "relation"      => [

              //       "table"   => "tbl_sys_routes_access",
              //       "value"   => "tbl_users_type_ID",
              //       "label"   => "tbl_users_type_ID",
              //       // "label"   => [

              //       //   "table"   => "tbl_users_types",
              //       //   "value"   => "tbl_users_type_ID",
              //       //   "display" => "tbl_users_type_name" 

              //       // ],

              //     ]

              //   ]),
              //   'tbl_sys_forms_field_attrs'    => '',
              //   'tbl_sys_forms_field_required' => false,
              //   'tbl_sys_forms_field_locked'   => true,
              //   'tbl_sys_forms_field_ordem'    => 3,
              //   'field_access'                 => [1, 2]
              
              // ],

            ]

          ],


        // ROUTES / API's ACCESS - END



        // ROUTES / PÁGINAS - START

          [

            'tbl_sys_form_name'     => 'admin-routes',
            'tbl_sys_form_title'    => 'Páginas',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght" => 255,
                  "minlenght" => 8,
                  "unique"    => [

                    "table"  => "tbl_sys_routes",
                    "column" => "tbl_sys_route_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Titulo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght" => 255,
                  "minlenght" => 8,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Link Permanente',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_permalink',
                'tbl_sys_forms_field_index'    => 'permalink',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => '',
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Descrição',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_description',
                'tbl_sys_forms_field_index'    => 'description',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Ponto de API',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_api',
                'tbl_sys_forms_field_index'    => 'api',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Página Administrativa',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_admin',
                'tbl_sys_forms_field_index'    => 'api',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_locked',
                'tbl_sys_forms_field_index'    => 'locked',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tipo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_type',
                'tbl_sys_forms_field_index'    => 'type',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "GET",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "GET"    => "GET",
                    "POST"   => "POST",
                    "PUT"    => "PUT",
                    "DELETE" => "DELETE",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Método',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_method',
                'tbl_sys_forms_field_index'    => 'mathod',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 10,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Controller',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_controller',
                'tbl_sys_forms_field_index'    => 'controller',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 11,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Argumentos',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_args',
                'tbl_sys_forms_field_index'    => 'args',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => '',
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 12,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('editor', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Conteúdo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_content',
                'tbl_sys_forms_field_index'    => 'content',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "rows" => 6
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 13,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_area',
                'tbl_sys_forms_field_index'    => 'area',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "public",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "public"   => "Publica",
                    "restrict" => "Restrita"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 14,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_status',
                'tbl_sys_forms_field_index'    => 'status',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "ativo",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "ativo"   => "Ativo",
                    "inativo" => "Inativo"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 15,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],

        // ROUTES / PÁGINAS - END



        // NAVS - START

          [

            'tbl_sys_form_name'     => 'admin-navs',
            'tbl_sys_form_title'    => 'Áreas de navegação',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_sys_nav_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_sys_nav_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-5",
                  "maxlenght"     => 255,
                  "minlenght"     => 8,
                  "unique"        => [

                    "table"  => "tbl_sys_navs",
                    "column" => "tbl_sys_nav_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Titulo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_nav_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-7",
                  "maxlenght" => 255,
                  "minlenght" => 8,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_sys_nav_locked',
                'tbl_sys_forms_field_index'    => 'locked',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Administrativo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_nav_admin',
                'tbl_sys_forms_field_index'    => 'admin',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],

        // NAVS - END



        // USERS TYPES - START

          [

            'tbl_sys_form_name'     => 'admin-users-types',
            'tbl_sys_form_title'    => 'Tipos de usuários',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "maxlenght" => 255,
                  "minlenght" => 8,
                  "unique"    => [

                    "table"  => "tbl_users_types",
                    "column" => "tbl_users_type_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Descrição',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_description',
                'tbl_sys_forms_field_index'    => 'description',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_locked',
                'tbl_sys_forms_field_index'    => 'locked',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_status',
                'tbl_sys_forms_field_index'    => 'status',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "ativo",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "ativo"   => "Ativo",
                    "inativo" => "Inativo"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],

        // USERS TYPES - END
        


        // USERS TYPES ACCESS - START

          [

            'tbl_sys_form_name'     => 'admin-users-types-access',
            'tbl_sys_form_title'    => 'Permissões dos tipos de usuários',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tipo de usuário',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => '',
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tipo de usuário',
                'tbl_sys_forms_field_name'     => 'tbl_users_type_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12",
                  "readonly"      => true,
                  "disabled"      => true
                  
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Permissões concedidas',
                'tbl_sys_forms_field_name'     => 'tbl_sys_route_ID',
                'tbl_sys_forms_field_index'    => 'access',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12",
                  "type"          => "checkbox",
                  "container"     => [

                    "element" => "div",
                    "class"   => ""

                  ],
                  "relation"      => [

                    "table"   => "tbl_sys_routes",
                    "value"   => "tbl_sys_route_ID",
                    "label"   => "tbl_sys_route_title",
                    "filters" => [

                      "tbl_sys_route_area" => [

                        "public" => [

                          "class"    => "disabled ",
                          "tooltip"  => "Somente páginas restritas podem ter as permissões de acesso alteradas.",
                          "disabled" => true,
                          "remove"   => false

                        
                        ],
                        "restrict" => [

                          "class"    => "",
                          "disabled" => false,
                          "remove"   => false
                        
                        ]

                      ],
                      "tbl_sys_route_status" => [
                        
                        "ativo" => [
                          
                          "class"    => "",
                          "disabled" => false,
                          "remove"   => false
                        
                        ],
                        "inativo" => [
                          
                          "class"    => "disabled",
                          "tooltip"  => "Somente páginas ativas podem ter as permissões de acesso alteradas.",
                          "disabled" => true,
                          "remove"   => false
                        
                        ]

                      ],


                    ]

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],


        // USERS TYPES ACCESS - END



        // USERS - START

          [

            'tbl_sys_form_name'     => 'admin-users',
            'tbl_sys_form_title'    => 'Usuários',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_user_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Usuário',
                'tbl_sys_forms_field_name'     => 'tbl_user_login',
                'tbl_sys_forms_field_index'    => 'login',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "maxlenght"     => 255,
                  "minlenght"     => 12,
                  "unique"        => [

                    "table"  => "tbl_users",
                    "column" => "tbl_user_login"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],
              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('email', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'E-mail',
                'tbl_sys_forms_field_name'     => 'tbl_user_email',
                'tbl_sys_forms_field_index'    => 'email',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "maxlenght"     => 255,
                  "minlenght"     => 12,
                  "unique"        => [

                    "table"  => "tbl_users",
                    "column" => "tbl_user_email"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_user_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12",
                  "maxlenght"     => 255,
                  "minlenght"     => 12

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('password', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Senha',
                'tbl_sys_forms_field_name'     => 'tbl_user_password',
                'tbl_sys_forms_field_index'    => 'password',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => 'col-12 col-md-6',
                  "maxlenght"     => 255,
                  "minlenght"     => 8,
                  "hasButton"     => true

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_user_blocked',
                'tbl_sys_forms_field_index'    => 'blocked',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "true"  => "Sim",
                    "false" => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('breakline', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Quebra de linha',
                'tbl_sys_forms_field_name'     => 'quebra',
                'tbl_sys_forms_field_index'    => '',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => "",
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Cadastro ativo',
                'tbl_sys_forms_field_name'     => 'tbl_user_actived',
                'tbl_sys_forms_field_index'    => 'actived',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "true"  => "Sim",
                    "false" => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_user_status',
                'tbl_sys_forms_field_index'    => 'status',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "ativo",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "ativo"   => "Ativo",
                    "inativo" => "Inativo"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],

        // USERS - END



        // SHORTCODES - START

          [

            'tbl_sys_form_name'     => 'admin-shortcodes',
            'tbl_sys_form_title'    => 'Shortcodes',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Código',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_code',
                'tbl_sys_forms_field_index'    => 'code',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "maxlenght" => 255
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                // 'tbl_sys_forms_field_attrs'    => json_encode([
                //   "unique" => [
                //     "table" => "tbl_sys_shortcodes",
                //     "field" => "tbl_sys_shortcode_code"
                //   ]
                // ]),
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Titulo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "maxlenght" => 255
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Descrição',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_description',
                'tbl_sys_forms_field_index'    => 'description',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => "",
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Class/Classe',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_class',
                'tbl_sys_forms_field_index'    => 'class',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "maxlenght" => 255
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Metodo/Função',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_method',
                'tbl_sys_forms_field_index'    => 'method',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "maxlenght" => 255
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Parametros',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_params',
                'tbl_sys_forms_field_index'    => 'params',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => "",
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_sys_shortcode_locked',
                'tbl_sys_forms_field_index'    => 'locked',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "false",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    true  => "Sim",
                    false => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1]
              
              ],

            ]

          ],

        // SHORTCODES - END


      ];

      foreach ($formularios as $formulario) {

        $form_fields = $formulario['form_fields'];
        $form_access = $formulario['form_access'];

        unset($formulario['form_fields']);
        unset($formulario['form_access']);

        $formItem = SysForm::create($formulario);

        $formItemID = $formItem->getKey();

        foreach ($form_access as $form_accessItem) {
          
          SysFormsAccess::Create([

            'tbl_sys_form_ID'   => $formItemID,
            'tbl_users_type_ID' => $form_accessItem

          ]);

        }

        foreach ($form_fields as $fields) {
          
          $field = $fields;

          $field_access = $field['field_access'];
          unset($field['field_access']);

          $field["tbl_sys_form_ID"] = $formItemID;

          $fieldItem = SysFormsField::create($field);

          $fieldItemID = $fieldItem->getKey();

          foreach ($field_access as $field_accessItem) {
            
            SysFormsFieldsAccess::Create([

              'tbl_users_type_ID'      => $field_accessItem,
              'tbl_sys_forms_field_ID' => $fieldItemID

            ]);

          }

        }


        // SysFormsAccess::Create([
        //   'tbl_sys_form_ID' => $formItemID,
        //   'tbl_users_type_ID' => 1
        // ]);
        // code...
      }
      //

      
    }



  }
