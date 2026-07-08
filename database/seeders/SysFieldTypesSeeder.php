<?php


  namespace Database\Seeders;

  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;

  use App\Models\SysFieldType;



  class SysFieldTypesSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {

      
      $campos = [



        // BASICO - START


          [

            'tbl_sys_field_type_group_ID'    => 1,
            'tbl_sys_field_type_name'        => 'text',
            'tbl_sys_field_type_class'       => 'AutomatorFieldText',
            'tbl_sys_field_type_icon'        => 'font',
            'tbl_sys_field_type_title'       => 'Texto',
            'tbl_sys_field_type_description' => 'Uma entrada de texto básica, útil para armazenar valores de texto únicos.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_configs'     => '',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params' => json_encode([

              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "text",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  'minlenght' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'maxlenght' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  "mask" => [

                    "label"       => "Máscara",
                    "type"        => "input[type='text']",
                    "nullable"    => "true",
                    "placeholder" => "",
                    "description" => "Mascara de caracteres permitidos.",
                    "default"     => "",

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ]),
          
          ],

          [

            'tbl_sys_field_type_group_ID'    => 1,
            'tbl_sys_field_type_name'        => 'textarea',
            'tbl_sys_field_type_class'       => 'AutomatorFieldTextArea',
            'tbl_sys_field_type_icon'        => 'paragraph',
            'tbl_sys_field_type_title'       => 'Área de texto',
            'tbl_sys_field_type_description' => 'Uma entrada de área de texto básica para armazenar parágrafos de texto.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_configs'     => '',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "textarea",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  'minlenght' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'maxlenght' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  "rows" => [

                    "label"       => "Linhas",
                    "type"        => "input[type='number']",
                    "nullable"    => "true",
                    "placeholder" => "8",
                    "description" => "Número de linhas do campo.",
                    "default"     => "4",

                  ]

                ]
                
              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]
              

            ])
          
          ],

          [

            'tbl_sys_field_type_group_ID'    => 1,
            'tbl_sys_field_type_name'        => 'number',
            'tbl_sys_field_type_class'       => 'AutomatorFieldNumber',
            'tbl_sys_field_type_icon'        => 'hashtag',
            'tbl_sys_field_type_title'       => 'Número',
            'tbl_sys_field_type_description' => 'Uma entrada limitada a valores numéricos.',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "input[type='number']",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  "type" => [

                    "label"       => "Tipo",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Tipo de valor numérico.",
                    "default"     => "int",
                    "values"      => [

                      "int"   => "Inteiro",
                      "float" => "Flutuante"

                    ]

                  ],
                  "escala" => [

                    "label"       => "Tamanho da escala",
                    "type"        => "input[type='number']",
                    "nullable"    => "true",
                    "placeholder" => "",
                    "description" => "Tamanho da escala.",
                    'required'    => "false",
                    "default"     => "",

                  ],
                  'min' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'max' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  "mask" => [

                    "label"       => "Máscara",
                    "type"        => "input[type='text']",
                    "nullable"    => "true",
                    "placeholder" => "",
                    "description" => "Mascara de caracteres permitidos.",
                    "default"     => "",

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 1,
            'tbl_sys_field_type_name'        => 'interval',
            'tbl_sys_field_type_class'       => 'AutomatorFieldInterval',
            'tbl_sys_field_type_icon'        => 'sliders-h',
            'tbl_sys_field_type_title'       => 'Invervalo',
            'tbl_sys_field_type_description' => 'Uma entrada para selecionar um valor numérico dentro de um intervalo especificado usando um elemento deslizante de intervalo.',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "input[type='number']",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  "escala" => [

                    "label"       => "Tamanho da escala",
                    "type"        => "input[type='number']",
                    "nullable"    => "true",
                    "placeholder" => "",
                    "description" => "Tamanho da escala.",
                    'required'    => "false",
                    "default"     => "",

                  ],
                  'min' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'max' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ]

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 1,
            'tbl_sys_field_type_name'        => 'email',
            'tbl_sys_field_type_class'       => 'AutomatorFieldEmail',
            'tbl_sys_field_type_icon'        => 'envelope-square',
            'tbl_sys_field_type_title'       => 'E-Mail',
            'tbl_sys_field_type_description' => 'Uma entrada de texto projetada especificamente para armazenar endereços de e-mail.',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params' => json_encode([

              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "email",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  'minlenght' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'maxlenght' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ]),

          ],

          [

            'tbl_sys_field_type_group_ID'    => 1,
            'tbl_sys_field_type_name'        => 'url',
            'tbl_sys_field_type_class'       => 'AutomatorFieldURL',
            'tbl_sys_field_type_icon'        => 'globe',
            'tbl_sys_field_type_title'       => 'URL',
            'tbl_sys_field_type_description' => 'Uma entrada de texto projetada especificamente para armazenar endereços da web.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_configs'     => '',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params' => json_encode([

              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "text",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  'minlenght' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'maxlenght' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ]

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ]),

          ],

          [

            'tbl_sys_field_type_group_ID'    => 1,
            'tbl_sys_field_type_name'        => 'password',
            'tbl_sys_field_type_class'       => 'AutomatorFieldPassword',
            'tbl_sys_field_type_icon'        => 'key',
            'tbl_sys_field_type_title'       => 'Senha',
            'tbl_sys_field_type_description' => 'Uma entrada para fornecer uma senha usando um campo mascarado.',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params' => json_encode([

              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ]

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  'minlenght' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'maxlenght' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  "hasButton" => [

                    "label"       => "Botão de visualização",
                    "type"        => "select",
                    "nullable"    => "false",
                    'required'    => "true",
                    "description" => "Exibir botão de visualização ao lado do campo.",
                    "default"     => "false",
                    "choices"      => [

                      "true"  => "Sim",
                      "false" => "Não"

                    ]

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],


        // BASICO - END



        // Conteudo - START

          [

            'tbl_sys_field_type_group_ID'    => 2,
            'tbl_sys_field_type_name'        => 'image',
            'tbl_sys_field_type_class'       => 'AutomatorFieldImage',
            'tbl_sys_field_type_icon'        => 'image',
            'tbl_sys_field_type_title'       => 'Imagem',
            'tbl_sys_field_type_description' => 'Usa o seletor de mídia nativo do WordPress para enviar ou escolher imagens.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$] src="[$image$]" class="[$class$]"',
                'sufix'     => ' />',
                'tag'       => 'img',
                'rendered'  => true,
                'editor'    => false,
                'has_child' => false,

              ],

              'block' => [

                'advanced' => [
                  
                  'label'  => 'Avançado',
                  'fields' => [

                    'class'  => [

                      'label'   => 'Classes Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ]

                  ]

                ]

              ],

              'toolbar' => [

                [

                  'type'    => 'button',
                  'class'   => 'btn btn-xs btn-light border',
                  'title'   => 'Galeria',
                  'onclick' => "SysAutomatorEditor.OpenGalery(this)",
                  'label'   => '<i class="fa fa-image"></i>'
                
                ],

              ]
              
            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ]

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  "type" => [

                    "label"       => "Tipo(s) de arquivo",
                    "type"        => "checkbox",
                    "required"    => "false",
                    "nullable"    => "true",
                    "description" => "Tipo de imagem permitida do campo.",
                    "default"     => "png",
                    "choices"     => [

                      "png"  => "PNG",
                      "gif"  => "GIF",
                      "psd"  => "PSD",
                      "jpg"  => "JPG",
                      "jpeg" => "JPEG"

                    ]

                  ],
                  "multiple" => [

                    "label"       => "Multiplo",
                    "type"        => "select",
                    "nullable"    => "false",
                    "description" => "Permitir selecionar varios arquivos para upload.",
                    "required"    => "true",
                    "default"     => "false",
                    "choices"      => [

                      "true"  => "Sim",
                      "false" => "Não",

                    ]

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 2,
            'tbl_sys_field_type_name'        => 'link',
            'tbl_sys_field_type_class'       => 'AutomatorFieldLink',
            'tbl_sys_field_type_icon'        => 'link',
            'tbl_sys_field_type_title'       => 'Link',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar links.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$]>',
                'sufix'     => '</[$tag$]>',
                'has_child' => false,
                'editor'    => true,
                'tag'       => 'a',
              
              ],

              'block' => [

                'configs'  => [

                  'label'   => 'Configurações',
                  'fields'  => [
                    
                    'href' => [
                      
                      'label'   => 'URL do link',
                      'field'   => 'text',
                      'default' => ''

                    ],
                    'target' => [
                      
                      'label'   => 'Target do link',
                      'field'   => 'select',
                      'default' => '_self',
                      'choices' => [

                        '_self'   => '_self',
                        '_blank'  => '_blank',
                        '_parent' => '_parent',
                        '_top'    => '_top',

                      ]

                    ],

                  ],

                ],
                'colors' => [

                  'label'  => "Cores",
                  'fields' => [

                    'background' => [

                      'label'   => 'Cor de fundo',
                      'field'   => 'color-picker',
                      'default' => 'none',

                    ],

                    'color' => [

                      'label'   => 'Cor do texto',
                      'field'   => 'color-picker',
                      'default' => '#000000',

                    ],

                  ]

                ],

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do link',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                    'onclick'  => [

                      'label'   => 'ON CLICK',
                      'field'   => 'text',
                      'default' => ''

                    ],

                  ]

                ]

              ],

              'toolbar' => []

            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 2,
            'tbl_sys_field_type_name'        => 'button',
            'tbl_sys_field_type_class'       => 'AutomatorFieldButton',
            'tbl_sys_field_type_icon'        => 'square-check',
            'tbl_sys_field_type_title'       => 'Botão',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar um botão.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$]>',
                'sufix'     => '</[$tag$]>',
                'has_child' => false,
                'editor'    => true,
                'tag'       => 'button',
              
              ],

              'block' => [

                'configs'  => [

                  'label'   => 'Configurações',
                  'fields'  => [
                    
                    'type' => [
                      
                      'label'   => 'Tipo',
                      'field'   => 'select',
                      'default' => 'button',
                      'choices' => [

                        'button' => 'Botão',
                        'submit' => 'Submit',
                        'reset'  => 'Reset',

                      ]

                    ],

                  ],

                ],
                'colors' => [

                  'label'  => "Cores",
                  'fields' => [

                    'background' => [

                      'label'   => 'Cor de fundo',
                      'field'   => 'color-picker',
                      'default' => 'none',

                    ],

                    'color' => [

                      'label'   => 'Cor do texto',
                      'field'   => 'color-picker',
                      'default' => '#000000',

                    ],

                  ]

                ],

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do botão',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                    'onclick'  => [

                      'label'   => 'ON CLICK',
                      'field'   => 'text',
                      'default' => ''

                    ],

                  ]

                ]

              ],

              'toolbar' => []

            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 2,
            'tbl_sys_field_type_name'        => 'title',
            'tbl_sys_field_type_class'       => 'AutomatorFieldTitle',
            'tbl_sys_field_type_icon'        => 'heading',
            'tbl_sys_field_type_title'       => 'Titulo',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar um titulo.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'default'   => 'h1',
                'prefix'    => '<[$tag$]>',
                'sufix'     => '</[$tag$]>',
                'has_child' => false,
                'editor'    => true,
                'tag'       => [

                  'h1',
                  'h2',
                  'h3',
                  'h4',
                  'h5',
                  'h6',

                ],
              
              ],

              'block' => [

                'tipograph' => [

                  'label'  => 'Tipografia',
                  'fields' => [

                    'type' => [

                      'label'   => 'Tipo do titulo',
                      'field'   => 'radio-buttons',
                      'default' => 'h1',
                      'choices' => [

                        'h1' => 'H1',
                        'h2' => 'H2',
                        'h3' => 'H3',
                        'h4' => 'H4',
                        'h5' => 'H5',
                        'h6' => 'H6',

                      ]

                    ],

                    'size' => [

                      'label'   => 'Tamanho da fonte',
                      'field'   => 'radio-buttons',
                      'default' => 'medium',
                      'custom'  => true,
                      'choices' => [

                        'small'       => 'P',
                        'medium'      => 'M',
                        'large'       => 'G',
                        'extra-large' => 'GG',

                      ]

                    ],

                  ]

                ],

                'colors' => [

                  'label'  => "Cores",
                  'fields' => [

                    'background' => [

                      'label'   => 'Cor de fundo',
                      'field'   => 'color-picker',
                      'default' => 'none',

                    ],

                    'color' => [

                      'label'   => 'Cor do texto',
                      'field'   => 'color-picker',
                      'default' => '#000000',

                    ],

                  ]

                ],

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do Título',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ],

              'toolbar' => []

            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 2,
            'tbl_sys_field_type_name'        => 'paragraph',
            'tbl_sys_field_type_class'       => 'AutomatorFieldParagraph',
            'tbl_sys_field_type_icon'        => 'font',
            'tbl_sys_field_type_title'       => 'Paragrafo',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar um paragrafo.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$]>',
                'sufix'     => '</[$tag$]>',
                'tag'       => 'p',
                'editor'    => true,
                'has_child' => false
              
              ],

              'block' => [

                'tipograph' => [

                  'label'  => 'Tipografia',
                  'fields' => [

                    'size' => [

                      'label'   => 'Tamanho da fonte',
                      'field'   => 'radio-buttons',
                      'default' => 'medium',
                      'custom'  => true,
                      'choices' => [

                        'small'       => 'P',
                        'medium'      => 'M',
                        'large'       => 'G',
                        'extra-large' => 'GG',

                      ]

                    ],

                  ]

                ],

                'colors' => [

                  'label'  => "Cores",
                  'fields' => [

                    'background' => [

                      'label'   => 'Cor de fundo',
                      'field'   => 'color-picker',
                      'default' => 'none',

                    ],

                    'color' => [

                      'label'   => 'Cor do texto',
                      'field'    => 'color-picker',
                      'default' => '#000000',

                    ],

                  ]

                ],

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do Paragrafo',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ],

              'toolbar' => [
                
                [

                  'type'    => 'button',
                  'class'   => 'btn btn-xs btn-light border',
                  'title'   => 'Negrito',
                  'onclick' => "SysAutomatorEditor.formatButton(this, 'bold')",
                  'label'   => '<i class="fa fa-bold"></i>'
                
                ],
                [

                  'type'    => 'button',
                  'class'   => 'btn btn-xs btn-light border',
                  'title'   => 'Italico',
                  'onclick' => "SysAutomatorEditor.formatButton(this, 'italic')",
                  'label'   => '<i class="fa fa-italic"></i>'
                
                ],


              ],

            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 2,
            'tbl_sys_field_type_name'        => 'file',
            'tbl_sys_field_type_class'       => 'AutomatorFieldFile',
            'tbl_sys_field_type_icon'        => 'file',
            'tbl_sys_field_type_title'       => 'Arquivo',
            'tbl_sys_field_type_description' => 'Usa o seletor de mídia nativo do WordPress para enviar ou escolher arquivos.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_configs'     => '',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ]

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  "type" => [

                    "label"       => "Tipo(s) de arquivo",
                    "type"        => "dynamic-list",
                    "nullable"    => "true",
                    "required"    => "false",
                    "placeholder" => "",
                    "description" => "Tipos de arquivos que podem ser enviados.",
                    "default"     => "",

                  ],
                  "multiple" => [

                    "label"       => "Multiplo",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Permitir selecionar varios arquivos para upload.",
                    "default"     => "false",
                    "choices"      => [

                      "true"  => "Sim",
                      "false" => "Não",

                    ]

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 2,
            'tbl_sys_field_type_name'        => 'editor',
            'tbl_sys_field_type_class'       => 'AutomatorFieldEditor',
            'tbl_sys_field_type_icon'        => 'pencil',
            'tbl_sys_field_type_title'       => 'Editor',
            'tbl_sys_field_type_description' => 'Exibe o editor Visual WYSIWYG como visto em areas de conteudo, permitindo uma rica experiência de edição de texto que também permite conteúdo multimídia.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_configs'     => '',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([

              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "text",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])
          
          ],

        // Conteudo - END



        // Seleção - START

          [

            'tbl_sys_field_type_group_ID'    => 3,
            'tbl_sys_field_type_name'        => 'select',
            'tbl_sys_field_type_class'       => 'AutomatorFieldSelect',
            'tbl_sys_field_type_icon'        => 'object-group',
            'tbl_sys_field_type_title'       => 'Seleção',
            'tbl_sys_field_type_description' => 'Uma lista suspensa com uma seleção de escolhas que você especifica.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ]

                ]

              ],
              "choices" => [

                "label"       => "Escolhas",
                "fields" => [

                  "hasNull" => [

                    "label"       => "Tem vazio?",
                    "type"        => "select",
                    "nullable"    => "false",
                    "required"    => "true",
                    "description" => "",
                    "default"     => "false",
                    "choices"     => [
                      "false" => "Não",
                      "true"  => "Sim",
                    ]

                  ],
                  "nullText" => [

                    'label'    => 'Valor vazio',
                    'field'    => 'text',
                    "nullable" => "true",
                    "required" => "false",
                    'class'    => 'disabled',
                    'default'  => ''

                  ],
                  "option" => [

                    "label"       => "Opções",
                    "type"        => "dynamic-list",
                    "nullable"    => "true",
                    "placeholder" => "",
                    "description" => "",
                    "default"     => [],

                  ]

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 3,
            'tbl_sys_field_type_name'        => 'checkbox',
            'tbl_sys_field_type_class'       => 'AutomatorFieldCheckbox',
            'tbl_sys_field_type_icon'        => 'check-square',
            'tbl_sys_field_type_title'       => 'Checkbox',
            'tbl_sys_field_type_description' => 'Uma lista com botões de escolhas que você especifica.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Escolhas',
                'fields' => [

                  "choices" => [

                    "label"       => "Opções",
                    "type"        => "dynamic-list",
                    "nullable"    => "false",
                    "required"    => "true",
                    "placeholder" => "",
                    "description" => "",
                    "default"     => "",

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 3,
            'tbl_sys_field_type_name'        => 'dynamic-list',
            'tbl_sys_field_type_class'       => 'AutomatorFieldDynamicList',
            'tbl_sys_field_type_icon'        => 'list',
            'tbl_sys_field_type_title'       => 'Lista Dinamica',
            'tbl_sys_field_type_description' => 'Um campo para carregar um lista dinamica através da seleção de um campo atualizado.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "choices"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ]

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],


        // Seleção - START



        // Relacional - START

          [

            'tbl_sys_field_type_group_ID'    => 4,
            'tbl_sys_field_type_name'        => 'relation',
            'tbl_sys_field_type_class'       => 'AutomatorFieldRelation',
            'tbl_sys_field_type_icon'        => 'sync',
            'tbl_sys_field_type_title'       => 'Relacional',
            'tbl_sys_field_type_description' => 'Uma interface interativa e personalizável para escolher um ou vários itens, páginas ou itens com a opção de pesquisa da relação criada para o campo.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "type" => [

                    "label"       => "Tipo de seleção",
                    "type"        => "select",
                    "nullable"    => "false",
                    "required"    => "true",
                    "description" => "",
                    "default"     => "select",
                    "choices"      => [

                      "select"   => "Caixa de seleção",
                      "checkbox" => "Botões de seleção",
                      "radio"    => "Lista de seleção",

                    ]

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  "max-selection" => [

                    "label"       => "Máximo de escolhas",
                    "type"        => "input[type='number']",
                    "nullable"    => "true",
                    "required"    => "false",
                    "placeholder" => "Número máximo de escolhas via checkbox da relação.",
                    "description" => "",
                    "default"     => "",

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ])

          ],

        // Relacional - END



        // Layout - START


          [

            'tbl_sys_field_type_group_ID'    => 5,
            'tbl_sys_field_type_name'        => 'breakline',
            'tbl_sys_field_type_class'       => 'AutomatorFieldBreakLine',
            'tbl_sys_field_type_icon'        => 'arrows-left-right',
            'tbl_sys_field_type_title'       => 'Quebra de Linha',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar uma quebra de linha.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code' => [

                'prefix' => '<[$tag$]>',
                'sufix'  => '</div>',
                'editor' => false,
                'has_child' => false,
                'class'     => 'col col-12 m-0 p-0',
                'tag'    => 'div'
              
              ],

              'block'   => [],
              'toolbar' => [],


            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 5,
            'tbl_sys_field_type_name'        => 'breakpoint',
            'tbl_sys_field_type_class'       => 'AutomatorFieldBreakLine',
            'tbl_sys_field_type_icon'        => 'arrows-left-right',
            'tbl_sys_field_type_title'       => 'Quebra de Linha',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar uma quebra de linha no formulário.',
            'tbl_sys_field_type_layout'      => false,
            'tbl_sys_field_type_configs'     => json_encode([

              'code' => [

                'prefix' => '<[$tag$]',
                'sufix'  => ' />',
                'tag'    => 'hr'
              
              ],

              'block'   => [],
              'toolbar' => [],


            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 5,
            'tbl_sys_field_type_name'        => 'block',
            'tbl_sys_field_type_class'       => 'AutomatorFieldBlock',
            'tbl_sys_field_type_icon'        => 'th-large',
            'tbl_sys_field_type_title'       => 'Bloco',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar um bloco na tela.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code' => [

                'prefix'    => '<[$tag$]>',
                'sufix'     => '</[$tag$]>',
                'tag'       => 'div',
                'has_child' => true,
              
              ],

              'block' => [

                'margin' => [
                  
                  'label'  => 'Margens',
                  'fields' => [

                    'margin'  => [

                      'label'   => 'Margem',
                      'field'   => 'select',
                      'default' => 'mb-2',
                      'choices' => [

                        'mb-0' => 'Nenhuma',
                        'mb-2' => 'Pequena',
                        'mb-4' => 'Média',
                        'mb-5' => 'Grande',

                      ]

                    ],

                  ]

                ],

                'advanced' => [
                  
                  'label'  => 'Avançado',
                  'fields' => [

                    'class'  => [

                      'label'   => 'Classes Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ]

                  ]

                ]
              ],
              'toolbar' => [],


            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],


          [

            'tbl_sys_field_type_group_ID'    => 5,
            'tbl_sys_field_type_name'        => 'container',
            'tbl_sys_field_type_class'       => 'AutomatorFieldContainer',
            'tbl_sys_field_type_icon'        => 'square',
            'tbl_sys_field_type_title'       => 'Container',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar um container para inserir linhas e colunas.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$] class="[$class$]">',
                'sufix'     => '</[$tag$]>',
                'tag'       => 'div',
                'class'     => 'container',
                'has_child' => true,

              ],

              'block' => [

                'fluid' => [

                  'label'  => 'Fluid',
                  'fields' => [

                    'type'  => [

                      'label'   => 'Tipo',
                      'field'   => 'select',
                      'default' => 'container',
                      'choices' => [

                        'container'       => 'Container',
                        'container-fluid' => 'Container Fluid',

                      ]

                    ],

                  ]

                ],

                'margin' => [
                  
                  'label'  => 'Margens',
                  'fields' => [

                    'margin'  => [

                      'label'   => 'Margem',
                      'field'   => 'select',
                      'default' => 'mb-2',
                      'choices' => [

                        'mb-0' => 'Nenhuma',
                        'mb-2' => 'Pequena',
                        'mb-4' => 'Média',
                        'mb-5' => 'Grande',

                      ]

                    ],

                  ]

                ],

                'advanced' => [
                  
                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do Container',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ]

                  ]

                ]
              ]
              
            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 5,
            'tbl_sys_field_type_name'        => 'row',
            'tbl_sys_field_type_class'       => 'AutomatorFieldRow',
            'tbl_sys_field_type_icon'        => 'ruler-horizontal',
            'tbl_sys_field_type_title'       => 'Linha (Row)',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar uma linha com uma ou várias colunas.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$] class="[$class$]">',
                'sufix'     => '</[$tag$]>',
                'tag'       => 'div',
                'class'     => 'row',
                'has_child' => true

              ],

              'block' => [

                'options' => [

                  'label'  => 'Opções da linha',
                  'fields' => [

                    'horizontal' => [

                      'label'   => 'Margens Horizontais',
                      'field'   => 'select',
                      'default' => 'gx-4',
                      'choices' => [

                        'gx-4' => 'Média (Padrão)',
                        'gx-0' => 'Nenhuma',
                        'gx-3' => 'Pequena',
                        'gx-5' => 'Grande'

                      ]

                    ],

                    'vertical' => [

                      'label'   => 'Margens Verticais',
                      'field'   => 'select',
                      'default' => 'gy-0',
                      'choices' => [

                        'gy-0' => 'Nenhuma (Padrão)',
                        'gy-3' => 'Pequena',
                        'gy-4' => 'Média',
                        'gy-5' => 'Grande'

                      ]

                    ],

                  ]

                ],

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID da linha',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ],

              'toolbar' => []

            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 5,
            'tbl_sys_field_type_name'        => 'col',
            'tbl_sys_field_type_class'       => 'AutomatorFieldCol',
            'tbl_sys_field_type_icon'        => 'ruler-vertical',
            'tbl_sys_field_type_title'       => 'Coluna (Col)',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar uma coluna dentro de uma linha.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$] class="[$class$]">',
                'sufix'     => '</[$tag$]>',
                'tag'       => 'div',
                'class'     => 'col',
                'has_child' => true,
                'data'      => [

                  'col'     => 12,
                  'col-sm'  => 12,
                  'col-md'  => 6,
                  'col-lg'  => 6,
                  'col-xl'  => 6,
                  'col-xxl' => 6,

                ],
                'onload'    => [

                  "SysAutomator.getCurrentResolutionSize()"

                ]
              
              ],

              'block' => [

                'size' => [

                  'label'  => 'Tamanho da coluna',
                  'fields' => [

                    'column-xs' => [

                      'label'   => 'Tamanho XS',
                      'field'   => 'range',
                      'minval'  => 1,
                      'maxval'  => 12,
                      'default' => 12,
                      'oninput' => "SysAutomatorEditor.changeColClassSize(this, 'col-')",

                    ],

                    'column-sm' => [

                      'label'   => 'Tamanho SM',
                      'field'   => 'range',
                      'minval'  => 1,
                      'maxval'  => 12,
                      'default' => 12,
                      'oninput' => "SysAutomatorEditor.changeColClassSize(this, 'col-sm-')",

                    ],

                    'column-md' => [

                      'label'   => 'Tamanho MD',
                      'field'   => 'range',
                      'minval'  => 1,
                      'maxval'  => 12,
                      'default' => 6,
                      'oninput' => "SysAutomatorEditor.changeColClassSize(this, 'col-md-')",

                    ],

                    'column-lg' => [

                      'label'   => 'Tamanho LG',
                      'field'   => 'range',
                      'minval'  => 1,
                      'maxval'  => 12,
                      'default' => 6,
                      'oninput' => "SysAutomatorEditor.changeColClassSize(this, 'col-lg-')",

                    ],

                    'column-xl' => [

                      'label'   => 'Tamanho XL',
                      'field'   => 'range',
                      'minval'  => 1,
                      'maxval'  => 12,
                      'default' => 6,
                      'oninput' => "SysAutomatorEditor.changeColClassSize(this, 'col-xl-')",

                    ],

                    'column-xxl' => [

                      'label'   => 'Tamanho XXL',
                      'field'   => 'range',
                      'minval'  => 1,
                      'maxval'  => 12,
                      'default' => 6,
                      'oninput' => "SysAutomatorEditor.changeColClassSize(this, 'col-xxl-')",

                    ],

                  ]

                ],

                'colors' => [

                  'label'  => "Cores",
                  'fields' => [

                    'background' => [

                      'label'   => 'Cor de fundo',
                      'field'   => 'radio-color-class',
                      'default' => 'none',
                      'custom'  => true,
                      'choices' => [

                        'none'         => 'Transparente',
                        'bg-primary'   => 'primary',
                        'bg-secondary' => 'secondary',
                        'bg-danger'    => 'danger',
                        'bg-info'      => 'info',
                        'bg-warning'   => 'warning',
                        'bg-white'     => 'white',
                        'bg-black'     => 'black',
                        'custom'       => 'Personalizado',

                      ]
                    ],

                    'color' => [

                      'label'   => 'Cor do texto',
                      'field'   => 'radio-color-class',
                      'default' => 'text-black',
                      'custom'  => true,
                      'choices' => [

                        'text-black'     => 'black',
                        'text-primary'   => 'primary',
                        'text-secondary' => 'secondary',
                        'text-danger'    => 'danger',
                        'text-info'      => 'info',
                        'text-warning'   => 'warning',
                        'text-white'     => 'white',
                        'custom'         => 'Personalizado',
                        'none'           => 'Transparente',

                      ]

                    ],

                  ]

                ],

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID da coluna',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ]

            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],


        // Layout - END



        // Card - START

          [

            'tbl_sys_field_type_group_ID'    => 8,
            'tbl_sys_field_type_name'        => 'card',
            'tbl_sys_field_type_class'       => 'AutomatorFieldCard',
            'tbl_sys_field_type_icon'        => 'window-maximize',
            'tbl_sys_field_type_title'       => 'Card',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar card com titulo e conteudo personalizável.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                'prefix'    => '<[$tag$] class="[$class$]">',
                'sufix'     => '</[$tag$]>',
                'tag'       => 'div',
                'class'     => 'card',
                'has_child' => true

              ],

              'block' => [

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do card',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ],

              'toolbar' => []

            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [

            'tbl_sys_field_type_group_ID'    => 8,
            'tbl_sys_field_type_name'        => 'card-header',
            'tbl_sys_field_type_class'       => 'AutomatorFieldCardHeader',
            'tbl_sys_field_type_icon'        => 'minus',
            'tbl_sys_field_type_title'       => 'Card Header',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar card com titulo e conteudo personalizável.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code' => [

                'prefix'    => '<div class="[$class$]">',
                'sufix'     => '</div>',
                'tag'       => 'div',
                'class'     => 'card-header',
                'has_child' => true

              ],
              'block' => [

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do Header',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ],
              'toolbar' => []

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 8,
            'tbl_sys_field_type_name'        => 'card-body',
            'tbl_sys_field_type_class'       => 'AutomatorFieldCardBody',
            'tbl_sys_field_type_icon'        => 'square',
            'tbl_sys_field_type_title'       => 'Card Body',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar o conteudo a um card personalizável.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code' => [

                'prefix'    => '<div class="[$class$]">',
                'sufix'     => '</div>',
                'tag'       => 'div',
                'class'     => 'card-body',
                'has_child' => true

              ],
              'block' => [

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do Body',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ],
              'toolbar' => []

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 8,
            'tbl_sys_field_type_name'        => 'card-footer',
            'tbl_sys_field_type_class'       => 'AutomatorFieldCardFooter',
            'tbl_sys_field_type_icon'        => 'window-minimize',
            'tbl_sys_field_type_title'       => 'Card Footer',
            'tbl_sys_field_type_description' => 'Um elemento HTML para adicionar o conteudo do footer a um card personalizável.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code' => [

                'prefix'    => '<div class="[$class$]">',
                'sufix'     => '</div>',
                'tag'       => 'div',
                'class'     => 'card-footer',
                'has_child' => true

              ],
              'block' => [

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID do Footer',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ],
              'toolbar' => []

            ])

          ],

        // Card - END



        // Avançado - START

          [

            'tbl_sys_field_type_group_ID'    => 6,
            'tbl_sys_field_type_name'        => 'hidden',
            'tbl_sys_field_type_class'       => 'AutomatorFieldHidden',
            'tbl_sys_field_type_icon'        => 'eye-slash',
            'tbl_sys_field_type_title'       => 'Hidden (Invisível)',
            'tbl_sys_field_type_description' => 'Um campo sem aparencia visual para enviar ou armazenar valores.',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => json_encode([
              
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "text",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  "type" => [

                    "label"       => "Tipo",
                    "type"        => "select",
                    "nullable"    => "false",
                    "required"    => "true",
                    "description" => "Tipo de valor do campo.",
                    "default"     => "string",
                    "values"      => [

                      "string" => "Texto",
                      "int"    => "Inteiro",
                      "float"  => "Flutuante"

                    ]

                  ],

                ]

              ]

            ])

          ],

          [

            'tbl_sys_field_type_group_ID'    => 6,
            'tbl_sys_field_type_name'        => 'json',
            'tbl_sys_field_type_class'       => 'AutomatorFieldJson',
            'tbl_sys_field_type_icon'        => 'code',
            'tbl_sys_field_type_title'       => 'JSON',
            'tbl_sys_field_type_description' => 'Um campo para armazenar valores em forma de json dentro do banco de dados.',
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params' => json_encode([

              'wrapper' => [

                'label'  => 'Tamanho do campo',
                'fields' => [

                  'column-xs' => [
                    'label'   => 'Tamanho XS',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-sm' => [
                    'label'   => 'Tamanho SM',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 12,
                  ],

                  'column-md' => [
                    'label'   => 'Tamanho MD',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-lg' => [
                    'label'   => 'Tamanho LG',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xl' => [
                    'label'   => 'Tamanho XL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                  'column-xxl' => [
                    'label'   => 'Tamanho XXL',
                    'field'   => 'range',
                    'minval'  => 1,
                    'maxval'  => 12,
                    'default' => 6,
                  ],

                ]

              ],
              "configs"    => [
                
                'label'  => 'Configurações',
                'fields' => [

                  "required" => [

                    "label"       => "Obrigatório",
                    "type"        => "select",
                    "required"    => "true",
                    "nullable"    => "false",
                    "description" => "Campo Obrigatório.",
                    "default"     => "false",
                    "values"      => [

                      "false" => "Não",
                      "true"  => "Sim"

                    ]

                  ],
                  "value" => [

                    "label"       => "Valor Padrão",
                    "type"        => "textarea",
                    "nullable"    => "true",
                    'required'    => "false",
                    "placeholder" => "",
                    "description" => "Valor padrão.",
                    "default"     => "",

                  ],

                ]

              ],
              "advanced" => [

                'label'  => 'Avançado',
                'fields' => [

                  'minlenght' => [

                    'label'    => 'Minímo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],
                  'maxlenght' => [

                    'label'    => 'Máximo de caracteres',
                    'field'    => "input[type='number']",
                    'default'  => "",
                    "nullable" => "true",
                    'required' => "false"

                  ],

                ]

              ],
              'aparencia' => [
                  
                'label'  => 'Aparência',
                'fields' => [

                  'class'  => [

                    'label'   => 'Classes Adicionais',
                    'field'   => 'text',
                    'default' => ''

                  ],

                  'style'  => [

                    'label'   => 'Estilo adicional',
                    'field'   => 'editor-css',
                    'class'   => 'textarea-css-editor',
                    'default' => ''

                  ]

                ]

              ]

            ]),

          ],

        // Avançado - END
        


        // Automator - START


          [

            'tbl_sys_field_type_group_ID'    => 7,
            'tbl_sys_field_type_name'        => 'pagination',
            'tbl_sys_field_type_class'       => 'AutomatorFieldPagination',
            'tbl_sys_field_type_icon'        => 'list',
            'tbl_sys_field_type_title'       => 'Paginação',
            'tbl_sys_field_type_description' => 'Um elemento que inclui uma paginação de resultados gerada pelo sistema.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code'  => [

                // 'prefix' => '[automator function="pagination" name="${name}"',
                // 'sufix'  => ']',
                'prefix'    => '<div style="width: 100%;"><code>[automator function="pagination" name="${pagination}"',
                'sufix'     => ']</code></div>',
                'tag'       => '<code>',
                'has_child' => false,
                'vars'      => [
                  
                  'pagination' => [

                    'type'  => 'relation',
                    'table' => 'tbl_sys_paginations',
                    'index' => 'tbl_sys_pagination_name',
                    'label' => 'tbl_sys_pagination_title'

                  ]

                ]

              ],

              'block' => [

                'config' => [

                  'label'  => 'Configurações',
                  'fields' => [

                    'pagination'  => [

                      'label'   => 'Paginação',
                      'field'   => 'select',
                      'default' => '',
                      'choices' => []

                    ],

                  ]

                ],

                'advanced' => [

                  'label'  => 'Avançado',
                  'fields' => [

                    'id'  => [

                      'label'   => 'ID da paginação',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'class'  => [

                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''

                    ],

                    'style'  => [

                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''

                    ],

                  ]

                ]

              ]
              
            ]),
            'tbl_sys_field_type_locked'      => true,
            'tbl_sys_field_type_params'      => ''

          ],

          [
            'tbl_sys_field_type_group_ID'    => 7,
            'tbl_sys_field_type_name'        => 'shortcode',
            'tbl_sys_field_type_class'       => 'AutomatorFieldShortcode',
            'tbl_sys_field_type_icon'        => 'code',
            'tbl_sys_field_type_title'       => 'Shortcode',
            'tbl_sys_field_type_description' => 'Um elemento para executar um comando registrado no sistema através de um código específico.',
            'tbl_sys_field_type_layout'      => true,
            'tbl_sys_field_type_configs'     => json_encode([

              'code' => [
                'prefix'    => '<div style="width: 100%;"><code>[${shortcode}',
                'sufix'     => ']</code></div>',
                'tag'       => '<code>',
                'has_child' => false,
                'vars'      => [
                  'shortcode' => [
                    'type'        => 'relation',
                    'table'       => 'tbl_sys_shortcodes',
                    'index'       => 'tbl_sys_shortcode_code',
                    'label'       => 'tbl_sys_shortcode_title',
                    'description' => 'tbl_sys_shortcode_description',
                    'params'      => 'tbl_sys_shortcode_params'
                  ]
                ]
              ],

              'block' => [
                'config' => [
                  'label'  => 'Configurações',
                  'fields' => [
                    'shortcode' => [
                      'label'   => 'Shortcode',
                      'field'   => 'select',
                      'default' => '',
                      'choices' => []
                    ]
                  ]
                ],

                'advanced' => [
                  'label'  => 'Avançado',
                  'fields' => [
                    'id' => [
                      'label'   => 'ID do shortcode',
                      'field'   => 'text',
                      'default' => ''
                    ],

                    'class' => [
                      'label'   => 'Classes CSS Adicionais',
                      'field'   => 'text',
                      'default' => ''
                    ],

                    'style' => [
                      'label'   => 'Estilo CSS adicional',
                      'field'   => 'editor-css',
                      'class'   => 'textarea-css-editor',
                      'default' => ''
                    ]
                  ]
                ]
              ]

            ]),
            'tbl_sys_field_type_locked' => true,
            'tbl_sys_field_type_params' => ''
          ],


        // Automator - END

      ];


      foreach ($campos as $field) {
        
        SysFieldType::Create($field);

      }


    }



  }
