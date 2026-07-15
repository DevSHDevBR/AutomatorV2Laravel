@php
  

  $texts = $texts ?? [

    'add-column'       => SysAutomator::SysAutomatorGetTranslateWord('Adicionar coluna'),
    'actions'          => SysAutomator::SysAutomatorGetTranslateWord('Ações'),
    'buttons'          => SysAutomator::SysAutomatorGetTranslateWord('Botões'),
    'structure'        => SysAutomator::SysAutomatorGetTranslateWord('Estrutura'),
    'configs'          => SysAutomator::SysAutomatorGetTranslateWord('Configurações'),
    'proprieties'      => SysAutomator::SysAutomatorGetTranslateWord('Propriedades'),
    'select-column'    => SysAutomator::SysAutomatorGetTranslateWord('Selecione uma coluna para editar.'),
    'columns'          => SysAutomator::SysAutomatorGetTranslateWord('Colunas'),
    'column'           => SysAutomator::SysAutomatorGetTranslateWord('Coluna'),
    'no-columns-added' => SysAutomator::SysAutomatorGetTranslateWord('Nenhuma coluna adicionada.'),
    'save'             => SysAutomator::SysAutomatorGetTranslateWord('Salvar'),

  ];


  $header = $header ?? [

    'type' => 'form-input',

    'content' => [

      'type'      => 'text',
      'id'        => 'tbl_sys_pagination_title',
      'name'      => 'tbl_sys_pagination_title',
      'label'     => SysAutomator::SysAutomatorGetTranslateWord('Titulo da Paginação'),
      'required'  => true,
      'value'     => '',

    ]

  ];


  $fields = $fields ?? SysAutomator::SysAutomatorRenderPaginationBuilderFields();


  $actions = $actions ?? [

    'inserter'  => false,
    'structure' => true,
    'buttons'   => false,

  ];


  $configs = $configs ?? [

    'pagination-settings' => [

      'default'     => true,
      'disabled'    => false,
      'label'       => SysAutomator::SysAutomatorGetTranslateWord('Configurações'),
      'description' => SysAutomator::SysAutomatorGetTranslateWord('Configurações principais da paginação'),
      'fields'      => [

        'tbl_sys_pagination_name' => [

          'type'     => 'text',
          'name'     => 'tbl_sys_pagination_name',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Nome da paginação'),
          'value'    => '',
          'required' => true

        ],

        'pagintarionArgs-page_name' => [

          'type'     => 'text',
          'name'     => 'page_name',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Nome da página'),
          'value'    => '',
          'required' => true

        ],

        'tbl_sys_pagination_route' => [

          'type'      => 'select',
          'name'      => 'tbl_sys_pagination_route',
          'class'     => 'form-floating mb-3',
          'label'     => SysAutomator::SysAutomatorGetTranslateWord('Rota'),
          'value'     => "",
          'nullValue' => "- Selecione -",
          'required'  => true,
          'options'   => SysAutomator::SysAutomatorRenderPaginationRoutesList('web')

        ],

        'tbl_sys_pagination_table' => [

          'type'      => 'select',
          'name'      => 'tbl_sys_pagination_table',
          'class'     => 'form-floating mb-3',
          'label'     => SysAutomator::SysAutomatorGetTranslateWord('Tabela'),
          'value'     => "",
          'nullValue' => "- Selecione -",
          'disabled'  => false,
          'required'  => true,
          'options'   => []

        ],

        'tbl_sys_pagination_index' => [

          'type'      => 'select',
          'name'      => 'tbl_sys_pagination_index',
          'class'     => 'form-floating mb-3',
          'label'     => SysAutomator::SysAutomatorGetTranslateWord('Chave Primária'),
          'value'     => "",
          'nullValue' => "- Selecione a tabela -",
          'required'  => true,
          'disabled'  => true,
          'options'   => []

        ],

        'pagintarionArgs-per_page' => [

          'type'     => 'select',
          'name'     => 'per_page',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Itens por página'),
          'value'    => 15,
          'required' => true,
          'choices'  => [

            10  => '10',
            15  => '15',
            25  => '25',
            50  => '50',
            100 => '100',

          ]

        ],

        'tbl_sys_pagination_locked' => [

          'type'     => 'select',
          'name'     => 'tbl_sys_pagination_locked',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Bloqueado'),
          'value'    => 0,
          'required' => true,
          'options'  => [

            1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
            0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

          ]

        ],

      ]

    ],

    'pagination-actions' => [

      'default'      => false,
      'disabled'     => true,
      'disabledText' => SysAutomator::SysAutomatorGetTranslateWord("Para liberar esta 'aba' conclua a configuração!"),
      'label'        => SysAutomator::SysAutomatorGetTranslateWord('Ações'),
      'description'  => SysAutomator::SysAutomatorGetTranslateWord('Rotas de ações da paginação'),
      'fields'       => [

        'pagintarionArgs-actions' => [

          'type'     => 'dynamic-inserter',
          'name'     => 'actions',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Rotas da paginção'),
          'value'    => '',
          'routes'   => SysAutomator::SysAutomatorRenderPaginationRoutesList('api'),
          'required' => false

        ],

      ]

    ]

  ];

@endphp

<div
  id="automator-pagination-editor-modal"
  data-editor-context="pagination"
  data-editor-mode="{!! isset($pagination) && !empty($pagination) ? 'edit' : 'create' !!}"
  data-automator-pagination-changed="false"
>

  @include('system.components.system-automator-pagination-editor', [

    'texts'   => $texts,
    'actions' => $actions,
    'header'  => $header,
    'fields'  => $fields,
    'configs' => $configs

  ])

</div>