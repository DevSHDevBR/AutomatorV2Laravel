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


      $paginations = [
        

        // NAVS - START

          [

            'tbl_sys_pagination_name'   => 'admin-navs-pagination',
            'tbl_sys_pagination_route'  => 'admin-navs',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação posições de menus de navegação.'),
            'tbl_sys_pagination_table'  => 'tbl_sys_navs',
            'tbl_sys_pagination_index'  => 'tbl_sys_nav_ID',
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
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova Área de navegação'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Nova Área de navegação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-navs') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-nav',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Área de navegação'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Área de navegação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-navs') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-nav',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Área de navegação'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Menu'),
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
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Rotas de API do sistema'),
            'tbl_sys_pagination_table'  => 'tbl_sys_routes',
            'tbl_sys_pagination_index'  => 'tbl_sys_route_ID',
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
                  
                  ],
                  'activate' => [

                    'route'  => 'admin-api-routes-apis-active',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_sys_route_status',
                        'compare' => '==',
                        'value'   => 'ativo'
                      
                      ],
                      
                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_route_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ],

                    ]
                  
                  ],
                  'desactivate' => [

                    'route'  => 'admin-api-routes-apis-desactive',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_sys_route_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],

                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_route_locked',
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
                      'id'      => 'btn-add-route-apis',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova API'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Nova API') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-apis') . ");",

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
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar API'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar API') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-apis') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'access',
                    'id'      => 'btn-access-routes-apis',
                    'class'   => 'btn-warning text-white',
                    'icon'    => 'lock',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Permissões da Rota de API'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Permissões da API') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-apis-access') . ", 'access', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'accessEdit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'activate',
                    'id'      => 'btn-activate-routes-apis',
                    'class'   => 'btn-success',
                    'icon'    => 'check',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Ativar Rota de API'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'desactivate',
                    'id'      => 'btn-desactivate-routes-apis',
                    'class'   => 'btn-secondary',
                    'icon'    => 'times',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Desativar Rota de API'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-routes-apis',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Rota de API'),
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_name',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_status',
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

        // API'S - END



        // PAGES - START

          [

            'tbl_sys_pagination_name'   => 'admin-routes-pagination',
            'tbl_sys_pagination_route'  => 'admin-routes',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Rotas/Páginas do sistema'),
            'tbl_sys_pagination_table'  => 'tbl_sys_routes',
            'tbl_sys_pagination_index'  => 'tbl_sys_route_ID',
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
                  
                  ],
                  'activate' => [

                    'route'  => 'admin-api-routes-active',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_sys_route_status',
                        'compare' => '==',
                        'value'   => 'ativo'
                      
                      ],
                      
                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_route_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ],

                    ]
                  
                  ],
                  'desactivate' => [

                    'route'  => 'admin-api-routes-desactive',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_sys_route_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],

                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_route_locked',
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
                      'id'      => 'btn-add-route',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova Página'),
                      'onclick' => "AutomatorCreateViewModal({ view: 'system-page-editor', editorAction: 'store' }, { editorAction: 'store', size: 'fullscreen', backdrop: true, keyboard: false, keepLoaderUntilCallback: true, beforeShow: function(response, modalEl, modal, recordData) { SysAutomatorConfigPageEditor(response, modalEl, modal, recordData, { method: 'POST', action: 'add' }); }, callback: function(response, modalEl, modal, recordData) { SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData); } });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-route',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Página'),
                    'onclick' => "AutomatorCreateViewModal({ view: 'system-page-editor', editorAction: 'update', pageID: '{id}' }, { acao: 'get', id: '{id}', pageID: '{id}', editorAction: 'update', size: 'fullscreen', backdrop: true, keyboard: false, keepLoaderUntilCallback: true, beforeShow: function(response, modalEl, modal, recordData) { SysAutomatorConfigPageEditor(response, modalEl, modal, recordData, { method: 'POST', action: 'edit', tbl_sys_route_ID: '{id}' }); }, callback: function(response, modalEl, modal, recordData) { SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData); } });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'access',
                    'id'      => 'btn-access-route',
                    'class'   => 'btn-warning text-white',
                    'icon'    => 'lock',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Permissões da Página'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-xl', '" . SysAutomator::SysAutomatorGetTranslateWord('Permissões da Página') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-routes-access') . ", 'access', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'accessEdit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'activate',
                    'id'      => 'btn-activate-route',
                    'class'   => 'btn-success',
                    'icon'    => 'check',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Ativar Página'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'desactivate',
                    'id'      => 'btn-desactivate-route',
                    'class'   => 'btn-secondary',
                    'icon'    => 'times',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Desativar Página'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-route',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Página'),
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_name',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_route_status',
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

        // PAGES - END



        // USERS TYPES - START

          [

            'tbl_sys_pagination_name'   => 'admin-users-types-pagination',
            'tbl_sys_pagination_route'  => 'admin-users-types',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Tipos de usuários'),
            'tbl_sys_pagination_table'  => 'tbl_users_types',
            'tbl_sys_pagination_index'  => 'tbl_users_type_ID',
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
                  
                  ],
                  'activate' => [

                    'route'  => 'admin-api-users-types-active',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_users_type_status',
                        'compare' => '==',
                        'value'   => 'ativo'
                      
                      ],
                      
                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_users_type_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ],

                    ]
                  
                  ],
                  'desactivate' => [

                    'route'  => 'admin-api-users-types-desactive',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_users_type_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],

                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_users_type_locked',
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
                      'id'      => 'btn-add-user-type',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de usuário'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-user-type',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'access',
                    'id'      => 'btn-access-user-type',
                    'class'   => 'btn-warning text-white',
                    'icon'    => 'lock',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Permissões do Tipo de usuário'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Permissões do Tipo de usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-types-access') . ", 'access', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'accessEdit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'activate',
                    'id'      => 'btn-activate-user-type',
                    'class'   => 'btn-success',
                    'icon'    => 'check',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Ativar Tipo de Usuário'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'desactivate',
                    'id'      => 'btn-desactivate-user-type',
                    'class'   => 'btn-secondary',
                    'icon'    => 'times',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Desativar Tipo de Usuário'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-user-type',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Tipo de usuário'),
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_users_type_status',
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

        // USERS TYPES - END



        // USERS - START

          [

            'tbl_sys_pagination_name'   => 'admin-users-pagination',
            'tbl_sys_pagination_route'  => 'admin-users',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de usuários'),
            'tbl_sys_pagination_table'  => 'tbl_users',
            'tbl_sys_pagination_index'  => 'tbl_user_ID',
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
                    'roles'  => [

                      [

                        'key'     => 'tbl_user_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ],
                  'activate' => [

                    'route'  => 'admin-api-users-active',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_users_status',
                        'compare' => '==',
                        'value'   => 'ativo'
                      
                      ],
                      
                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_users_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ],

                    ]
                  
                  ],
                  'desactivate' => [

                    'route'  => 'admin-api-users-desactive',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_users_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],

                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_users_locked',
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
                      'id'      => 'btn-add-user',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Usuário'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-user',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Usuário'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Usuário') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-users-edit') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'activate',
                    'id'      => 'btn-activate-user',
                    'class'   => 'btn-success',
                    'icon'    => 'check',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Ativar Usuário'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'desactivate',
                    'id'      => 'btn-desactivate-user',
                    'class'   => 'btn-secondary',
                    'icon'    => 'times',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Desativar Usuário'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-user',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Usuário'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Usuário'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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

        // USERS - END



        // NOTIFICATIONS - START

          [

            'tbl_sys_pagination_name'   => 'admin-notifications-pagination',
            'tbl_sys_pagination_route'  => 'admin-notifications',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de notificações do sistema de usuarios.'),
            'tbl_sys_pagination_table'  => 'tbl_sys_notifications',
            'tbl_sys_pagination_index'  => 'tbl_sys_notification_ID',
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

                    'route'  => 'admin-api-notifications-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-notifications-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-notifications-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-notifications-delete',
                    'params' => [],
                    'show'   => false
                  
                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-notification',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova Notificação'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Nova Notificação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-notifications') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-notification',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Notificação'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Notificação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-notifications') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-notification',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Notificação'),
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_notification_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('relation', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_user_ID',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Usuário'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => json_encode([

                  'type'     => 'single',
                  'mode'     => 'revert',
                  'table'    => 'tbl_users',
                  'column'   => 'tbl_user_ID',
                  'display'  => 'tbl_user_name',
                  'nullable' => true,
                  'empty'    => '- - -'
                  
                ]),
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_notification_created_at',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Data de Envio'),
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

        // NOTIFICATIONS - END



        // FIELDS - START

          [

            'tbl_sys_pagination_name'   => 'admin-fields-pagination',
            'tbl_sys_pagination_route'  => 'admin-fields',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Tipos de campos'),
            'tbl_sys_pagination_table'  => 'tbl_sys_field_types',
            'tbl_sys_pagination_index'  => 'tbl_sys_field_type_ID',
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
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de campo'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de campo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-fields') . ");",

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
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de campo'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de campo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-fields') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Tipo de campo'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
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
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Módulos'),
            'tbl_sys_pagination_table'  => 'tbl_sys_modulos',
            'tbl_sys_pagination_index'  => 'tbl_sys_modulo_ID',
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

                      'relation' => 'AND',
                      [

                        'key'     => 'tbl_sys_modulo_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],
                      [

                        'key'     => 'tbl_sys_modulo_locked',
                        'compare' => '==',
                        'value'   => false
                      
                      ]

                    ]
                  
                  ],
                  'activate' => [

                    'route'  => 'admin-api-modulos-active',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_sys_modulo_status',
                        'compare' => '==',
                        'value'   => 'ativo'
                      
                      ],
                      
                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_modulo_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],

                    ]
                  
                  ],
                  'desactivate' => [

                    'route'  => 'admin-api-modulos-desactive',
                    'params' => [],
                    'show'   => false,
                    'hidden' => [

                      [

                        'key'     => 'tbl_sys_modulo_status',
                        'compare' => '==',
                        'value'   => 'inativo'
                      
                      ],

                    ],
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_modulo_status',
                        'compare' => '==',
                        'value'   => 'ativo'
                      
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
                      'id'      => 'btn-add-modulo',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Adicionar Módulo'),
                      'onclick' => "AutomatorCreateViewModal({ view: 'system-install-modulos'}, { size: 'modal-fullscreen-md-down modal-lg', backdrop: true, keyboard: false, callback: function(response, modalEl) { AutomatorModuleInstallUploadInit(modalEl); } });",
                      // 'onclick' => "AutomatorPaginationCreateModalForm('modal-md','" . SysAutomator::SysAutomatorGetTranslateWord('Adicionar Módulo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-modulos') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-modulo',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Módulo'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Módulo') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-modulos') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'activate',
                    'id'      => 'btn-activate-modulo',
                    'class'   => 'btn-success',
                    'icon'    => 'check',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Ativar Módulo'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'desactivate',
                    'id'      => 'btn-desactivate-modulo',
                    'class'   => 'btn-secondary',
                    'icon'    => 'times',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Desativar Módulo'),

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-modulo',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Módulo'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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

        // MÓDULOS - END



        // FORMS - START

          [

            'tbl_sys_pagination_name'   => 'admin-forms-pagination',
            'tbl_sys_pagination_route'  => 'admin-forms',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Formulários'),
            'tbl_sys_pagination_table'  => 'tbl_sys_forms',
            'tbl_sys_pagination_index'  => 'tbl_sys_form_ID',
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
                    'params' => ['id' => "#ID#"],
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
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Formulário'),
                      'onclick' => "AutomatorCreateViewModal({ view: 'system-form-editor' }, { size: 'fullscreen', backdrop: true, keyboard: false, scrollable: false, keepLoaderUntilCallback: true, callback: function(response, modalEl, modal, recordData) { response.acao = 'store'; response.formID = null; response.form_id = null; response.tbl_sys_form_ID = null; SysAutomatorConfigFormEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyFormEditor(response, modalEl, modal, recordData); } });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-form',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Formulário'),
                    'onclick' => "AutomatorCreateViewModal({ view: 'system-form-editor', formID: '{id}' }, { size: 'fullscreen', backdrop: true, keyboard: false, scrollable: false, keepLoaderUntilCallback: true, callback: function(response, modalEl, modal, recordData) { response.acao = 'edit'; response.formID = '{id}'; SysAutomatorConfigFormEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyFormEditor(response, modalEl, modal, recordData); } });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-form',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Formulário'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
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
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Paginações do sistema'),
            'tbl_sys_pagination_table'  => 'tbl_sys_paginations',
            'tbl_sys_pagination_index'  => 'tbl_sys_pagination_ID',
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
                    'id'      => 'btn-add-pagination',
                    'class'   => 'btn btn-success',
                    'icon'    => 'plus',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova Paginação'),
                    'onclick' => "AutomatorCreateViewModal({ view: 'system-pagination-editor', editorAction: 'add' }, { editorAction: 'add', size: 'fullscreen', backdrop: true, keyboard: false, scrollable: false, keepLoaderUntilCallback: true, callback: function(response, modalEl, modal, recordData) { response.acao = 'add'; response.editorAction = 'add'; response.submitAction = 'add'; response.paginationID = null; response.pagination_id = null; response.tbl_sys_pagination_ID = null; response.pageID = null; SysAutomatorConfigPaginationEditor(response, modalEl, modal, {}); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPaginationEditor(response, modalEl, modal, recordData); } });",

                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-pagination',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Paginação'),
                    'onclick' => "AutomatorCreateViewModal({ view: 'system-pagination-editor', editorAction: 'edit', pageID: {id} }, { acao: 'get', id: {id}, pageID: {id}, editorAction: 'edit', size: 'fullscreen', backdrop: true, keyboard: false, scrollable: false, keepLoaderUntilCallback: true, callback: function(response, modalEl, modal, recordData) { response.acao = 'edit'; response.editorAction = 'edit'; response.submitAction = 'edit'; response.paginationID = {id}; response.pagination_id = {id}; response.tbl_sys_pagination_ID = {id}; response.pageID = {id}; SysAutomatorConfigPaginationEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPaginationEditor(response, modalEl, modal, recordData); } });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-pagination',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Paginação'),
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_pagination_title',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
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

        // PAGINATIONS - END



        // SHORTCODES - START

          [

            'tbl_sys_pagination_name'   => 'admin-shortcodes-pagination',
            'tbl_sys_pagination_route'  => 'admin-shortcodes',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Shortcodes do sistema'),
            'tbl_sys_pagination_table'  => 'tbl_sys_shortcodes',
            'tbl_sys_pagination_index'  => 'tbl_sys_shortcode_ID',
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
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Shortcode'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Novo Shortcode') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-shortcodes') . ");",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-shortcode',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Shortcode'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Shortcode') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-shortcodes') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-shortcode',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Shortcode'),
                    'onclick' => '',

                  ]

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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Codigo'),
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
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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



        // USER NOTIFICATIONS - START

          [

            'tbl_sys_pagination_name'   => 'admin-user-notifications-pagination',
            'tbl_sys_pagination_route'  => 'admin-notificacoes',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Notificações do usuario'),
            'tbl_sys_pagination_table'  => 'tbl_sys_notifications',
            'tbl_sys_pagination_index'  => 'tbl_sys_notification_ID',
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

                'tbl_sys_paginations_arg_name'  => 'where',
                'tbl_sys_paginations_arg_value' => json_encode([
                  
                  [

                    'tbl_user_ID',
                    '==',
                    "@SysFunctions('sysGetCurrentUserData', ['data' => 'tbl_user_ID'])"

                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  'get' => [

                    'route'  => 'admin-api-notificacoes-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-notificacoes-update',
                    'params' => [],
                    'show'   => true,

                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-view-notification',
                    'class'   => 'btn-primary',
                    'icon'    => 'eye',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Visualizar Notificação'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Visualizar Notificação') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-user-notification') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_notification_ID',
                'tbl_sys_paginations_col_title'  => 'ID',
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2, 3, 4]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_notification_title',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Titulo'),
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2, 3, 4]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_notification_opened',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Status'),
                'tbl_sys_paginations_col_header' => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_body'   => json_encode(['class' => 'text-center']),
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => json_encode([

                  'replaced' => [

                    0 => '<span class="badge text-bg-danger">' . SysAutomator::SysAutomatorGetTranslateWord('Fechada') . '</span>',
                    1 => '<span class="badge text-bg-success">' . SysAutomator::SysAutomatorGetTranslateWord('Aberta') . '</span>',
                  
                  ]
                  
                ]),
                'tbl_sys_paginations_col_search' => false,
                'tbl_sys_paginations_col_sort'   => true,
                'cols_access'                    => [1, 2, 3, 4]

              ]

            ],

          ],

        // USER NOTIFICATIONS - END



        // MIDIA TYPES - START

          [

            'tbl_sys_pagination_name'   => 'admin-galeria-uploads-types-pagination',
            'tbl_sys_pagination_route'  => 'admin-galeria-uploads-types',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Tipos de midia'),
            'tbl_sys_pagination_table'  => 'tbl_sys_uploads_types',
            'tbl_sys_pagination_index'  => 'tbl_sys_uploads_type_ID',
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

                    'route'  => 'admin-api-galeria-uploads-types-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-galeria-uploads-types-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-galeria-uploads-types-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-galeria-uploads-types-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_uploads_type_locked',
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
                      'id'      => 'btn-add-galeria-upload-type',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de mídia'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Tipo de mídia') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-galeria-uploads-types') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-galeria-upload-type',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de mídia'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Tipo de mídia') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-galeria-uploads-types') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-galeria-upload-type',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Tipo de mídia'),
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_uploads_type_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('slug', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_uploads_type_name',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Type'),
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
                'tbl_sys_paginations_col_name'   => 'tbl_sys_uploads_type_title',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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

        // MIDIA TYPES - END



        // LANGUAGUES - START

          [

            'tbl_sys_pagination_name'   => 'admin-languages-pagination',
            'tbl_sys_pagination_route'  => 'admin-languages',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Idiomas'),
            'tbl_sys_pagination_table'  => 'tbl_sys_translations',
            'tbl_sys_pagination_index'  => 'tbl_sys_translation_ID',
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

                    'route'  => 'admin-api-languages-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-languages-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-languages-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-languages-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_translation_locked',
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
                      'id'      => 'btn-add-language',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Novo Idioma'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Novo Idioma') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-languages') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-language',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Idioma'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Idioma') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-languages') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-language',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir Idioma'),
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_translation_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('slug', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_translation_key',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Key'),
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
                'tbl_sys_paginations_col_name'   => 'tbl_sys_translation_name',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
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

        // LANGUAGUES - END



        // FUNCTIONS - START

          [

            'tbl_sys_pagination_name'   => 'admin-functions-pagination',
            'tbl_sys_pagination_route'  => 'admin-functions',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Funções'),
            'tbl_sys_pagination_table'  => 'tbl_sys_functions',
            'tbl_sys_pagination_index'  => 'tbl_sys_function_ID',
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

                    'route'  => 'admin-api-functions-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-functions-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-functions-update',
                    'params' => [],
                    'show'   => true,

                  ]

                ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'header_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                    [

                      'type'    => 'button',
                      'action'  => 'add',
                      'id'      => 'btn-add-function',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova Função'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Nova Função') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-functions') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-function',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar Função'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar Função') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-functions') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],

                ])
              
              ],

            ],
            'pagination_cols' => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_function_ID',
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
                'tbl_sys_paginations_col_name'   => 'tbl_sys_function_type',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Tipo'),
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
                'tbl_sys_paginations_col_name'   => 'tbl_sys_function_name',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Nome'),
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1]

              ],
              [
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_function_fn',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Função'),
                'tbl_sys_paginations_col_header' => '',
                'tbl_sys_paginations_col_body'   => '',
                'tbl_sys_paginations_col_props'  => '',
                'tbl_sys_paginations_col_attrs'  => '',
                'tbl_sys_paginations_col_search' => true,
                'tbl_sys_paginations_col_sort'   => false,
                'cols_access'                    => [1]

              ],

            ],

          ],

        // FUNCTIONS - END



        // VIEWS - START

          [

            'tbl_sys_pagination_name'   => 'admin-views-pagination',
            'tbl_sys_pagination_route'  => 'admin-views',
            'tbl_sys_pagination_title'  => SysAutomator::SysAutomatorGetTranslateWord('Paginação de Views'),
            'tbl_sys_pagination_table'  => 'tbl_sys_views',
            'tbl_sys_pagination_index'  => 'tbl_sys_view_ID',
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

                    'route'  => 'admin-api-views-get',
                    'params' => ['id' => "#ID#"],
                    'show'   => true,

                  ],
                  'add' => [

                    'route'  => 'admin-api-views-store',
                    'params' => [],
                    'show'   => true,

                  ],
                  'edit' => [

                    'route'  => 'admin-api-views-update',
                    'params' => [],
                    'show'   => true,

                  ],
                  'delete' => [

                    'route'  => 'admin-api-views-delete',
                    'params' => [],
                    'show'   => false,
                    'roles'  => [

                      [

                        'key'     => 'tbl_sys_view_locked',
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
                      'id'      => 'btn-add-view',
                      'class'   => 'btn btn-success',
                      'icon'    => 'plus',
                      'text'    => SysAutomator::SysAutomatorGetTranslateWord('Nova View'),
                      'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg','" . SysAutomator::SysAutomatorGetTranslateWord('Nova View') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-views') . ", '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });",

                    ]

                  ])
              
              ],
              [

                'tbl_sys_paginations_arg_name'  => 'list_actions',
                'tbl_sys_paginations_arg_value' => json_encode([

                  [

                    'type'    => 'button',
                    'action'  => 'edit',
                    'id'      => 'btn-edit-view',
                    'class'   => 'btn-primary',
                    'icon'    => 'pencil',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Editar View'),
                    'onclick' => "AutomatorPaginationCreateModalForm('modal-fullscreen-md-down modal-lg', '" . SysAutomator::SysAutomatorGetTranslateWord('Editar View') . "', " . SysAutomator::SysAutomatorGetFormIDByName('admin-views') . ", 'get', {id}, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'edit' }]); });",

                  ],
                  [

                    'type'    => 'button',
                    'action'  => 'delete',
                    'id'      => 'btn-delete-view',
                    'class'   => 'btn-danger',
                    'icon'    => 'trash',
                    'text'    => SysAutomator::SysAutomatorGetTranslateWord('Excluir View'),
                    'onclick' => '',

                  ]

                ])
              
              ],

            ],
            'pagination_cols'           => [

              [

                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('number', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_view_ID',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('slug', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_view_name',
                'tbl_sys_paginations_col_title'  => SysAutomator::SysAutomatorGetTranslateWord('Type'),
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
                'tbl_sys_paginations_col_name'   => 'tbl_sys_view_title',
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
                
                'tbl_sys_field_type_ID'          => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
                'tbl_sys_paginations_col_name'   => 'tbl_sys_view_status',
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

        // VIEWS - END


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
