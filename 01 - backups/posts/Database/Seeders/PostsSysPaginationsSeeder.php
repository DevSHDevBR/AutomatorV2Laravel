<?php


  namespace Posts\Database\Seeders;

  
  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\DB;
  



  class PostsSysPaginationsSeeder extends Seeder {




    private function createModuloRel($table, $column, $value) {


      DB::table('tbl_sys_modulos_rels')->insert([

        'tbl_sys_modulo_rel_name'   => 'posts',
        'tbl_sys_modulo_rel_table'  => $table,
        'tbl_sys_modulo_rel_column' => $column,
        'tbl_sys_modulo_rel_value'  => $value,

      ]);

    
    }



    private function getFieldTypeID($name) {


      return DB::table('tbl_sys_field_types')->where('tbl_sys_field_type_name', $name)->value('tbl_sys_field_type_ID');


    }



    private function getFormID($name) {

      return DB::table('tbl_sys_forms')->where('tbl_sys_form_name', $name)->value('tbl_sys_form_ID');

    }

    /**
     * Run the database seeds.
     */
    public function run(): void {


      $paginations = [

        // CATEGORIAS - START

          [

            'tbl_sys_pagination_name'   => 'admin-posts-categories-pagination',
            'tbl_sys_pagination_route'  => 'admin-post-categories',
            'tbl_sys_pagination_title'  => ('Paginação de Categorias de Posts'),
            'tbl_sys_pagination_table'  => 'tbl_post_categories',
            'tbl_sys_pagination_index'  => 'tbl_post_categorie_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => "@SysFunctions('sysGetCurrentRouteData', ['data' => 'tbl_sys_route_name'])"
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'default_sort',
                'tbl_sys_paginations_arg_value' => 'tbl_post_categorie_ordem'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'direction',
                'tbl_sys_paginations_arg_value' => 'ASC'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-post-categories-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-post-categories-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-post-categories-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-post-categories-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_post_categorie_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ],
                  'activate' => [

                    'route'  => 'admin-api-post-categories-active',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_post_categorie_status',
                        'compare' => '==',
                        'value'   => 'ativo'
                      
                      ],
                      
                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_post_categorie_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ],

                    ]
                  
                  ],
                  'desactivate' => [

                    'route'  => 'admin-api-post-categories-desactive',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_post_categorie_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],

                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_post_categorie_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ],

                    ]
                  
                  ],

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-post-categorie',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => ('Nova Categoria'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . ('Nova Categoria') . "', " . $this->getFormID('admin-posts-categories') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-post-categorie',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => ('Editar Categoria'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . ('Editar Categoria') . "', " . $this->getFormID('admin-posts-categories') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); AutomatorPaginationCreateModalFormCallBackRemoveSelectOption('tbl_post_categorie_parent_id', '{id}'); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'activate',
                    'id'      => 'btn-activate-post-categorie',
                    'class'   => 'btn-success',
                    'icon'    => 'check',
                    'text'    => ('Ativar Categoria de Post'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'desactivate',
                    'id'      => 'btn-desactivate-post-categorie',
                    'class'   => 'btn-secondary',
                    'icon'    => 'times',
                    'text'    => ('Desativar Categoria de Post'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-post-categorie',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => ('Excluir Categoria'),
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('number'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_categorie_ID',
                'tbl_sys_paginations_col_title'  => 'ID',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('text'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_categorie_name',
                'tbl_sys_paginations_col_title'  => ('Nome'),
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('text'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_categorie_title',
                'tbl_sys_paginations_col_title'  => ('Titulo'),
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('relation'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_categorie_parent_id',
                'tbl_sys_paginations_col_title'  => ('Categoria Pai'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => json_encode([

                  'type'     => 'single',
                  'mode'     => 'revert',
                  'table'    => 'tbl_post_categories',
                  'column'   => 'tbl_post_categorie_ID',
                  'display'  => 'tbl_post_categorie_title',
                  'nullable' => true,
                  'empty'    => '- - -'
                  
                ]),
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('text'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_categorie_status',
                'tbl_sys_paginations_col_title'  => ('Status'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'ativo'   => '<span class="badge text-bg-success">' . ('Ativo') . '</span>',
                    'inativo' => '<span class="badge text-bg-danger">' . ('Inativo') . '</span>'
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ]

            ],

          ],

        // CATEGORIAS - END


        // POSTS - START

          [

            'tbl_sys_pagination_name'   => 'admin-posts-pagination',
            'tbl_sys_pagination_route'  => 'admin-post',
            'tbl_sys_pagination_title'  => ('Paginação de Posts'),
            'tbl_sys_pagination_table'  => 'tbl_posts',
            'tbl_sys_pagination_index'  => 'tbl_post_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => "@SysFunctions('sysGetCurrentRouteData', ['data' => 'tbl_sys_route_name'])"
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'default_sort',
                'tbl_sys_paginations_arg_value' => 'tbl_post_created_at'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'direction',
                'tbl_sys_paginations_arg_value' => 'DESC'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-post-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-post-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-post-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-post-delete',
                    'params' => [],
                    'show'   => false,
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-post',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => ('Novo Post'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-xl','" . ('Novo Post') . "', " . $this->getFormID('admin-posts') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-post',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => ('Editar Post'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-xl', '" . ('Editar Post') . "', " . $this->getFormID('admin-posts') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-post',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => ('Excluir Post'),
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('number'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_ID',
                'tbl_sys_paginations_col_title'  => 'ID',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('text'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_title',
                'tbl_sys_paginations_col_title'  => ('Titulo'),
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('text'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_status',
                'tbl_sys_paginations_col_title'  => ('Status'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'publicado' => '<span class="badge text-bg-success">' . ('Publicado') . '</span>',
                    'rascunho'  => '<span class="badge text-bg-secondary">' . ('Rascunho') . '</span>',
                    'lixeira'   => '<span class="badge text-bg-danger">' . ('Lixeira') . '</span>',
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('text'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_created_at',
                'tbl_sys_paginations_col_title'  => ('Data de Publicação'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => json_encode([

                  'format'  => 'Y-m-d H:i:s',
                  'display' => 'd/m/Y - H:i',
                  
                ]),
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],

            ],

          ],

        // POSTS - END

      ];

      foreach ($paginations as $pagination) {


          $paginationArgs = $pagination['pagination_args'];
          $paginationCols = $pagination['pagination_cols'];


          unset($pagination['pagination_args']);
          unset($pagination['pagination_cols']);



          /*
          |--------------------------------------------------------------------------
          | Criar paginação
          |--------------------------------------------------------------------------
          */

          $paginationID = DB::table('tbl_sys_paginations')->insertGetId($pagination);
          

          $this->createModuloRel('tbl_sys_paginations', 'tbl_sys_pagination_ID', $paginationID);



          /*
          |--------------------------------------------------------------------------
          | Criar argumentos
          |--------------------------------------------------------------------------
          */

          foreach ($paginationArgs as $paginationArg) {


            $paginationArg['tbl_sys_pagination_ID'] = $paginationID;


             $paginationArgID = DB::table('tbl_sys_paginations_args')->insertGetId($paginationArg);
             

             $this->createModuloRel('tbl_sys_paginations_args', 'tbl_sys_paginations_arg_ID', $paginationArgID);


          }




          /*
          |--------------------------------------------------------------------------
          | Criar colunas
          |--------------------------------------------------------------------------
          */

          $order = 1;


          foreach ($paginationCols as $paginationCol) {


              $colAccess = $paginationCol['cols_access'];


              unset($paginationCol['cols_access']);



              /*
              |--------------------------------------------------------------------------
              | Resolver Field Type
              |--------------------------------------------------------------------------
              */



              $paginationCol['tbl_sys_pagination_ID'] = $paginationID;
              $paginationCol['tbl_sys_paginations_col_ordem'] = $order;



              /*
              |--------------------------------------------------------------------------
              | Inserir coluna
              |--------------------------------------------------------------------------
              */

              $paginationColID = DB::table('tbl_sys_paginations_cols')->insertGetId($paginationCol);
              

              $this->createModuloRel('tbl_sys_paginations_cols', 'tbl_sys_paginations_col_ID', $paginationColID);



              /*
              |--------------------------------------------------------------------------
              | Inserir permissões
              |--------------------------------------------------------------------------
              */

              foreach ($colAccess as $userTypeID) {


                  $userType = DB::table('tbl_sys_paginations_cols_access')->insertGetId(['tbl_users_type_ID' => $userTypeID, 'tbl_sys_paginations_col_ID' => $paginationColID]);


                  $this->createModuloRel('tbl_sys_paginations_cols_access', 'tbl_sys_pagination_col_access_ID', $userType);


              }


              $order++;


          }


      }
    

    }
  


  }
