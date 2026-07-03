<?php


  namespace App\Automator;

  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\DB;


  use App\Helpers\SysAutomator;


  use App\Models\SysFieldType;


  class AutomatorFields {



    /*
    |--------------------------------------------------------------------------
    | Renderiza todos os campos de um formulário
    |--------------------------------------------------------------------------
    */

    public static function renderFormFields($formData = [], $values = []) {


      $fields = $formData['fields'] ?? [];

      $renderedFields = [];
      // $formData['form']['tbl_sys_form_modal'] == 0 || $formData['form']['tbl_sys_form_modal'] == false
      $html = '<form class="row" method="' . ( ($formData['form']['tbl_sys_form_method']) ? ( ($formData['form']['tbl_sys_form_method'] != '') ? $formData['form']['tbl_sys_form_method'] : '' ) : '' ) . '" action="' . ( ($formData['form']['tbl_sys_form_route']) ? ( ($formData['form']['tbl_sys_form_route'] != '') ? SysAutomator::SysAutomatorGetRouteLinkByName($formData['form']['tbl_sys_form_route']) : '' ) : '' ) . '" data-submit="false" data-form-validate="' . ( ( ($formData['form']['tbl_sys_form_validate'] == true) || ($formData['form']['tbl_sys_form_validate'] == 1) ) ? 'true' : 'false' ) . '">';

      $html .= '<input type="hidden" name="automatorFormID" value="' . $formData['form']['tbl_sys_form_ID'] . '" />';


      foreach($fields as $field) {


        $field['value'] = self::getFieldValue($field, $values);

        // var_dump($field['config']);

        $_field = [

          'form'       => $formData['form'] ?? [],
          'field'      => $field,
          'fields'     => $fields,
          'props'      => $field['props'] ?? [],
          'attrs'      => $field['attrs'] ?? [],
          'config'     => $field['config'] ?? [],
          'field_type' => $field['field_type'] ?? [],
          'values'     => $values,
          'render'     => 'formulario',

        ];


        if(!isset($_field['props']['wrapper_class'])) {

          $_field['props']['wrapper_class'] = 'col-12';

        }


        $fieldHTML = self::renderFormField($_field);

        $field['html'] = $fieldHTML;

        $renderedFields[] = $field;

        $html .= $fieldHTML;


      }


      if($formData['form']['tbl_sys_form_modal'] == 0 || $formData['form']['tbl_sys_form_modal'] == false) {
          
        $html .= '<div class="col-12">' . "\n";
          
          $html .= '<div class="row">' . "\n";

            
            $html .= '<div class="col-12 order-2 col-md-6 order-md-1 mb-3">' . "\n";

              $html .= '<button type="reset" class="btn btn-secondary w-100 text-center">' . $formData['form']['tbl_sys_form_cancel'] . '</button>' . "\n";

            $html .= '</div>' . "\n";


            $html .= '<div class="col-12 order-1 col-md-6 order-md-2 mb-3">' . "\n";
              
              $html .= '<button type="submit" class="btn btn-primary w-100 text-center">' . $formData['form']['tbl_sys_form_submit'] . '</button>' . "\n";

            $html .= '</div>' . "\n";
            

          $html .= '</div>' . "\n";

        $html .= '</div>' . "\n";

      }
      $html .= '</form>';


      return [

        'fields' => $renderedFields,
        'html'   => $html,

      ];


    }



    /*
    |--------------------------------------------------------------------------
    | Renderiza um campo de formulário
    |--------------------------------------------------------------------------
    */

    public static function renderFormField($args = []) {


      $fieldType = $args['field_type'] ?? [];

      $fieldClass = self::resolveFieldClass($fieldType);

      $fieldLabel = self::getFieldTypeLabel($fieldType);


      if($fieldClass === null) {

        return self::formErrorMessage('O tipo de campo ' . $fieldLabel . ' não existe');

      }


      if(!method_exists($fieldClass, 'formField')) {

        return self::formErrorMessage('O tipo de campo ' . $fieldLabel . ' não possui renderização de formulário');

      }


      return $fieldClass::formField($args);


    }



    /*
    |--------------------------------------------------------------------------
    | Renderiza coluna de paginação
    |--------------------------------------------------------------------------
    */

    public static function renderPaginationColumn($columnType = 'tbody', $args = []) {


      $args['render']     = 'paginacao';
      $args['columnType'] = $columnType;


      $fieldType = $args['column']['field_type'] ?? [];

      $fieldClass = self::resolveFieldClass($fieldType);


      if($fieldClass === null) {

        return '';

      }


      if(!method_exists($fieldClass, 'paginationColumn')) {

        return '';

      }


      return $fieldClass::paginationColumn($args);


    }



    /*
    |--------------------------------------------------------------------------
    | Resolve classe do tipo de campo
    |--------------------------------------------------------------------------
    */

    public static function resolveFieldClass($fieldType = []) {


      if(!is_array($fieldType)) {

        return null;

      }


      $className = $fieldType['tbl_sys_field_type_class'] ?? '';


      if($className == '') {

        return null;

      }


      $className = trim($className, '\\');

      $fullClass = 'App\\Automator\\' . $className;


      if(class_exists($fullClass)) {

        return $fullClass;

      }


      if(class_exists($className)) {

        return $className;

      }


      return null;


    }



    /*
    |--------------------------------------------------------------------------
    | Nome amigável do tipo de campo
    |--------------------------------------------------------------------------
    */

    public static function getFieldTypeLabel($fieldType = []) {


      if(!is_array($fieldType)) {

        return '';

      }


      if(isset($fieldType['tbl_sys_field_type_title']) && $fieldType['tbl_sys_field_type_title'] != '') {

        return $fieldType['tbl_sys_field_type_title'];

      }


      if(isset($fieldType['tbl_sys_field_type_name']) && $fieldType['tbl_sys_field_type_name'] != '') {

        return ucfirst($fieldType['tbl_sys_field_type_name']);

      }


      if(isset($fieldType['tbl_sys_field_type_class']) && $fieldType['tbl_sys_field_type_class'] != '') {

        return str_replace('AutomatorField', '', $fieldType['tbl_sys_field_type_class']);

      }


      return '';



    }



    /*
    |--------------------------------------------------------------------------
    | Retorno visual de erro para formulário
    |--------------------------------------------------------------------------
    */

    public static function formErrorMessage($message = '') {


      return '<div class="alert alert-warning mb-3">' . e($message) . '</div>';


    }



    /*
    |--------------------------------------------------------------------------
    | Renderiza view padronizada
    |--------------------------------------------------------------------------
    */

    public static function renderView($view = '', $args = [], $formError = true) {


      $fieldType = $args['field_type'] ?? [];

      $fieldLabel = self::getFieldTypeLabel($fieldType);


      if($view == '' || !View::exists($view)) {

        if(($args['render'] ?? '') == 'paginacao') {

          return '';

        }

        if($formError == true) {

          return self::formErrorMessage('A view do tipo de campo ' . $fieldLabel . ' não existe');

        }

        return '';

      }


      return view($view, self::normalizeArgs($args))->render();


    }



    /*
    |--------------------------------------------------------------------------
    | Normaliza argumentos para as views
    |--------------------------------------------------------------------------
    */

    public static function normalizeArgs($args = []) {


      $args['form']       = $args['form'] ?? [];
      $args['field']      = $args['field'] ?? [];
      $args['fields']     = $args['fields'] ?? [];
      $args['props']      = $args['props'] ?? [];
      $args['attrs']      = $args['attrs'] ?? [];
      $args['config']     = $args['config'] ?? [];
      $args['field_type'] = $args['field_type'] ?? [];
      $args['values']     = $args['values'] ?? [];
      $args['render']     = $args['render'] ?? 'formulario';

      $args['pagination'] = $args['pagination'] ?? [];
      $args['column']     = $args['column'] ?? [];
      $args['columns']    = $args['columns'] ?? [];
      $args['item']       = $args['item'] ?? null;
      $args['request']    = $args['request'] ?? [];
      $args['columnType'] = $args['columnType'] ?? null;


      if($args['render'] == 'formulario') {

        $field = $args['field'];

        $fieldID = $field['tbl_sys_forms_field_ID'] ?? uniqid();

        $fieldName = $field['tbl_sys_forms_field_name'] ?? '';

        $args['field_id'] = $field['field_id'] ?? ('field_' . $fieldID);

        $args['field_name'] = $field['field_name'] ?? $fieldName;

        $args['field_label'] = $field['tbl_sys_forms_field_title'] 
          ?? $field['tbl_sys_forms_field_label'] 
          ?? '';

        $args['field_value'] = $field['value'] ?? self::getFieldValue($field, $args['values']);

        $args['field_required'] = self::isTruthy($field['tbl_sys_forms_field_required'] ?? false);

        $args['field_class'] = $field['tbl_sys_forms_field_class'] ?? '';

        $args['field_selector'] = $field['field_selector'] ?? (($fieldName != '') ? '[name="' . $fieldName . '"]' : '');

        /*
        |--------------------------------------------------------------------------
        | Atributos booleanos vindos de props
        |--------------------------------------------------------------------------
        |
        | Permite usar disabled/readonly diretamente em tbl_sys_forms_field_props
        | ou em tbl_sys_forms_field_attrs. O attrs continua tendo prioridade,
        | mas quando não existir, a propriedade é convertida para atributo HTML.
        |
        */

        if(!isset($args['attrs']['disabled']) && self::isTruthy($args['props']['disabled'] ?? false)) {

          $args['attrs']['disabled'] = true;

        }

        if(
          !isset($args['attrs']['readonly']) &&
          (
            self::isTruthy($args['props']['readonly'] ?? false) ||
            self::isTruthy($args['props']['readonlue'] ?? false)
          )
        ) {

          $args['attrs']['readonly'] = true;

        }

        $args['field_attrs'] = self::renderAttrs($args['attrs']);

      }


      if($args['render'] == 'paginacao') {

        $column = $args['column'];

        $args['column_name'] = $column['column_name'] 
          ?? $column['tbl_sys_paginations_col_name'] 
          ?? $column['tbl_sys_paginations_col_field'] 
          ?? $column['tbl_sys_paginations_col_column'] 
          ?? '';

        $args['column_label'] = $column['label']
          ?? $column['tbl_sys_paginations_col_title']
          ?? $column['tbl_sys_paginations_col_label']
          ?? $args['column_name'];

        $args['column_value'] = self::getColumnValue($args['item'], $args['column_name']);

        if(isset($column['replaced']) && is_array($column['replaced']) && array_key_exists($args['column_value'], $column['replaced'])) {

          $args['column_value'] = $column['replaced'][$args['column_value']];

        }

        $args['column_attrs'] = self::renderAttrs($args['attrs']);

      }


      return $args;


    }



    /*
    |--------------------------------------------------------------------------
    | Valor de campo de formulário
    |--------------------------------------------------------------------------
    */

    public static function getFieldValue($field = [], $values = []) {


      $fieldName = $field['tbl_sys_forms_field_name'] 
        ?? $field['field_name'] 
        ?? '';


      if($fieldName != '' && is_array($values) && array_key_exists($fieldName, $values)) {

        return $values[$fieldName];

      }


      if(isset($field['value']) && $field['value'] !== '') {

        return $field['value'];

      }


      $default = $field['tbl_sys_forms_field_default'] 
        ?? $field['tbl_sys_forms_field_value'] 
        ?? '';


      if($fieldName != '') {

        return old($fieldName, $default);

      }


      return $default;


    }



    /*
    |--------------------------------------------------------------------------
    | Valor da coluna de paginação
    |--------------------------------------------------------------------------
    */

    public static function getColumnValue($item = null, $columnName = '') {


      if($item === null || $columnName == '') {

        return '';

      }


      if(is_array($item)) {

        return $item[$columnName] ?? '';

      }


      if(is_object($item)) {

        return $item->$columnName ?? '';

      }


      return '';


    }



    /*
    |--------------------------------------------------------------------------
    | Renderiza atributos HTML
    |--------------------------------------------------------------------------
    */

    public static function renderAttrs($attrs = []) {


      if(!is_array($attrs) || count($attrs) <= 0) {

        return '';

      }


      $html = '';


      foreach($attrs as $attrName => $attrValue) {


        if($attrName === null || $attrName === '') {

          continue;

        }


        if($attrValue === true) {

          $html .= ' ' . e($attrName);

        } else if($attrValue !== false && $attrValue !== null) {

          $html .= ' ' . e($attrName) . '="' . e($attrValue) . '"';

        }


      }


      return $html;


    }



    /*
    |--------------------------------------------------------------------------
    | Boolean helper
    |--------------------------------------------------------------------------
    */

    public static function isTruthy($value) {


      return ($value === true || $value === 1 || $value === '1' || $value === 'true');


    }



    public static function renderViewEditorField($field, $data = []) {

      $type = SysFieldType::where('tbl_sys_field_type_layout', true)
        ->where('tbl_sys_field_type_ID', $field)
        ->first();

      if(!$type) {
        return '';
      }

      $fieldType = $type->toArray();

      $dados = $fieldType;
      $dados['value'] = $data;

      $configs = (
        isset($dados['tbl_sys_field_type_configs']) &&
        $dados['tbl_sys_field_type_configs'] !== null &&
        $dados['tbl_sys_field_type_configs'] != ''
      )
        ? (array) json_decode($dados['tbl_sys_field_type_configs'], true)
        : [];

      $code = (
        isset($configs['code']) &&
        is_array($configs['code']) &&
        count($configs['code']) >= 1
      )
        ? $configs['code']
        : [];

      $blocks = (
        isset($configs['block']) &&
        is_array($configs['block'])
      )
        ? $configs['block']
        : [];

      $vars = (
        isset($code['vars'])
      )
        ? (
          is_array($code['vars'])
            ? $code['vars']
            : (
              is_object($code['vars'])
                ? (array) $code['vars']
                : []
            )
        )
        : false;

      $props = [];
      $existe = [];
      $relationItems = [];

      foreach ($blocks as $blockKey => $blockArgs) {

        if(!isset($blockArgs['fields']) || !is_array($blockArgs['fields'])) {
          continue;
        }

        foreach ($blockArgs['fields'] as $blockFieldsKey => $blockFieldsArgs) {

          if(is_array($vars) && count($vars) >= 1 && array_key_exists($blockFieldsKey, $vars)) {

            if(isset($vars[$blockFieldsKey]['type']) && $vars[$blockFieldsKey]['type'] == 'relation') {

              $varsQuery = DB::table($vars[$blockFieldsKey]['table'])->get()->toArray();

              if(is_array($varsQuery) && count($varsQuery) >= 1) {

                $varsData = [];
                $varsItems = [];

                foreach ($varsQuery as $varKey => $varValue) {

                  $varValue = (array) $varValue;

                  $indexColumn = $vars[$blockFieldsKey]['index'];
                  $labelColumn = $vars[$blockFieldsKey]['label'];

                  $indexValue = $varValue[$indexColumn] ?? '';
                  $labelValue = $varValue[$labelColumn] ?? $indexValue;

                  if($indexValue == '') {
                    continue;
                  }

                  $varsData[$indexValue] = $labelValue;

                  $item = [
                    'value' => $indexValue,
                    'code'  => $indexValue,
                    'label' => $labelValue,
                    'title' => $labelValue,
                  ];

                  if(isset($vars[$blockFieldsKey]['description'])) {

                    $descriptionColumn = $vars[$blockFieldsKey]['description'];

                    $item['description'] = $varValue[$descriptionColumn] ?? '';

                    if(isset($varValue[$descriptionColumn])) {
                      $item[$descriptionColumn] = $varValue[$descriptionColumn];
                    }

                  }

                  if(isset($vars[$blockFieldsKey]['params'])) {

                    $paramsColumn = $vars[$blockFieldsKey]['params'];
                    $paramsValue = $varValue[$paramsColumn] ?? [];

                    if(is_string($paramsValue) && $paramsValue != '') {

                      $decodedParams = json_decode($paramsValue, true);

                      $paramsValue = is_array($decodedParams)
                        ? $decodedParams
                        : [];

                    }

                    $paramsValue = self::resolveEditorShortcodeParamsRelations($paramsValue);

                    $item['params'] = $paramsValue;

                    if(isset($varValue[$paramsColumn])) {
                      $item[$paramsColumn] = $paramsValue;
                    }

                  }

                  $varsItems[$indexValue] = $item;

                }

                $blocks[$blockKey]['fields'][$blockFieldsKey]['choices'] = $varsData;

                $vars[$blockFieldsKey]['choices'] = $varsData;
                $vars[$blockFieldsKey]['items'] = $varsItems;

                $relationItems[$blockFieldsKey] = $varsItems;

              }

            }

          }

          if(array_key_exists('onload', $blockFieldsArgs)) {

            if(is_array($blockFieldsArgs['onload'])) {

              if(array_key_exists('add-prop', $blockFieldsArgs['onload'])) {

                foreach ($blockFieldsArgs['onload']['add-prop'] as $propItem) {

                  if(!array_key_exists(array_keys($propItem)[0], $props)) {
                    $props[array_keys($propItem)[0]] = array_values($propItem)[0];
                  }

                }

              }

            }

          }

        }

      }

      $rendered = isset($code['rendered']) ? $code['rendered'] : false;
      $prefix   = isset($code['prefix']) ? $code['prefix'] : false;
      $sufix    = isset($code['sufix']) ? $code['sufix'] : false;
      $editor   = isset($code['editor']) ? $code['editor'] : false;

      if($rendered == true) {

        $tag = isset($code['default']) ? $code['default'] : false;

        if($tag != false) {
          $tag = str_replace(['<', '>'], '', $tag);
          $prefix = str_replace('[$tag$]', '<' . $tag, $prefix);
          $sufix  = str_replace('[$tag$]', $tag, $sufix);
        }

      } else {

        $tag = isset($code['tag']) ? $code['tag'] : false;

        if($tag != false) {

          if(is_array($tag)) {
            $tag = $code['default'];
          }

          $tag = str_replace(['<', '>'], '', $tag);
          $prefix = str_replace('[$tag$]', $tag, $prefix);
          $sufix  = str_replace('[$tag$]', $tag, $sufix);

        }

        if($editor == true) {
          $prefix = substr($prefix, 0, -1) . ' contenteditable="true"' . ">";
        }

      }

      $retorno = [

        'id'             => $dados['tbl_sys_field_type_ID'],
        'type'           => $dados['tbl_sys_field_type_name'],
        'icon'           => $dados['tbl_sys_field_type_icon'],
        'title'          => $dados['tbl_sys_field_type_title'],
        'description'    => $dados['tbl_sys_field_type_description'],
        'code'           => '',
        'class'          => isset($code['class']) ? $code['class'] : '',
        'tag'            => isset($code['tag']) ? $code['tag'] : '',
        'prefix'         => $prefix,
        'sufix'          => $sufix,
        'toolbar'        => isset($configs['toolbar']) ? $configs['toolbar'] : [],
        'rendered'       => $rendered,
        'can_have_child' => isset($code['has_child']) ? $code['has_child'] : false,
        'props'          => $props,
        'editor'         => $editor,
        'properties'     => $blocks,
        'existe'         => $existe,
        'vars'           => $vars,

      ];

      if($dados['tbl_sys_field_type_name'] === 'shortcode') {
        $retorno['shortcodes'] = $relationItems['shortcode'] ?? [];
      }

      return $retorno;

    }

    // Funcionava
    // public static function renderViewEditorField($field, $data = []) {


    //   $type = SysFieldType::where('tbl_sys_field_type_layout', true)->where('tbl_sys_field_type_ID', $field)->first();
    //   if($type) {

    //     $fieldType = $type->toArray();

    //     $dados          = $fieldType;
    //     $dados['value'] = $data;


    //     $configs = ( ($dados['tbl_sys_field_type_configs'] !== null) ? ( ($dados['tbl_sys_field_type_configs'] != '') ? ( (array) json_decode($dados['tbl_sys_field_type_configs'], true) ) : [] ) : [] );

    //     $code = ( ($configs['code'] !== null) ? ( (is_array($configs['code'])) ? ( (count($configs['code']) >= 1) ? $configs['code'] : [] ) : [] ) : [] );

    //     $blocks = ( (isset($configs['block'])) ? ( (is_array($configs['block'])) ? $configs['block'] : [] ) : [] );
    //     $vars   = ( (isset($code['vars'])) ? ( (is_array($code['vars'])) ? $code['vars'] : ( (is_object($code['vars'])) ? ( (array) $code['vars'] ) : [] ) )  : false );
    //     $props  = [];
    //     $existe = [];

    //     foreach ($blocks as $blockKey => $blockArgs) {
          
    //       $fields = [];
    //       foreach ($blockArgs['fields'] as $blockFieldsKey => $blockFieldsArgs) {
            
    //         // $props[] = [$blockFieldsKey, $blockFieldsArgs];

    //         if(is_array($vars)) {

    //           if(count($vars) >= 1) {

    //             if(array_key_exists($blockFieldsKey, $vars)) {

    //               if($vars[$blockFieldsKey]['type'] == 'relation') {

    //                 $varsQuery = DB::table($vars[$blockFieldsKey]['table'])->get()->toArray();
    //                 if(is_array($varsQuery)) {

    //                   if(count($varsQuery) >= 1) {

    //                     $varsData = [];
    //                     foreach ($varsQuery as $varKey => $varValue) {
    //                       $varValue = ( (array) $varValue );
    //                       // $existe[] = $varValue[$vars[$blockFieldsKey]['label']];
    //                       $varsData[$varValue[$vars[$blockFieldsKey]['index']]] = $varValue[$vars[$blockFieldsKey]['label']];

    //                     }

    //                     // $existe[] = $blockArgs['fields'][$blockFieldsKey]['choices'];
    //                     // $existe[] = $varsData;


    //                     $blocks[$blockKey]['fields'][$blockFieldsKey]['choices'] = $varsData;

    //                   }

    //                 }

    //               }

    //             }

    //           }

    //         }

    //         if(array_key_exists('onload', $blockFieldsArgs)) {

    //           if(is_array($blockFieldsArgs['onload'])) {

    //             if(array_key_exists('add-prop', $blockFieldsArgs['onload'])) {

    //               foreach ($blockFieldsArgs['onload']['add-prop'] as $propItem) {
                    
    //                 // $props[] = array_values($propItem)[0];
    //                 // $props[] = array_keys($propItem)[0];
    //                 if(!array_key_exists(array_keys($propItem)[0], $props)) {

    //                   $props[array_keys($propItem)[0]] = array_values($propItem)[0];

    //                 }

    //               }

    //             }

    //           }

    //         }

    //       }

    //     }

    //     $rendered = ( (isset($code['rendered'])) ? $code['rendered']  : false );
    //     $prefix   = ( (isset($code['prefix']))   ? $code['prefix']  : false );
    //     $sufix    = ( (isset($code['sufix']))    ? $code['sufix']  : false );

    //     $editor = ( (isset($code['editor'])) ? $code['editor'] : false );

    //     if($rendered == true) {

    //       $tag = ( (isset($code['default'])) ? $code['default'] : false );
    //       if($tag != false) {

    //         $tag = str_replace(['<', '>'], '', $tag);
    //         $prefix = str_replace('[$tag$]', '<' . $tag, $prefix);
    //         $sufix  = str_replace('[$tag$]', $tag, $sufix);

    //       }

    //     } else {

    //       $tag = ( (isset($code['tag'])) ? $code['tag'] : false );
    //       if($tag != false) {

    //         if(is_array($tag)) {
    //           $tag = $code['default'];
    //         }
    //         $tag = str_replace(['<', '>'], '', $tag);
    //         $prefix = str_replace('[$tag$]', $tag, $prefix);
    //         $sufix  = str_replace('[$tag$]', $tag, $sufix);

    //       }
          
    //       if($editor == true) {

    //         $prefix = substr($prefix, 0, -1) . ' contenteditable="true"' . ">";

    //       }

    //     }


    //     $retorno = [

    //       'id'             => $dados['tbl_sys_field_type_ID'],
    //       'type'           => $dados['tbl_sys_field_type_name'],
    //       'icon'           => $dados['tbl_sys_field_type_icon'],
    //       'title'          => $dados['tbl_sys_field_type_title'],
    //       'description'    => $dados['tbl_sys_field_type_description'],
    //       'code'           => '',
    //       // 'code'           => $configs['code']['prefix'] . $configs['code']['sufix'],
    //       'class'          => ( (isset($code['class']))  ? $code['class']  : '' ),
    //       'tag'            => ( (isset($code['tag']))    ? $code['tag']    : '' ),
    //       'prefix'         => $prefix,
    //       'sufix'          => $sufix,
    //       'toolbar'        => ( (isset($configs['toolbar'])) ? $configs['toolbar'] : [] ),
    //       'rendered'       => $rendered,
    //       // 'default'        => ( (isset($code['default']))    ? $code['default']   : false ),
    //       'can_have_child' => ( (isset($code['has_child']))  ? $code['has_child'] : false ),
    //       'props'          => $props,
    //       'editor'         => $editor,
    //       'properties'     => $blocks,
    //       'existe'     => $existe,
    //       'vars'     => $vars,

    //     ];


    //     return $retorno;

    //   }

    //   return '';


    // }


    private static function resolveEditorShortcodeParamsRelations(array $params): array {

      foreach($params as $paramKey => $paramConfig) {

        if(
          !is_array($paramConfig) ||
          !isset($paramConfig['relation']) ||
          !is_array($paramConfig['relation'])
        ) {
          continue;
        }

        $relation = $paramConfig['relation'];

        if(
          !isset($relation['table']) ||
          !isset($relation['index']) ||
          !isset($relation['label'])
        ) {
          continue;
        }

        $choices = [];

        $items = DB::table($relation['table'])
          ->orderBy($relation['label'], 'asc')
          ->get()
          ->toArray();

        foreach($items as $item) {

          $item = (array) $item;

          $index = $item[$relation['index']] ?? '';
          $label = $item[$relation['label']] ?? $index;

          if($index == '') {
            continue;
          }

          $choices[$index] = $label;

        }

        $params[$paramKey]['choices'] = $choices;

      }

      return $params;

    }



  }