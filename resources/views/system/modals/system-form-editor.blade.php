@php
  

  $texts = $texts ?? [

    'add-block'       => SysAutomator::SysAutomatorGetTranslateWord('Adicionar campo'),
    'structure'       => SysAutomator::SysAutomatorGetTranslateWord('Estrutura'),
    'configs'         => SysAutomator::SysAutomatorGetTranslateWord('Configurações'),
    'resolutions'     => SysAutomator::SysAutomatorGetTranslateWord('Resoluções'),
    'select-block'    => SysAutomator::SysAutomatorGetTranslateWord('Selecione um campo para editar.'),
    'proprieties'     => SysAutomator::SysAutomatorGetTranslateWord('Propriedades'),
    'blocks'          => SysAutomator::SysAutomatorGetTranslateWord('Campos'),
    'block'           => SysAutomator::SysAutomatorGetTranslateWord('Campo'),
    'no-blocks-added' => SysAutomator::SysAutomatorGetTranslateWord('Nenhum campo adicionado.'),
    'computer'        => SysAutomator::SysAutomatorGetTranslateWord('Computador'),
    'large-tablet'    => SysAutomator::SysAutomatorGetTranslateWord('Large Tablet'),
    'tablet'          => SysAutomator::SysAutomatorGetTranslateWord('Tablet'),
    'cellphone'       => SysAutomator::SysAutomatorGetTranslateWord('Celular'),
    'save'            => SysAutomator::SysAutomatorGetTranslateWord('Salvar'),

  ];


  $header = $header ?? [

    'type' => 'form-input',

    'content' => [

      'type'      => 'text',
      'id'        => 'tbl_sys_form_title',
      'name'      => 'tbl_sys_form_title',
      'label'     => SysAutomator::SysAutomatorGetTranslateWord('Nome do formulário'),
      'required'  => true,
      'value'     => '',

      'have-slug' => [

        'enabled' => true,
        'field'   => '#tbl_sys_form_name',
        'label'   => SysAutomator::SysAutomatorGetTranslateWord('Gerar Nome')

      ]

    ]

  ];


  $fields = $fields ?? SysAutomator::SysAutomatorRenderFormBuilderFields();


  $configs = $configs ?? [

    'form-settings' => [

      'default'     => true,
      'label'       => SysAutomator::SysAutomatorGetTranslateWord('Formulário'),
      'description' => SysAutomator::SysAutomatorGetTranslateWord('Configurações Básicas do formulário'),

      'fields' => [

        'tbl_sys_form_name' => [

          'type'     => 'text',
          'name'     => 'tbl_sys_form_name',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Nome interno'),
          'value'    => '',
          'required' => true

        ],

        'tbl_sys_form_admin' => [

          'type'     => 'select',
          'name'     => 'tbl_sys_form_admin',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Formulário Protegido'),
          'value'    => 0,
          'required' => true,
          'choices'  => [

            1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
            0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

          ]

        ],

        'tbl_sys_form_method' => [

          'type'     => 'select',
          'name'     => 'tbl_sys_form_method',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Método'),
          'value'    => 'POST',
          'required' => true,
          'choices'  => [

            'POST' => 'POST',
            'GET'  => 'GET'

          ]

        ],

        'tbl_sys_form_modal' => [

          'type'     => 'select',
          'name'     => 'tbl_sys_form_modal',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Abrir em modal'),
          'value'    => 1,
          'required' => true,
          'choices'  => [

            1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
            0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

          ]

        ],

        'tbl_sys_form_submit' => [

          'type'     => 'text',
          'name'     => 'tbl_sys_form_submit',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Texto do botão salvar'),
          'value'    => SysAutomator::SysAutomatorGetTranslateWord('Salvar'),
          'required' => true

        ],

        'tbl_sys_form_cancel' => [

          'type'     => 'text',
          'name'     => 'tbl_sys_form_cancel',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Texto do botão cancelar'),
          'value'    => SysAutomator::SysAutomatorGetTranslateWord('Cancelar'),
          'required' => true

        ],

        'tbl_sys_form_route' => [

          'type'     => 'text',
          'name'     => 'tbl_sys_form_route',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Rota de envio'),
          'value'    => '',
          'required' => false

        ],

        'tbl_sys_form_validate' => [

          'type'     => 'select',
          'name'     => 'tbl_sys_form_validate',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Validar com senha'),
          'value'    => 0,
          'required' => true,
          'choices'  => [

            1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
            0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

          ]

        ],

        'tbl_sys_form_locked' => [

          'type'     => 'select',
          'name'     => 'tbl_sys_form_locked',
          'class'    => 'form-floating mb-3',
          'label'    => SysAutomator::SysAutomatorGetTranslateWord('Bloqueado'),
          'value'    => 0,
          'required' => true,
          'choices'  => [

            1 => SysAutomator::SysAutomatorGetTranslateWord('Sim'),
            0 => SysAutomator::SysAutomatorGetTranslateWord('Não')

          ]

        ]

      ]

    ]

  ];

@endphp

<div id="automator-editor-modal"
     data-editor-context="form"
     data-editor-mode="{!! isset($form) && !empty($form) ? 'edit' : 'create' !!}">

  @include('system.components.system-form-visual-editor', [

    'texts'  => $texts,
    'header' => $header,
    'fields' => $fields,
    'configs' => $configs

  ])

</div>