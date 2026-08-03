<?php


  namespace Database\Seeders;

  
  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\DB;
  use App\Helpers\SysAutomator;


  // use App\Models\SysFieldType;
  // use App\Models\SysPagination;
  // use App\Models\SysPaginationsArg;
  // use App\Models\SysPaginationsCol;
  // use App\Models\SysPaginationsColsAccess;



  class SysPaginationsSeeder extends Seeder {


    private function getFieldTypeID($name) {

      return DB::table('tbl_sys_field_types')->where('tbl_sys_field_type_name', $name)->value('tbl_sys_field_type_ID');

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
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Categorias de Posts'),
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

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-posts-categories-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-posts-categories-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-posts-categories-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-posts-categories-delete',
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
                      'id'      => 'btn-add-post-categorie',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova Categoria'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Nova Categoria') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-posts-categories') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

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
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Categoria'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Categoria') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-posts-categories') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-post-categorie',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Categoria'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
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
                'tbl_sys_paginations_col_name'   => 'tbl_post_categorie_status',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Status'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'ativo'   => '<span class="badge text-bg-success">' . SysAutomator::SysAutomatorGetTranslateWord('Ativo') . '</span>',
                    'inativo' => '<span class="badge text-bg-danger">' . SysAutomator::SysAutomatorGetTranslateWord('Inativo') . '</span>'
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
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
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Posts'),
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
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Post'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Post') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-posts') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

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
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Post'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Post') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-posts') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-post',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Post'),
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
                'tbl_sys_paginations_col_name'   => 'tbl_post_slug',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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
                'tbl_sys_paginations_col_name'   => 'tbl_post_title',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Status'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'publicado' => '<span class="badge text-bg-success">' . SysAutomator::SysAutomatorGetTranslateWord('Publicado') . '</span>',
                    'rascunho'  => '<span class="badge text-bg-secondary">' . SysAutomator::SysAutomatorGetTranslateWord('Rascunho') . '</span>',
                    'lixeira'   => '<span class="badge text-bg-danger">' . SysAutomator::SysAutomatorGetTranslateWord('Lixeira') . '</span>',
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => $this->getFieldTypeID('text'),
                'tbl_sys_paginations_col_name'   => 'tbl_post_created_at',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Data de Publicação'),
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

          $paginationID = DB::table('tbl_sys_paginations')
              ->insertGetId($pagination);



          /*
          |--------------------------------------------------------------------------
          | Criar argumentos
          |--------------------------------------------------------------------------
          */

          foreach ($paginationArgs as $paginationArg) {


              $paginationArg['tbl_sys_pagination_ID'] = $paginationID;


              DB::table('tbl_sys_paginations_args')
                  ->insert($paginationArg);


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

              $paginationCol['tbl_sys_field_type_ID'] = DB::table('tbl_sys_field_types')
                  ->where(
                      'tbl_sys_field_type_name',
                      DB::raw("'" . DB::getPdo()->quote($paginationCol['tbl_sys_field_type_ID']) . "'")
                  );


              $paginationCol['tbl_sys_pagination_ID'] = $paginationID;
              $paginationCol['tbl_sys_paginations_col_ordem'] = $order;



              /*
              |--------------------------------------------------------------------------
              | Inserir coluna
              |--------------------------------------------------------------------------
              */

              $paginationColID = DB::table('tbl_sys_paginations_cols')
                  ->insertGetId($paginationCol);



              /*
              |--------------------------------------------------------------------------
              | Inserir permissões
              |--------------------------------------------------------------------------
              */

              foreach ($colAccess as $userTypeID) {


                  DB::table('tbl_sys_paginations_cols_access')
                      ->insert([

                          'tbl_users_type_ID'          => $userTypeID,
                          'tbl_sys_paginations_col_ID' => $paginationColID

                      ]);


              }


              $order++;


          }


      }
      // foreach ($paginations as $pagination) {

      //   $paginationArgs   = $pagination['pagination_args'];
      //   $paginationCols   = $pagination['pagination_cols'];

      //   unset($pagination['pagination_args']);
      //   unset($pagination['pagination_cols']);

      //   $paginacao = SysPagination::create($pagination);

      //   $paginationID = $paginacao->getKey();

      //   foreach ($paginationArgs as $paginationArg) {
          
      //     $paginationArg['tbl_sys_pagination_ID'] = $paginationID;
      //     SysPaginationsArg::Create($paginationArg);

      //   }


      //   $order = 1;

      //   foreach ($paginationCols as $paginationCol) {

      //     $col = $paginationCol;
          
      //     $colAccess = $col['cols_access'];

      //     unset($col['cols_access']);


      //     $col['tbl_sys_pagination_ID'] = $paginationID;
      //     $col['tbl_sys_paginations_col_ordem'] = $order;

      //     $paginacaoCol = SysPaginationsCol::create($col);

      //     $paginationColID = $paginacaoCol->getKey();

      //     foreach ($colAccess as $_colAccess) {
            
      //       SysPaginationsColsAccess::Create([
      //         'tbl_users_type_ID'          => $_colAccess,
      //         'tbl_sys_paginations_col_ID' => $paginationColID
            
      //       ]);

      //     }

      //     $order++;

      //   }

      //   // code...
      // }
    

    }
  


  }
