<?php


  namespace Database\Seeders;

  
  use Illuminate\Database\Seeder;

  use App\Helpers\SysAutomator;


  use App\Models\SysFieldType;
  use App\Models\SysPagination;
  use App\Models\SysPaginationsArg;
  use App\Models\SysPaginationsCol;
  use App\Models\SysPaginationsColsAccess;



  class SysPaginationsSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {
      

      // [

      //   'tbl_sys_pagination_name'   => '',
      //   'tbl_sys_pagination_route'  => '',
      //   'tbl_sys_pagination_title'  => '',
      //   'tbl_sys_pagination_table'  => '',
      //   'tbl_sys_pagination_index'  => '',
      //   'tbl_sys_pagination_locked' => true,
      //   'pagination_args'           => [
          
      //     [

      //       'tbl_sys_paginations_arg_name'  => 'page_name',
      //       'tbl_sys_paginations_arg_value' => ''
          
      //     ],
      //     [

      //       'tbl_sys_paginations_arg_name'  => 'table',
      //       'tbl_sys_paginations_arg_value' => ''
          
      //     ],
      //     [

      //       'tbl_sys_paginations_arg_name'  => 'index',
      //       'tbl_sys_paginations_arg_value' => ''
          
      //     ],
      //     [

      //       'tbl_sys_paginations_arg_name'  => 'per_page',
      //       'tbl_sys_paginations_arg_value' => 15
          
      //     ],
      //     [

      //       'tbl_sys_paginations_arg_name'  => 'actions',
      //       'tbl_sys_paginations_arg_value' => json_encode([
      //       ])
          
      //     ],
      //     [

      //       'tbl_sys_paginations_arg_name'  => 'header_actions',
      //       'tbl_sys_paginations_arg_value' => json_encode([
      //       ])
          
      //     ],
      //     [

      //       'tbl_sys_paginations_arg_name'  => 'list_actions',
      //       'tbl_sys_paginations_arg_value' => json_encode([
      //       ])
          
      //     ],

      //   ],
      //   'pagination_cols'           => [

      //     [

      //       'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
      //       'tbl_sys_paginations_col_name'   => '',
      //       'tbl_sys_paginations_col_title'  => '',
      //       'tbl_sys_paginations_col_header' => '',
      //       'tbl_sys_paginations_col_body'   => '',
      //       'tbl_sys_paginations_col_props'  => '',
      //       'tbl_sys_paginations_col_attrs'  => '',
      //       'tbl_sys_paginations_col_search' => '',
      //       'tbl_sys_paginations_col_sort'   => '',

      //     ],
      //     [
            
      //       'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('hidden', 'tbl_sys_field_type_ID'),
      //       'tbl_sys_paginations_col_name'   => '',
      //       'tbl_sys_paginations_col_title'  => '',
      //       'tbl_sys_paginations_col_header' => '',
      //       'tbl_sys_paginations_col_body'   => '',
      //       'tbl_sys_paginations_col_props'  => '',
      //       'tbl_sys_paginations_col_attrs'  => '',
      //       'tbl_sys_paginations_col_search' => '',
      //       'tbl_sys_paginations_col_sort'   => '',

      //     ]

      //   ],

      // ],


      $paginations = [
        

        // NAVS - START

          [

            'tbl_sys_pagination_name'   => 'admin-navs-pagination',
            'tbl_sys_pagination_route'  => 'admin-navs',
            'tbl_sys_pagination_title'  => 'Paginação posições de menus de navegação.',
            'tbl_sys_pagination_table'  => 'tbl_sys_navs',
            'tbl_sys_pagination_index'  => 'tbl_sys_nav_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-navs-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-navs-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-navs-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-navs-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_nav_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-nav',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Nova Área de navegação',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Nova Área de navegação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-navs') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Área de navegação',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Área de navegação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-navs') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Área de navegação',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_nav_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_nav_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_nav_title',
                'tbl_sys_paginations_col_title'  => 'Titulo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_nav_ID',
                'tbl_sys_paginations_col_title'  => 'Menu',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => json_encode([

                  'type'     => 'single',
                  'mode'     => 'revert',
                  'table'    => 'tbl_sys_menus',
                  'column'   => 'tbl_sys_nav_ID',
                  'display'  => 'tbl_sys_menu_title',
                  'nullable' => true,
                  'empty'    => '- - -'
                  
                ]),
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],

            ],

          ],

        // NAVS - END


        // API'S - START

          [

            'tbl_sys_pagination_name'   => 'admin-apis-pagination',
            'tbl_sys_pagination_route'  => 'admin-apis',
            'tbl_sys_pagination_title'  => 'Paginação de Rotas de API do sistema',
            'tbl_sys_pagination_table'  => 'tbl_sys_routes',
            'tbl_sys_pagination_index'  => 'tbl_sys_route_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'where',
                'tbl_sys_paginations_arg_value' => json_encode([
                  
                  [

                    'tbl_sys_route_api',
                    '>=',
                    1

                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'access' => [

                    'route'  => 'admin-api-routes-apis-access',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'accessEdit' => [

                    'route'  => 'admin-api-routes-apis-access-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'get' => [

                    'route'  => 'admin-api-routes-apis-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-routes-apis-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-routes-apis-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-routes-apis-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_route_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-route-apis',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Nova API',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Nova API') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-apis') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-routes-apis',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar API',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar API') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-apis') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'access',
                    'id'      => 'btn-access',
                    'class'   => 'btn-warning text-white',
                    'icon'    => 'lock',
                    'text'    => 'Permissões da Rota de API',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Permissões da API') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-apis-access') . ", 'access', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'accessEdit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-routes-apis',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Página',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_title',
                'tbl_sys_paginations_col_title'  => 'Titulo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_status',
                'tbl_sys_paginations_col_title'  => 'Status',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'ativo'   => '<span class="badge text-bg-success">Ativo</span>',
                    'inativo' => '<span class="badge text-bg-danger">Inativo</span>'
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ]

            ],

          ],

        // API'S - END


        // PAGES - START

          [

            'tbl_sys_pagination_name'   => 'admin-routes-pagination',
            'tbl_sys_pagination_route'  => 'admin-routes',
            'tbl_sys_pagination_title'  => 'Paginação de Rotas/Páginas do sistema',
            'tbl_sys_pagination_table'  => 'tbl_sys_routes',
            'tbl_sys_pagination_index'  => 'tbl_sys_route_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'where',
                'tbl_sys_paginations_arg_value' => json_encode([
                  
                  [
                    'tbl_sys_route_api',
                    '<=',
                    0
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'access' => [

                    'route'  => 'admin-api-routes-access',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'accessEdit' => [

                    'route'  => 'admin-api-routes-access-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'get' => [

                    'route'  => 'admin-api-routes-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-routes-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-routes-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-routes-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_route_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-route',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Nova Página',
                      'onclick' => "AutomatorCreateViewModal({ view: 'system-page-editor' }, { size: 'fullscreen', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData){ SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData ){ SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData); }});",
                      // 'onclick' => "AutomatorCreateViewModal({ view: 'system-page-editor' }, { size: 'fullscreen', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData){ SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData ){ SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorEditor.destroy(); }});",
                      // 'onclick' => "AutomatorCreateViewModal({ view: 'system-page-editor'}, { size: 'fullscreen', backdrop: true, keyboard: false, callback: function(response, modalEl, modal, recordData) { SysAutomatorEditor.init({ isNew: true }); } });",
                      // 'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Nova Página') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Página',
                    'onclick' => "AutomatorCreateViewModal({ view: 'system-page-editor', pageID: '{id}' }, { size: 'fullscreen', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData){ SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData ){ SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorEditor.destroy(); }});",
                    // 'onclick' => "AutomatorCreateViewModal({ view: 'system-page-editor', pageID: '{id}'}, { size: 'fullscreen', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData) { SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData) { SysAutomatorInitPageEditor(response, modalEl, modal, recordData); } });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Página') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'access',
                    'id'      => 'btn-access',
                    'class'   => 'btn-warning text-white',
                    'icon'    => 'lock',
                    'text'    => 'Permissões da Página',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Permissões da Página') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-access') . ", 'access', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'accessEdit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Página',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_title',
                'tbl_sys_paginations_col_title'  => 'Titulo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_status',
                'tbl_sys_paginations_col_title'  => 'Status',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'ativo'   => '<span class="badge text-bg-success">Ativo</span>',
                    'inativo' => '<span class="badge text-bg-danger">Inativo</span>'
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ]

            ],

          ],

        // PAGES - END



        // USERS TYPES - START

          [

            'tbl_sys_pagination_name'   => 'admin-users-types-pagination',
            'tbl_sys_pagination_route'  => 'admin-users-types',
            'tbl_sys_pagination_title'  => 'Paginação tipos de usuários',
            'tbl_sys_pagination_table'  => 'tbl_users_types',
            'tbl_sys_pagination_index'  => 'tbl_users_type_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'access' => [

                    'route'  => 'admin-api-users-types-access',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'accessEdit' => [

                    'route'  => 'admin-api-users-types-access-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'get' => [

                    'route'  => 'admin-api-users-types-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-users-types-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-users-types-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-users-types-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_users_type_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-user-type',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Novo Tipo de usuário',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",
                      // 'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Tipo de usuário',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'access',
                    'id'      => 'btn-access',
                    'class'   => 'btn-warning text-white',
                    'icon'    => 'lock',
                    'text'    => 'Permissões do Tipo de usuário',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Permissões do Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types-access') . ", 'access', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'accessEdit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Tipo de usuário',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_users_type_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_users_type_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_users_type_status',
                'tbl_sys_paginations_col_title'  => 'Status',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'ativo'   => '<span class="badge text-bg-success">Ativo</span>',
                    'inativo' => '<span class="badge text-bg-danger">Inativo</span>'
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ]

            ],

          ],

        // USERS TYPES - END



        // USERS - START

          [

            'tbl_sys_pagination_name'   => 'admin-users-pagination',
            'tbl_sys_pagination_route'  => 'admin-users',
            'tbl_sys_pagination_title'  => 'Paginação de usuários',
            'tbl_sys_pagination_table'  => 'tbl_users',
            'tbl_sys_pagination_index'  => 'tbl_user_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-users-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-users-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-users-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-users-delete',
                    'params' => [],
                    'show'   => false,
                    // 'roles'  => [

                    //   [

                    //     'key'     => 'tbl_users_type_locked',
                    //     'compare' => '==',
                    //     'value'   => false
                      
                    //   ]

                    // ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-user',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Novo Usuário',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Usuário',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Usuário',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_user_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_user_login',
                'tbl_sys_paginations_col_title'  => 'Usuário',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_user_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_user_status',
                'tbl_sys_paginations_col_title'  => 'Status',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'ativo'   => '<span class="badge text-bg-success">Ativo</span>',
                    'inativo' => '<span class="badge text-bg-danger">Inativo</span>'
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ]

            ],

          ],

        // USERS - END



        // FIELDS - START

          [

            'tbl_sys_pagination_name'   => 'admin-fields-pagination',
            'tbl_sys_pagination_route'  => 'admin-fields',
            'tbl_sys_pagination_title'  => 'Paginação de tipos de campos',
            'tbl_sys_pagination_table'  => 'tbl_sys_field_types',
            'tbl_sys_pagination_index'  => 'tbl_sys_field_type_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-fields-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-fields-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-fields-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-fields-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_field_type_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-field-type',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Novo Tipo de campo',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de campo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-fields') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Tipo de campo',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de campo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-fields') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Tipo de campo',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_field_type_ID',
                'tbl_sys_paginations_col_title'  => 'ID',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_field_type_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_field_type_title',
                'tbl_sys_paginations_col_title'  => 'Titulo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1]

              ],

            ],

          ],

        // FIELDS - END



        // MÓDULOS - START

          [

            'tbl_sys_pagination_name'   => 'admin-modulos-pagination',
            'tbl_sys_pagination_route'  => 'admin-modulos',
            'tbl_sys_pagination_title'  => 'Paginação de módulos',
            'tbl_sys_pagination_table'  => 'tbl_sys_modulos',
            'tbl_sys_pagination_index'  => 'tbl_sys_modulo_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-modulos-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-modulos-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-modulos-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-modulos-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_modulo_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-modulo',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Adicionar Módulo',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Adicionar Módulo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-modulos') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Módulo',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Módulo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-modulos') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Módulo',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_modulo_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_modulo_title',
                'tbl_sys_paginations_col_title'  => 'Titulo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_modulo_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_modulo_status',
                'tbl_sys_paginations_col_title'  => 'Status',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    'ativo'   => '<span class="badge text-bg-success">Ativo</span>',
                    'inativo' => '<span class="badge text-bg-danger">Inativo</span>'
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ]

            ],

          ],

        // MÓDULOS - END



        // FORMS - START

          [

            'tbl_sys_pagination_name'   => 'admin-forms-pagination',
            'tbl_sys_pagination_route'  => 'admin-forms',
            'tbl_sys_pagination_title'  => 'Paginação de formulários',
            'tbl_sys_pagination_table'  => 'tbl_sys_forms',
            'tbl_sys_pagination_index'  => 'tbl_sys_form_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'access' => [

                    'route'  => 'admin-api-forms-access',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'accessEdit' => [

                    'route'  => 'admin-api-forms-access-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'get' => [

                    'route'  => 'admin-api-forms-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-forms-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-forms-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-forms-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_form_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-form',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Novo Formulário',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Formulário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-forms') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Formulário',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Formulário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-forms') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Formulário',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_form_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_form_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_form_title',
                'tbl_sys_paginations_col_title'  => 'Titulo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1, 2]

              ],

            ],

          ],

        // FORMS - END



        // PAGINATIONS - START

          [

            'tbl_sys_pagination_name'   => 'admin-paginations-pagination',
            'tbl_sys_pagination_route'  => 'admin-paginations',
            'tbl_sys_pagination_title'  => 'Paginações',
            'tbl_sys_pagination_table'  => 'tbl_sys_paginations',
            'tbl_sys_pagination_index'  => 'tbl_sys_pagination_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-paginations-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-paginations-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-paginations-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-paginations-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_pagination_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-user-type',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Nova Paginação',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen', '" . SysAutomator::SysAutomatorGetTranslateWord('Nova Paginação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-paginations') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Paginação',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Paginação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-paginations') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => 'Excluir Paginação',
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_pagination_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_pagination_name',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_pagination_title',
                'tbl_sys_paginations_col_title'  => 'Titulo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              // [
                
              //   'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
              //   'tbl_sys_paginations_col_name'   => 'tbl_sys_pagination_status',
              //   'tbl_sys_paginations_col_title'  => 'Status',
              //   'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
              //   'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
              //   'tbl_sys_paginations_col_props'  => '',
              //   'tbl_sys_paginations_col_attrs'  => json_encode([

              //     'replaced' => [

              //       'ativo'   => '<span class="badge text-bg-success">Ativo</span>',
              //       'inativo' => '<span class="badge text-bg-danger">Inativo</span>'
                  
              //     ]
                  
              //   ]),
              //   'tbl_sys_paginations_col_search' => false,
              //   'tbl_sys_paginations_col_sort'   => true,
              //   'cols_access'                    => [1, 2]

              // ]

            ],

          ],

        // PAGINATIONS - END



        // SHORTCODES - START

          [

            'tbl_sys_pagination_name'   => 'admin-shortcodes-pagination',
            'tbl_sys_pagination_route'  => 'admin-shortcodes',
            'tbl_sys_pagination_title'  => 'Shortcodes do sistema',
            'tbl_sys_pagination_table'  => 'tbl_sys_shortcodes',
            'tbl_sys_pagination_index'  => 'tbl_sys_shortcode_ID',
            'tbl_sys_pagination_locked' => true,
            'pagination_args'           => [
              
              [

                'tbl_sys_paginations_arg_name'  => 'page_name',
                'tbl_sys_paginations_arg_value' => '@replace($route["tbl_sys_route_name"])'
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'per_page',
                'tbl_sys_paginations_arg_value' => 15
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-shortcodes-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-shortcodes-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-shortcodes-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-shortcodes-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_shortcode_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-shortcode',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => 'Novo Shortcode',
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Novo Shortcode') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-shortcodes') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => 'Editar Shortcode',
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-md', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Shortcode') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-shortcodes') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",
                    // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  ],
                  // [

                  //   'type'    => 'button',
                  //   'action'  => 'access',
                  //   'id'      => 'btn-access',
                  //   'class'   => 'btn-warning text-white',
                  //   'icon'    => 'lock',
                  //   'text'    => 'Permissões do Tipo de usuário',
                  //   'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Permissões do Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types-access') . ", 'access', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'accessEdit' }]); });",
                  //   // 'onclick' => "AutomatorPaginationCreateModalForm('" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id});",

                  // ],
                  // [

                  //   'type'    => 'button',
                  //   'action'  => 'delete',
                  //   'id'      => 'btn-delete',
                  //   'class'   => 'btn-danger',
                  //   'icon'    => 'trash',
                  //   'text'    => 'Excluir Tipo de usuário',
                  //   'onclick' => '',

                  // ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_shortcode_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_shortcode_code',
                'tbl_sys_paginations_col_title'  => 'Codigo',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_shortcode_title',
                'tbl_sys_paginations_col_title'  => 'Nome',
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],

            ],

          ],

        // SHORTCODES - END

      ];


      foreach ($paginations as $pagination) {

        $paginationArgs   = $pagination['pagination_args'];
        $paginationCols   = $pagination['pagination_cols'];

        unset($pagination['pagination_args']);
        unset($pagination['pagination_cols']);

        $paginacao = SysPagination::create($pagination);

        $paginationID = $paginacao->getKey();

        foreach ($paginationArgs as $paginationArg) {
          
          $paginationArg['tbl_sys_pagination_ID'] = $paginationID;
          SysPaginationsArg::Create($paginationArg);

        }


        $order = 1;

        foreach ($paginationCols as $paginationCol) {

          $col = $paginationCol;
          
          $colAccess = $col['cols_access'];

          unset($col['cols_access']);


          $col['tbl_sys_pagination_ID'] = $paginationID;
          $col['tbl_sys_paginations_col_ordem'] = $order;

          $paginacaoCol = SysPaginationsCol::create($col);

          $paginationColID = $paginacaoCol->getKey();

          foreach ($colAccess as $_colAccess) {
            
            SysPaginationsColsAccess::Create([
              'tbl_users_type_ID'          => $_colAccess,
              'tbl_sys_paginations_col_ID' => $paginationColID
            
            ]);

          }

          $order++;

        }

        // code...
      }
    

    }
  


  }
