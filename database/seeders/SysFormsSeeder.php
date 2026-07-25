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
                  "hasButton"     => true,
                  "cast"          => "hash"

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
                  "hasButton"     => true,
                  "cast"          => "hash"

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



        // ROUTES / PAGE's ACCESS - START

          [

            'tbl_sys_form_name'     => 'admin-routes-access',
            'tbl_sys_form_title'    => 'Permissões das Rotas de Páginas',
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

            ]

          ],


        // ROUTES / PAGE's ACCESS - END




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
                  "minlenght"     => 5,
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
                  "minlenght" => 5,

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
                  "minlenght" => 5,
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
                  "minlenght"     => 5,
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
                  "minlenght"     => 5,
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
                  "minlenght"     => 5

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
                  "hasButton"     => true,
                  "cast"          => "hash"

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
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
                'tbl_sys_forms_field_default'  => 0,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    1 => "Sim",
                    0 => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('breakpoint', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Quebra de linha',
                'tbl_sys_forms_field_name'     => 'quebra',
                'tbl_sys_forms_field_index'    => '',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => "",
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
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
                'tbl_sys_forms_field_default'  => 1,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    1 => "Sim",
                    0 => "Não"
                  
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

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tipo de usuário',
                'tbl_sys_forms_field_name'     => 'UserGetTypesIDs',
                'tbl_sys_forms_field_index'    => 'userTypes',
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
                    "label"   => "tbl_users_type_name",

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],


          [

            'tbl_sys_form_name'     => 'admin-users-edit',
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
                  "minlenght"     => 5,
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
                  "minlenght"     => 8,
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
                  "minlenght"     => 5

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
                  "hasButton"     => true,
                  "cast"          => "hash"

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
                'tbl_sys_forms_field_default'  => 0,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    1 => "Sim",
                    0 => "Não"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('breakpoint', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Quebra de linha',
                'tbl_sys_forms_field_name'     => 'quebra',
                'tbl_sys_forms_field_index'    => '',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => "",
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
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
                'tbl_sys_forms_field_default'  => 1,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    1 => "Sim",
                    0 => "Não"
                  
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

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tipo de usuário',
                'tbl_sys_forms_field_name'     => 'UserGetTypesIDs',
                'tbl_sys_forms_field_index'    => 'userTypes',
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
                    "label"   => "tbl_users_type_name",

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]
              
              ],

            ]

          ],


        // USERS - END



        // NOTIFICATIONS - START

          [

            'tbl_sys_form_name'     => 'admin-notifications',
            'tbl_sys_form_title'    => 'Notificações',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Enviar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_ID',
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

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Usuário',
                'tbl_sys_forms_field_name'     => 'tbl_user_ID',
                'tbl_sys_forms_field_index'    => 'userID',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "type"          => "select",
                  "relation"      => [

                    "table"   => "tbl_users",
                    "value"   => "tbl_user_ID",
                    "label"   => "tbl_user_name"

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
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12 col-md-6",
                  "maxlenght" => 255

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Mensagem',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_text',
                'tbl_sys_forms_field_index'    => 'text',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12",

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Visualizada',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_opened',
                'tbl_sys_forms_field_index'    => 'api',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    false => "Não",
                    true  => "Sim",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

              // [

              //   'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('datetime', 'tbl_sys_field_type_ID'),
              //   'tbl_sys_forms_field_title'    => 'Data de envio',
              //   'tbl_sys_forms_field_name'     => 'tbl_sys_notification_created_at',
              //   'tbl_sys_forms_field_index'    => 'created_at',
              //   'tbl_sys_forms_field_class'    => '',
              //   'tbl_sys_forms_field_default'  => '',
              //   'tbl_sys_forms_field_props'    => json_encode([

              //     "wrapper_class" => "col-12 col-md-6",
              //     "format"  => "Y-m-d H:i:s",
              //     "display" => "d/m/Y - H:i:s",
              //     "attrs" => [

              //       "format"  => "Y-m-d H:i:s",
              //       "display" => "d/m/Y - H:i:s"

              //     ]

              //   ]),
              //   'tbl_sys_forms_field_attrs'    => '',
              //   'tbl_sys_forms_field_required' => false,
              //   'tbl_sys_forms_field_locked'   => true,
              //   'tbl_sys_forms_field_ordem'    => 6,
              //   'field_access'                 => [1, 2]
              
              // ],

            ]

          ],

        // NOTIFICATIONS - END



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


        // OPEN VIEW MODAL - START

          [

            'tbl_sys_form_name'     => 'admin-open-view-modal',
            'tbl_sys_form_title'    => 'Abrir View Modal',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Gerar Código',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => false,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'View',
                'tbl_sys_forms_field_name'     => 'view',
                'tbl_sys_forms_field_index'    => 'view',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12 col-md-5",
                    "maxlenght" => 255

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Título do Modal',
                'tbl_sys_forms_field_name'     => 'title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12 col-md-7",
                    "maxlenght" => 255

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tamanho',
                'tbl_sys_forms_field_name'     => 'size',
                'tbl_sys_forms_field_index'    => 'size',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 'lg',
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12 col-md-6",

                    "choices" => [

                        "sm"         => "Small",
                        "md"         => "Medium",
                        "lg"         => "Large",
                        "xl"         => "Extra Large",
                        "fullscreen" => "Tela inteira"

                    ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Backdrop',
                'tbl_sys_forms_field_name'     => 'backdrop',
                'tbl_sys_forms_field_index'    => 'backdrop',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => true,
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12 col-md-6",

                    "choices" => [

                        true  => "Sim",
                        false => "Não"

                    ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Fechar com ESC',
                'tbl_sys_forms_field_name'     => 'keyboard',
                'tbl_sys_forms_field_index'    => 'keyboard',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12 col-md-6",

                    "choices" => [

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

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Conteúdo Rolável',
                'tbl_sys_forms_field_name'     => 'scrollable',
                'tbl_sys_forms_field_index'    => 'scrollable',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12 col-md-6",

                    "choices" => [

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

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Callback',
                'tbl_sys_forms_field_name'     => 'callback',
                'tbl_sys_forms_field_index'    => 'callback',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12",

                    "rows" => 3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1, 2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Before Show',
                'tbl_sys_forms_field_name'     => 'beforeShow',
                'tbl_sys_forms_field_index'    => 'beforeShow',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12",

                    "rows" => 3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1, 2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'After Hide',
                'tbl_sys_forms_field_name'     => 'afterHide',
                'tbl_sys_forms_field_index'    => 'afterHide',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class" => "col-12",

                    "rows" => 3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]

              ]

            ]

          ],

        // OPEN VIEW MODAL - END



        // OPEN FORM MODAL - START

          [

            'tbl_sys_form_name'     => 'admin-open-form-modal',
            'tbl_sys_form_title'    => 'Abrir Formulário Modal',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Gerar Código',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => false,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Formulário',
                'tbl_sys_forms_field_name'     => 'form',
                'tbl_sys_forms_field_index'    => 'form',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12 col-md-5",

                  "type" => "select",

                  "relation" => [

                    "table" => "tbl_sys_forms",

                    "value" => "tbl_sys_form_name",

                    "label" => "tbl_sys_form_title"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Título do Modal',
                'tbl_sys_forms_field_name'     => 'title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12 col-md-7",

                  "maxlenght"=>255

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Método de Carregamento',
                'tbl_sys_forms_field_name'     => 'loadMethod',
                'tbl_sys_forms_field_index'    => 'loadMethod',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 'GET',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12 col-md-6",

                  "choices" => [

                    "GET"  => "GET",
                    "POST" => "POST"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1,2] 

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Rota de Carregamento',
                'tbl_sys_forms_field_name'     => 'loadRoute',
                'tbl_sys_forms_field_index'    => 'loadRoute',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12 col-md-6",

                  "type" => "select",

                  "relation" => [

                    "table" => "tbl_sys_routes",

                    "value" => "tbl_sys_route_name",

                    "label" => "tbl_sys_route_title",
                    "filters" => [

                      "tbl_sys_route_api" => [

                        "false" => [
                          "class"    => "",
                          "disabled" => true,
                          "remove"   => true
                        ],
                        false   => [
                          "class"    => "",
                          "disabled" => true,
                          "remove"   => true
                        ],
                      
                      ]

                    ],
                    "where" => [

                      "tbl_sys_route_api" => true,
                      // "tbl_sys_route_status" => "ativo"

                    ]

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Método de Envio',
                'tbl_sys_forms_field_name'     => 'submitMethod',
                'tbl_sys_forms_field_index'    => 'submitMethod',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 'POST',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12 col-md-6",

                  "choices"=>[

                    "POST" => "POST",

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Rota de Envio',
                'tbl_sys_forms_field_name'     => 'submitRoute',
                'tbl_sys_forms_field_index'    => 'submitRoute',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12 col-md-6",

                  "type" => "select",

                  "relation" => [

                    "table"   => "tbl_sys_routes",
                    "value"   => "tbl_sys_route_name",
                    "label"   => "tbl_sys_route_title",
                    "filters" => [

                      "tbl_sys_route_api" => [

                        "false" => [

                          "class"    => "",
                          "disabled" => true,
                          "remove"   => true

                        ],

                        false   => [

                          "class"    => "",
                          "disabled" => true,
                          "remove"   => true
                        
                        ],
                      
                      ]

                    ],

                    "where" => [

                      "tbl_sys_route_api" => true,
                      "tbl_sys_route_status" => "ativo"

                    ]

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tamanho',
                'tbl_sys_forms_field_name'     => 'size',
                'tbl_sys_forms_field_index'    => 'size',
                'tbl_sys_forms_field_default'  => 'lg',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12 col-md-6",

                  "choices"=>[

                    "sm"=>"Small",
                    "md"=>"Medium",
                    "lg"=>"Large",
                    "xl"=>"Extra Large",
                    "fullscreen"=>"Tela inteira"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Backdrop',
                'tbl_sys_forms_field_name'     => 'backdrop',
                'tbl_sys_forms_field_index'    => 'backdrop',
                'tbl_sys_forms_field_default'  => true,
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12 col-md-6",

                  "choices"=>[

                    true=>"Sim",
                    false=>"Não"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Fechar com ESC',
                'tbl_sys_forms_field_name'     => 'keyboard',
                'tbl_sys_forms_field_index'    => 'keyboard',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12 col-md-6",

                  "choices"=>[

                    true=>"Sim",
                    false=>"Não"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Conteúdo Rolável',
                'tbl_sys_forms_field_name'     => 'scrollable',
                'tbl_sys_forms_field_index'    => 'scrollable',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12 col-md-6",

                  "choices"=>[

                    true=>"Sim",
                    false=>"Não"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 10,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Callback',
                'tbl_sys_forms_field_name'     => 'callback',
                'tbl_sys_forms_field_index'    => 'callback',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                    "wrapper_class"=>"col-12",

                    "rows"=>3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 11,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Before Show',
                'tbl_sys_forms_field_name'     => 'beforeShow',
                'tbl_sys_forms_field_index'    => 'beforeShow',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12",

                  "rows"=>3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 12,
                'field_access'                 => [1,2]

              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'After Hide',
                'tbl_sys_forms_field_name'     => 'afterHide',
                'tbl_sys_forms_field_index'    => 'afterHide',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class"=>"col-12",

                  "rows"=>3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 13,
                'field_access'                 => [1,2]

              ]

            ]

          ],
          
        // OPEN FORM MODAL - END



        // VISUALIZAR NOTIFICAÇÕES - START

          [

            'tbl_sys_form_name'     => 'admin-user-notification',
            'tbl_sys_form_title'    => 'Visualizar Notificação',
            'tbl_sys_form_cancel'   => 'Fechar',
            'tbl_sys_form_submit'   => 'Atualizar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => false,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2, 3, 4],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_ID',
                'tbl_sys_forms_field_index'    => 'id',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Usuário',
                'tbl_sys_forms_field_name'     => 'tbl_user_ID',
                'tbl_sys_forms_field_index'    => 'userID',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "type"          => "hidden",
                  "relation"      => [

                    "table"   => "tbl_users",
                    "value"   => "tbl_user_ID",
                    "label"   => "tbl_user_ID",

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Titulo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_title',
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
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Mensagem',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_text',
                'tbl_sys_forms_field_index'    => 'text',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12",
                  "readonly"      => true,
                  "disabled"      => true,
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_opened',
                'tbl_sys_forms_field_index'    => 'opened',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 0,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    0 => "Fechada",
                    1 => "Aberta",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('datetime', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Data de envio',
                'tbl_sys_forms_field_name'     => 'tbl_sys_notification_created_at',
                'tbl_sys_forms_field_index'    => 'created_at',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12 col-md-6",
                  "readonly"      => true,
                  "disabled"      => true,
                  "format"        => "Y-m-d H:i:s",
                  "display"       => "d/m/Y - H:i:s",
                  "attrs"         => [

                    "format"  => "Y-m-d H:i:s",
                    "display" => "d/m/Y - H:i:s"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1, 2, 3, 4]
              
              ],

            ]

          ],

        // VISUALIZAR NOTIFICAÇÕES - END



        // MIDIA TYPES - START

          [

            'tbl_sys_form_name'     => 'admin-galeria-uploads-types',
            'tbl_sys_form_title'    => 'Tipos de mídia',
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
                'tbl_sys_forms_field_name'     => 'tbl_sys_uploads_type_ID',
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

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('icon-picker', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Icone',
                'tbl_sys_forms_field_name'     => 'tbl_sys_uploads_type_icon',
                'tbl_sys_forms_field_index'    => 'icon',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 'icons',
                'tbl_sys_forms_field_props'    => json_encode([
                  "maxlenght" => 255,
                  "wrapper_class" => "col-12 col-md-5",

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Mine Type',
                'tbl_sys_forms_field_name'     => 'tbl_sys_uploads_type_mine',
                'tbl_sys_forms_field_index'    => 'mine',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-7",
                  "maxlenght" => 255,
                  "minlenght" => 2,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('slug', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Type',
                'tbl_sys_forms_field_name'     => 'tbl_sys_uploads_type_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-5",
                  "maxlenght" => 255,
                  "minlenght" => 2,
                  "unique"    => [

                    "table"  => "tbl_sys_uploads_types",
                    "column" => "tbl_sys_uploads_type_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_sys_uploads_type_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-7",
                  "maxlenght" => 255,
                  "minlenght" => 3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Descrição',
                'tbl_sys_forms_field_name'     => 'tbl_sys_uploads_type_description',
                'tbl_sys_forms_field_index'    => 'description',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12",
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_sys_uploads_type_locked',
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
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1]
              
              ],

            ]

          ],

        // MIDIA TYPES - END



        // LANGUAGES - START

          [

            'tbl_sys_form_name'     => 'admin-languages',
            'tbl_sys_form_title'    => 'Idiomas',
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
                'tbl_sys_forms_field_name'     => 'tbl_sys_translation_ID',
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

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('slug', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Key',
                'tbl_sys_forms_field_name'     => 'tbl_sys_translation_key',
                'tbl_sys_forms_field_index'    => 'key',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-5",
                  "maxlenght" => 255,
                  "minlenght" => 2,
                  "unique"    => [

                    "table"  => "tbl_sys_translations",
                    "column" => "tbl_sys_translation_key"

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
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_sys_translation_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-7",
                  "maxlenght" => 255,
                  "minlenght" => 3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('textarea', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Descrição',
                'tbl_sys_forms_field_name'     => 'tbl_sys_translation_description',
                'tbl_sys_forms_field_index'    => 'description',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12",
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_sys_translation_locked',
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
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1]
              
              ],

            ]

          ],

        // LANGUAGES - END



        // FUNCTIONS - START

          [

            'tbl_sys_form_name'     => 'admin-functions',
            'tbl_sys_form_title'    => 'Funções',
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
                'tbl_sys_forms_field_name'     => 'tbl_sys_function_ID',
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

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Tipo',
                'tbl_sys_forms_field_name'     => 'tbl_sys_function_type',
                'tbl_sys_forms_field_index'    => 'type',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 'custom',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-4",
                  "choices"       => [

                    'custom' => "Custom",
                    'nativo' => "Nativa",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('slug', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome',
                'tbl_sys_forms_field_name'     => 'tbl_sys_function_name',
                'tbl_sys_forms_field_index'    => 'key',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-4",
                  "maxlenght" => 255,
                  "minlenght" => 2,
                  "unique"    => [

                    "table"  => "tbl_sys_functions",
                    "column" => "tbl_sys_function_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Função',
                'tbl_sys_forms_field_name'     => 'tbl_sys_function_fn',
                'tbl_sys_forms_field_index'    => 'function',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-4",
                  "maxlenght" => 255,
                  "minlenght" => 3,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],
              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('json', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Parâmetros',
                'tbl_sys_forms_field_name'     => 'tbl_sys_function_params',
                'tbl_sys_forms_field_index'    => 'params',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '{}',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12",
                  "placeholder"   => "Adicione os parâmetros aceitos pela função.",
                  "root-type"     => "object",
                  "allow-object"  => true,
                  "allow-array"   => true,
                  "allow-string"  => true,
                  "allow-number"  => true,
                  "allow-boolean" => true,
                  "allow-null"    => true,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('json', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Propriedades',
                'tbl_sys_forms_field_name'     => 'tbl_sys_function_props',
                'tbl_sys_forms_field_index'    => 'props',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '{}',
                'tbl_sys_forms_field_props'    => json_encode([

                  "wrapper_class" => "col-12",
                  "placeholder"   => "Adicione os provedores e propriedades associados aos parâmetros.",
                  "root-type"     => "object",
                  "allow-object"  => true,
                  "allow-array"   => true,
                  "allow-string"  => true,
                  "allow-number"  => true,
                  "allow-boolean" => true,
                  "allow-null"    => true,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1]
              
              ],


            ]

          ],

        // FUNCTIONS - END



        // MENUS - START

          [

            'tbl_sys_form_name'     => 'admin-menus',
            'tbl_sys_form_title'    => 'Menus',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Criar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Nome do menu',
                'tbl_sys_forms_field_name'     => 'tbl_sys_menu_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-7",
                  "maxlenght" => 255,
                  "minlenght" => 2,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 1,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('slug', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'ID do Menu',
                'tbl_sys_forms_field_name'     => 'tbl_sys_menu_index',
                'tbl_sys_forms_field_index'    => 'index',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-5",
                  "maxlenght" => 255,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Classes do Menu',
                'tbl_sys_forms_field_name'     => 'tbl_sys_menu_class',
                'tbl_sys_forms_field_index'    => 'class',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => "col-12 col-md-6",
                  "maxlenght" => 255,

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 3,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
                'tbl_sys_forms_field_title'    => 'Bloqueado',
                'tbl_sys_forms_field_name'     => 'tbl_sys_menu_locked',
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
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1]
              
              ],

            ]

          ],

        // MENUS - END



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
