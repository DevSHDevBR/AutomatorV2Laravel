<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\DB;
  
  // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  // use Illuminate\Database\Seeder;

  // use App\Models\SysForm;
  // use App\Models\SysFieldType;
  // use App\Models\SysFormsField;
  // use App\Models\SysFormsFieldsAccess;
  // use App\Models\SysFormsAccess;



  class SysFormsSeeder extends Seeder {


    private function getFieldTypeID(string $name)
    {
        return DB::table('tbl_sys_field_types')
            ->where('tbl_sys_field_type_name', $name)
            ->value('tbl_sys_field_type_ID');
    }


    public function run(): void {

      $formularios = [

        // CATEGORIAS - START

          [

            'tbl_sys_form_name'     => 'admin-posts-categories',
            'tbl_sys_form_title'    => 'Categorias de Posts',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('hidden'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_post_categorie_ID',
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

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('text'),
                'tbl_sys_forms_field_title'    => 'Slug',
                'tbl_sys_forms_field_name'     => 'tbl_post_categorie_name',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-5',
                  "maxlenght" => 255,
                  "minlenght" => 2,
                  "unique"    => [

                    "table"  => "tbl_post_categories",
                    "column" => "tbl_post_categorie_name"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('text'),
                'tbl_sys_forms_field_title'    => 'Titulo',
                'tbl_sys_forms_field_name'     => 'tbl_post_categorie_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-7',
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

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('editor'),
                'tbl_sys_forms_field_title'    => 'Conteudo',
                'tbl_sys_forms_field_name'     => 'tbl_post_categorie_content',
                'tbl_sys_forms_field_index'    => 'content',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('relation'),
                'tbl_sys_forms_field_title'    => 'Categoria Pai',
                'tbl_sys_forms_field_name'     => 'tbl_post_categorie_parent_id',
                'tbl_sys_forms_field_index'    => 'post_parent_categorie',
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

                    "table"   => "tbl_post_categories",
                    "value"   => "tbl_post_categorie_ID",
                    "label"   => "tbl_post_categorie_name",
                    "filters" => [

                      "tbl_post_categorie_status" => [
                        
                        "ativo" => [
                          
                          "class"    => "",
                          "disabled" => false,
                          "remove"   => false
                        
                        ],
                        "inativo" => [
                          
                          "class"    => "disabled",
                          "tooltip"  => "Somente categorias ativos podem ter as permissões de acesso alteradas.",
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
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('select'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_post_categorie_status',
                'tbl_sys_forms_field_index'    => 'status',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "rascunho",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "ativo"   => "Ativo",
                    "inativo" => "Inativo",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('select'),
                'tbl_sys_forms_field_title'    => 'Acesso a categoria',
                'tbl_sys_forms_field_name'     => 'tbl_post_categorie_access',
                'tbl_sys_forms_field_index'    => 'access',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 'public',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    'public'   => "Publico",
                    'restrict' => "Restrito"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1, 2]
              
              ],
              
              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('relation'),
                'tbl_sys_forms_field_title'    => 'Permissões concedidas',
                'tbl_sys_forms_field_name'     => 'tbl_post_users_type',
                'tbl_sys_forms_field_index'    => 'users_type',
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
                    "filters" => [

                      "tbl_users_type_status" => [
                        
                        "ativo" => [
                          
                          "class"    => "",
                          "disabled" => false,
                          "remove"   => false
                        
                        ],
                        "inativo" => [
                          
                          "class"    => "disabled",
                          "tooltip"  => "Somente tipos de usuários ativos podem ter as permissões de acesso alteradas.",
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
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('hidden'),
                'tbl_sys_forms_field_title'    => 'userID',
                'tbl_sys_forms_field_name'     => 'tbl_user_ID',
                'tbl_sys_forms_field_index'    => 'userID',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "@SysFunctions('sysGetCurrentUserData', ['data' => 'tbl_user_ID'])",
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]
              
              ],

              

            ]

          ],

        // CATEGORIAS - END


        // POSTS - START

          [

            'tbl_sys_form_name'     => 'admin-posts',
            'tbl_sys_form_title'    => 'Posts',
            'tbl_sys_form_cancel'   => 'Cancelar',
            'tbl_sys_form_submit'   => 'Salvar',
            'tbl_sys_form_modal'    => true,
            'tbl_sys_form_admin'    => true,
            'tbl_sys_form_validate' => true,
            'tbl_sys_form_locked'   => true,
            'form_access'           => [1, 2],
            'form_fields'           => [

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('hidden'),
                'tbl_sys_forms_field_title'    => 'ID',
                'tbl_sys_forms_field_name'     => 'tbl_post_ID',
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

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('text'),
                'tbl_sys_forms_field_title'    => 'Slug',
                'tbl_sys_forms_field_name'     => 'tbl_post_slug',
                'tbl_sys_forms_field_index'    => 'name',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-5',
                  "maxlenght" => 255,
                  "minlenght" => 2,
                  "unique"    => [

                    "table"  => "tbl_posts",
                    "column" => "tbl_post_slug"

                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 2,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('text'),
                'tbl_sys_forms_field_title'    => 'Titulo',
                'tbl_sys_forms_field_name'     => 'tbl_post_title',
                'tbl_sys_forms_field_index'    => 'title',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "wrapper_class" => 'col-12 col-md-7',
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

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('editor'),
                'tbl_sys_forms_field_title'    => 'Conteudo',
                'tbl_sys_forms_field_name'     => 'tbl_post_content',
                'tbl_sys_forms_field_index'    => 'content',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => '',
                'tbl_sys_forms_field_props'    => json_encode([
                  "rows" => 4
                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 4,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('image'),
                'tbl_sys_forms_field_title'    => 'Imagem de destaque',
                'tbl_sys_forms_field_name'     => 'tbl_post_featured_image',
                'tbl_sys_forms_field_index'    => 'api',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => false,
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12",

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 5,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('relation'),
                'tbl_sys_forms_field_title'    => 'Categorias',
                'tbl_sys_forms_field_name'     => 'tbl_post_categories',
                'tbl_sys_forms_field_index'    => 'post_categories',
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

                    "table"   => "tbl_post_categories",
                    "value"   => "tbl_post_categorie_ID",
                    "label"   => "tbl_post_categorie_name",
                    "filters" => [

                      "tbl_post_categorie_status" => [
                        
                        "ativo" => [
                          
                          "class"    => "",
                          "disabled" => false,
                          "remove"   => false
                        
                        ],
                        "inativo" => [
                          
                          "class"    => "disabled",
                          "tooltip"  => "Somente categorias ativos podem ter as permissões de acesso alteradas.",
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
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('select'),
                'tbl_sys_forms_field_title'    => 'Status',
                'tbl_sys_forms_field_name'     => 'tbl_post_status',
                'tbl_sys_forms_field_index'    => 'status',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "rascunho",
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    "lixeira"   => "Lixeira",
                    "rascunho"  => "Rascunho",
                    "publicado" => "Publicado",
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 7,
                'field_access'                 => [1, 2]
              
              ],


              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('select'),
                'tbl_sys_forms_field_title'    => 'Acesso ao post',
                'tbl_sys_forms_field_name'     => 'tbl_post_access',
                'tbl_sys_forms_field_index'    => 'access',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => 'public',
                'tbl_sys_forms_field_props'    => json_encode([
                  
                  "wrapper_class" => "col-12 col-md-6",
                  "choices"       => [

                    'public'   => "Publico",
                    'restrict' => "Restrito"
                  
                  ]

                ]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => true,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 6,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('relation'),
                'tbl_sys_forms_field_title'    => 'Permissões concedidas',
                'tbl_sys_forms_field_name'     => 'tbl_post_users_type',
                'tbl_sys_forms_field_index'    => 'users_type',
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
                    "filters" => [

                      "tbl_users_type_status" => [
                        
                        "ativo" => [
                          
                          "class"    => "",
                          "disabled" => false,
                          "remove"   => false
                        
                        ],
                        "inativo" => [
                          
                          "class"    => "disabled",
                          "tooltip"  => "Somente tipos de usuários ativos podem ter as permissões de acesso alteradas.",
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
                'tbl_sys_forms_field_ordem'    => 8,
                'field_access'                 => [1, 2]
              
              ],

              [

                'tbl_sys_field_type_ID'        => $this->getFieldTypeID('hidden'),
                'tbl_sys_forms_field_title'    => 'userID',
                'tbl_sys_forms_field_name'     => 'tbl_user_ID',
                'tbl_sys_forms_field_index'    => 'userID',
                'tbl_sys_forms_field_class'    => '',
                'tbl_sys_forms_field_default'  => "@SysFunctions('sysGetCurrentUserData', ['data' => 'tbl_user_ID'])",
                'tbl_sys_forms_field_props'    => json_encode(["type" => "int"]),
                'tbl_sys_forms_field_attrs'    => '',
                'tbl_sys_forms_field_required' => false,
                'tbl_sys_forms_field_locked'   => true,
                'tbl_sys_forms_field_ordem'    => 9,
                'field_access'                 => [1, 2]
              
              ],

              

            ]

          ],

        // POSTS - END

      ];


      foreach ($formularios as $formulario) {


          $formFields = $formulario['form_fields'];
          $formAccess = $formulario['form_access'];


          unset($formulario['form_fields']);
          unset($formulario['form_access']);



          /*
          |--------------------------------------------------------------------------
          | Criar formulário
          |--------------------------------------------------------------------------
          */

          $formID = DB::table('tbl_sys_forms')
              ->insertGetId($formulario);



          /*
          |--------------------------------------------------------------------------
          | Acessos do formulário
          |--------------------------------------------------------------------------
          */

          foreach ($formAccess as $userTypeID) {


              DB::table('tbl_sys_forms_access')
                  ->insert([

                      'tbl_sys_form_ID'   => $formID,
                      'tbl_users_type_ID' => $userTypeID

                  ]);


          }




          /*
          |--------------------------------------------------------------------------
          | Campos do formulário
          |--------------------------------------------------------------------------
          */

          foreach ($formFields as $field) {


              $fieldAccess = $field['field_access'];


              unset($field['field_access']);



              $field['tbl_sys_form_ID'] = $formID;



              /*
              |--------------------------------------------------------------------------
              | Criar campo
              |--------------------------------------------------------------------------
              */

              $fieldID = DB::table('tbl_sys_forms_fields')
                  ->insertGetId($field);




              /*
              |--------------------------------------------------------------------------
              | Permissões do campo
              |--------------------------------------------------------------------------
              */

              foreach ($fieldAccess as $userTypeID) {


                  DB::table('tbl_sys_forms_fields_access')
                      ->insert([

                          'tbl_users_type_ID'      => $userTypeID,
                          'tbl_sys_forms_field_ID' => $fieldID

                      ]);


              }


          }


      }
      // foreach ($formularios as $formulario) {

      //   $form_fields = $formulario['form_fields'];
      //   $form_access = $formulario['form_access'];

      //   unset($formulario['form_fields']);
      //   unset($formulario['form_access']);

      //   $formItem = SysForm::create($formulario);

      //   $formItemID = $formItem->getKey();

      //   foreach ($form_access as $form_accessItem) {
          
      //     SysFormsAccess::Create([

      //       'tbl_sys_form_ID'   => $formItemID,
      //       'tbl_users_type_ID' => $form_accessItem

      //     ]);

      //   }

      //   foreach ($form_fields as $fields) {
          
      //     $field = $fields;

      //     $field_access = $field['field_access'];
      //     unset($field['field_access']);

      //     $field["tbl_sys_form_ID"] = $formItemID;

      //     $fieldItem = SysFormsField::create($field);

      //     $fieldItemID = $fieldItem->getKey();

      //     foreach ($field_access as $field_accessItem) {
            
      //       SysFormsFieldsAccess::Create([

      //         'tbl_users_type_ID'      => $field_accessItem,
      //         'tbl_sys_forms_field_ID' => $fieldItemID

      //       ]);

      //     }

      //   }


      //   // SysFormsAccess::Create([
      //   //   'tbl_sys_form_ID' => $formItemID,
      //   //   'tbl_users_type_ID' => 1
      //   // ]);
      //   // code...
      // }


    }


  }