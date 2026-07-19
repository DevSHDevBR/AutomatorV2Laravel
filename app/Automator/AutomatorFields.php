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


      if(!is_array($formData)) {

        $formData = [];

      }


      if(!is_array($values)) {

        $values = [];

      }


      $form = $formData['form'] ?? [];

      $fields = $formData['fields'] ?? [];


      if(!is_array($form)) {

        $form = [];

      }


      if(!is_array($fields)) {

        $fields = [];

      }


      $renderedFields = [];


      /*
      |--------------------------------------------------------------------------
      | Dados do formulário
      |--------------------------------------------------------------------------
      */

      $formID = $form['tbl_sys_form_ID'] ?? '';

      $formName = $form['tbl_sys_form_name'] ?? '';

      $formMethod = $form['tbl_sys_form_method'] ?? '';

      $formRoute = $form['tbl_sys_form_route'] ?? '';

      $formValidate = $form['tbl_sys_form_validate'] ?? false;

      $formModal = $form['tbl_sys_form_modal'] ?? false;


      /*
      |--------------------------------------------------------------------------
      | Normaliza método
      |--------------------------------------------------------------------------
      */

      if(
        $formMethod === null ||
        trim((string) $formMethod) === ''
      ) {

        $formMethod = 'POST';

      }


      $formMethod = strtoupper(

        trim((string) $formMethod)

      );


      /*
      |--------------------------------------------------------------------------
      | Resolve action
      |--------------------------------------------------------------------------
      */

      $formAction = '';


      if(
        $formRoute !== null &&
        trim((string) $formRoute) !== ''
      ) {

        $formAction = SysAutomator::SysAutomatorGetRouteLinkByName(

          trim((string) $formRoute)

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Verifica se o formulário é modal
      |--------------------------------------------------------------------------
      */

      $isModal = self::isTruthy($formModal);


      /*
      |--------------------------------------------------------------------------
      | ID do elemento form
      |--------------------------------------------------------------------------
      */

      $formElementID = '';


      if(!$isModal) {

        $formIdentifier = $formID;


        if(
          $formIdentifier === null ||
          $formIdentifier === ''
        ) {

          $formIdentifier = $formName;

        }


        if(
          $formIdentifier === null ||
          $formIdentifier === ''
        ) {

          $formIdentifier = 'form';

        }


        $formIdentifier = preg_replace(

          '/[^a-zA-Z0-9\-_]/',

          '-',

          (string) $formIdentifier

        );


        $formElementID = 'automator-form-' .
                         trim($formIdentifier, '-') .
                         '-' .
                         uniqid();

      }


      /*
      |--------------------------------------------------------------------------
      | Classes do formulário
      |--------------------------------------------------------------------------
      */

      $formClasses = [

        'row'

      ];


      if(!$isModal) {

        $formClasses[] = 'automator-system-form';

        $formClasses[] = 'js-automator-system-page-form';

      }


      /*
      |--------------------------------------------------------------------------
      | Abertura do formulário
      |--------------------------------------------------------------------------
      */

      $html = '<form';


      if($formElementID !== '') {

        $html .= ' id="' . e($formElementID) . '"';

      }


      $html .= ' class="' . e(implode(' ', $formClasses)) . '"';

      $html .= ' method="' . e($formMethod) . '"';

      $html .= ' action="' . e($formAction) . '"';

      $html .= ' data-submit="false"';

      $html .= ' data-form-validate="' . (

        self::isTruthy($formValidate)

          ? 'true'

          : 'false'

      ) . '"';


      /*
      |--------------------------------------------------------------------------
      | Identificação exclusiva para formulários renderizados na página
      |--------------------------------------------------------------------------
      */

      if(!$isModal) {

        $html .= ' data-automator-system-form="true"';

        $html .= ' data-automator-form-modal="false"';

        $html .= ' data-automator-form-id="' . e($formID) . '"';

        $html .= ' data-automator-form-name="' . e($formName) . '"';

        $html .= ' data-automator-form-changed="false"';

      }


      $html .= '>';


      /*
      |--------------------------------------------------------------------------
      | ID do formulário no Automator
      |--------------------------------------------------------------------------
      */

      $html .= '<input';

      $html .= ' type="hidden"';

      $html .= ' name="automatorFormID"';

      $html .= ' value="' . e($formID) . '"';

      $html .= ' />';


      /*
      |--------------------------------------------------------------------------
      | Renderiza campos
      |--------------------------------------------------------------------------
      */

      foreach($fields as $field) {


        if(!is_array($field)) {

          continue;

        }


        $field['value'] = self::getFieldValue(

          $field,

          $values

        );


        $_field = [

          'form'       => $form,
          'field'      => $field,
          'fields'     => $fields,
          'props'      => self::normalizeFieldPropsForRender($field),
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


      /*
      |--------------------------------------------------------------------------
      | Botões para formulário não modal
      |--------------------------------------------------------------------------
      */

      if(!$isModal) {

        $html .= self::renderFormActions(

          $form,

          $formElementID

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Fechamento do formulário
      |--------------------------------------------------------------------------
      */

      $html .= '</form>';


      return [

        'fields'          => $renderedFields,
        'html'            => $html,
        'form_element_id' => $formElementID,

      ];


    }

    /*
    |--------------------------------------------------------------------------
    | Renderiza todos os campos de um formulário
    |--------------------------------------------------------------------------
    */

    // public static function renderFormFields($formData = [], $values = []) {


    //   if(!is_array($formData)) {

    //     $formData = [];

    //   }


    //   if(!is_array($values)) {

    //     $values = [];

    //   }


    //   $form = $formData['form'] ?? [];

    //   $fields = $formData['fields'] ?? [];


    //   if(!is_array($form)) {

    //     $form = [];

    //   }


    //   if(!is_array($fields)) {

    //     $fields = [];

    //   }


    //   $renderedFields = [];


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Dados do formulário
    //   |--------------------------------------------------------------------------
    //   */

    //   $formID = $form['tbl_sys_form_ID'] ?? '';

    //   $formName = $form['tbl_sys_form_name'] ?? '';

    //   $formMethod = $form['tbl_sys_form_method'] ?? '';

    //   $formRoute = $form['tbl_sys_form_route'] ?? '';

    //   $formValidate = $form['tbl_sys_form_validate'] ?? false;

    //   $formModal = $form['tbl_sys_form_modal'] ?? false;


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Normaliza o método
    //   |--------------------------------------------------------------------------
    //   */

    //   if($formMethod === null || trim((string) $formMethod) === '') {

    //     $formMethod = 'POST';

    //   }


    //   $formMethod = strtoupper(trim((string) $formMethod));


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Resolve a action
    //   |--------------------------------------------------------------------------
    //   */

    //   $formAction = '';


    //   if($formRoute !== null && trim((string) $formRoute) !== '') {

    //     $formAction = SysAutomator::SysAutomatorGetRouteLinkByName(

    //       trim((string) $formRoute)

    //     );

    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Verifica se o formulário é modal
    //   |--------------------------------------------------------------------------
    //   */

    //   $isModal = self::isTruthy($formModal);


    //   /*
    //   |--------------------------------------------------------------------------
    //   | ID do formulário
    //   |--------------------------------------------------------------------------
    //   |
    //   | Formulários não modais precisam de um ID próprio para que os botões
    //   | externos ou internos possam utilizar o atributo HTML "form".
    //   |
    //   | O ID também recebe um identificador único para permitir que o mesmo
    //   | formulário seja renderizado mais de uma vez na página.
    //   |
    //   */

    //   $formElementID = '';


    //   if(!$isModal) {

    //     $formIdentifier = $formID;


    //     if($formIdentifier === null || $formIdentifier === '') {

    //       $formIdentifier = $formName;

    //     }


    //     if($formIdentifier === null || $formIdentifier === '') {

    //       $formIdentifier = 'form';

    //     }


    //     $formIdentifier = preg_replace(

    //       '/[^a-zA-Z0-9\-_]/',

    //       '-',

    //       (string) $formIdentifier

    //     );


    //     $formElementID = 'automator-form-' .
    //                      trim($formIdentifier, '-') .
    //                      '-' .
    //                      uniqid();

    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Abertura do formulário
    //   |--------------------------------------------------------------------------
    //   */

    //   $html = '<form';


    //   if($formElementID !== '') {

    //     $html .= ' id="' . e($formElementID) . '"';

    //   }


    //   $html .= ' class="row"';

    //   $html .= ' method="' . e($formMethod) . '"';

    //   $html .= ' action="' . e($formAction) . '"';

    //   $html .= ' data-submit="false"';

    //   $html .= ' data-form-validate="' . (

    //     self::isTruthy($formValidate)

    //       ? 'true'

    //       : 'false'

    //   ) . '"';

    //   $html .= '>';


    //   /*
    //   |--------------------------------------------------------------------------
    //   | ID do formulário no Automator
    //   |--------------------------------------------------------------------------
    //   */

    //   $html .= '<input';
    //   $html .= ' type="hidden"';
    //   $html .= ' name="automatorFormID"';
    //   $html .= ' value="' . e($formID) . '"';
    //   $html .= ' />';


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Renderiza os campos
    //   |--------------------------------------------------------------------------
    //   */

    //   foreach($fields as $field) {


    //     if(!is_array($field)) {

    //       continue;

    //     }


    //     $field['value'] = self::getFieldValue($field, $values);


    //     $_field = [

    //       'form'       => $form,
    //       'field'      => $field,
    //       'fields'     => $fields,
    //       'props'      => self::normalizeFieldPropsForRender($field),
    //       'attrs'      => $field['attrs'] ?? [],
    //       'config'     => $field['config'] ?? [],
    //       'field_type' => $field['field_type'] ?? [],
    //       'values'     => $values,
    //       'render'     => 'formulario',

    //     ];


    //     if(!isset($_field['props']['wrapper_class'])) {

    //       $_field['props']['wrapper_class'] = 'col-12';

    //     }


    //     $fieldHTML = self::renderFormField($_field);


    //     $field['html'] = $fieldHTML;


    //     $renderedFields[] = $field;


    //     $html .= $fieldHTML;


    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Botões para formulário não modal
    //   |--------------------------------------------------------------------------
    //   |
    //   | Mantém o comportamento atual dos formulários modais.
    //   |
    //   | Somente quando tbl_sys_form_modal for 0 ou false os botões são
    //   | acrescentados ao final do formulário.
    //   |
    //   */

    //   if(!$isModal) {

    //     $html .= self::renderFormActions(

    //       $form,

    //       $formElementID

    //     );

    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Fechamento do formulário
    //   |--------------------------------------------------------------------------
    //   */

    //   $html .= '</form>';


    //   return [

    //     'fields'          => $renderedFields,
    //     'html'            => $html,
    //     'form_element_id' => $formElementID,

    //   ];


    // }

    /*
    |--------------------------------------------------------------------------
    | Renderiza todos os campos de um formulário
    |--------------------------------------------------------------------------
    */

    // public static function renderFormFields($formData = [], $values = []) {


    //   $fields = $formData['fields'] ?? [];

    //   $renderedFields = [];
    //   // $formData['form']['tbl_sys_form_modal'] == 0 || $formData['form']['tbl_sys_form_modal'] == false
    //   $html = '<form class="row" method="' . ( ($formData['form']['tbl_sys_form_method']) ? ( ($formData['form']['tbl_sys_form_method'] != '') ? $formData['form']['tbl_sys_form_method'] : '' ) : '' ) . '" action="' . ( ($formData['form']['tbl_sys_form_route']) ? ( ($formData['form']['tbl_sys_form_route'] != '') ? SysAutomator::SysAutomatorGetRouteLinkByName($formData['form']['tbl_sys_form_route']) : '' ) : '' ) . '" data-submit="false" data-form-validate="' . ( ( ($formData['form']['tbl_sys_form_validate'] == true) || ($formData['form']['tbl_sys_form_validate'] == 1) ) ? 'true' : 'false' ) . '">';

    //   $html .= '<input type="hidden" name="automatorFormID" value="' . $formData['form']['tbl_sys_form_ID'] . '" />';


    //   foreach($fields as $field) {


    //     $field['value'] = self::getFieldValue($field, $values);

    //     // var_dump($field['config']);

    //     $_field = [

    //       'form'       => $formData['form'] ?? [],
    //       'field'      => $field,
    //       'fields'     => $fields,
    //       'props'      => self::normalizeFieldPropsForRender($field),
    //       'attrs'      => $field['attrs'] ?? [],
    //       'config'     => $field['config'] ?? [],
    //       'field_type' => $field['field_type'] ?? [],
    //       'values'     => $values,
    //       'render'     => 'formulario',

    //     ];


    //     if(!isset($_field['props']['wrapper_class'])) {

    //       $_field['props']['wrapper_class'] = 'col-12';

    //     }


    //     $fieldHTML = self::renderFormField($_field);

    //     $field['html'] = $fieldHTML;

    //     $renderedFields[] = $field;

    //     $html .= $fieldHTML;


    //   }


    //   if($formData['form']['tbl_sys_form_modal'] == 0 || $formData['form']['tbl_sys_form_modal'] == false) {
          
    //     $html .= '<div class="col-12">' . "\n";
          
    //       $html .= '<div class="row">' . "\n";

            
    //         $html .= '<div class="col-12 order-2 col-md-6 order-md-1 mb-3">' . "\n";

    //           $html .= '<button type="reset" class="btn btn-secondary w-100 text-center">' . $formData['form']['tbl_sys_form_cancel'] . '</button>' . "\n";

    //         $html .= '</div>' . "\n";


    //         $html .= '<div class="col-12 order-1 col-md-6 order-md-2 mb-3">' . "\n";
              
    //           $html .= '<button type="submit" class="btn btn-primary w-100 text-center">' . $formData['form']['tbl_sys_form_submit'] . '</button>' . "\n";

    //         $html .= '</div>' . "\n";
            

    //       $html .= '</div>' . "\n";

    //     $html .= '</div>' . "\n";

    //   }
    //   $html .= '</form>';


    //   return [

    //     'fields' => $renderedFields,
    //     'html'   => $html,

    //   ];


    // }



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
    | Normaliza argumentos de uma coluna durante a paginação
    |--------------------------------------------------------------------------
    |
    | As configurações persistidas pelo editor podem conter:
    |
    | attrs.configs
    | attrs.attributes
    | props relationais no formato plano
    | props relationais no formato relation.*
    |
    | Esta função separa configurações internas de atributos HTML e mantém
    | compatibilidade com todos os formatos já utilizados pelo sistema.
    |
    */

    private static function normalizePaginationColumnRuntimeArgs($args = []) {


      /*
      |--------------------------------------------------------------------------
      | Container principal
      |--------------------------------------------------------------------------
      */

      if(is_object($args)) {

        $args = (array) $args;

      }


      if(!is_array($args)) {

        $args = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Estrutura padrão
      |--------------------------------------------------------------------------
      */

      $args['column']     = $args['column'] ?? [];
      $args['props']      = $args['props'] ?? [];
      $args['attrs']      = $args['attrs'] ?? [];
      $args['config']     = $args['config'] ?? [];
      $args['field_type'] = $args['field_type'] ?? [];


      /*
      |--------------------------------------------------------------------------
      | Normaliza coluna
      |--------------------------------------------------------------------------
      */

      if(is_object($args['column'])) {

        $args['column'] = (array) $args['column'];

      }


      if(!is_array($args['column'])) {

        $args['column'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Recupera dados diretamente da coluna quando necessário
      |--------------------------------------------------------------------------
      */

      if(

        count($args['props']) <= 0 &&

        isset($args['column']['props'])

      ) {

        $args['props'] = $args['column']['props'];

      }


      if(

        count($args['attrs']) <= 0 &&

        isset($args['column']['attrs'])

      ) {

        $args['attrs'] = $args['column']['attrs'];

      }


      if(

        count($args['config']) <= 0 &&

        isset($args['column']['config'])

      ) {

        $args['config'] = $args['column']['config'];

      }


      if(

        count($args['field_type']) <= 0 &&

        isset($args['column']['field_type'])

      ) {

        $args['field_type'] = $args['column']['field_type'];

      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza propriedades
      |--------------------------------------------------------------------------
      */

      if(is_object($args['props'])) {

        $args['props'] = (array) $args['props'];

      }


      if(!is_array($args['props'])) {


        if(

          is_string($args['props']) &&

          trim($args['props']) !== ''

        ) {

          $decodedProps = json_decode(

            $args['props'],

            true

          );


          $args['props'] = is_array($decodedProps)

            ? $decodedProps

            : [];

        } else {

          $args['props'] = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza atributos
      |--------------------------------------------------------------------------
      */

      if(is_object($args['attrs'])) {

        $args['attrs'] = (array) $args['attrs'];

      }


      if(!is_array($args['attrs'])) {


        if(

          is_string($args['attrs']) &&

          trim($args['attrs']) !== ''

        ) {

          $decodedAttrs = json_decode(

            $args['attrs'],

            true

          );


          $args['attrs'] = is_array($decodedAttrs)

            ? $decodedAttrs

            : [];

        } else {

          $args['attrs'] = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza configurações
      |--------------------------------------------------------------------------
      */

      if(is_object($args['config'])) {

        $args['config'] = (array) $args['config'];

      }


      if(!is_array($args['config'])) {


        if(

          is_string($args['config']) &&

          trim($args['config']) !== ''

        ) {

          $decodedConfig = json_decode(

            $args['config'],

            true

          );


          $args['config'] = is_array($decodedConfig)

            ? $decodedConfig

            : [];

        } else {

          $args['config'] = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza tipo de campo
      |--------------------------------------------------------------------------
      */

      if(is_object($args['field_type'])) {

        $args['field_type'] = (array) $args['field_type'];

      }


      if(!is_array($args['field_type'])) {

        $args['field_type'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Separa attrs.configs dos atributos HTML
      |--------------------------------------------------------------------------
      |
      | O editor salva configurações da coluna desta forma:
      |
      | {
      |   "configs": {
      |     "size-type": "auto",
      |     "size-value": null
      |   }
      | }
      |
      | O conteúdo de configs não pode ser enviado para renderAttrs().
      |
      */

      if(isset($args['attrs']['configs'])) {


        $attrsConfigs = $args['attrs']['configs'];


        if(is_object($attrsConfigs)) {

          $attrsConfigs = (array) $attrsConfigs;

        }


        if(is_array($attrsConfigs)) {


          if(

            !isset($args['config']['configs']) ||

            !is_array($args['config']['configs'])

          ) {

            $args['config']['configs'] = [];

          }


          $args['config']['configs'] = array_replace_recursive(

            $args['config']['configs'],

            $attrsConfigs

          );


          /*
          |--------------------------------------------------------------------------
          | Mantém também acesso direto para códigos antigos
          |--------------------------------------------------------------------------
          */

          foreach($attrsConfigs as $configName => $configValue) {

            if(!array_key_exists($configName, $args['config'])) {

              $args['config'][$configName] = $configValue;

            }

          }


        }


        unset($args['attrs']['configs']);

      }


      /*
      |--------------------------------------------------------------------------
      | Suporte para attrs.attributes
      |--------------------------------------------------------------------------
      |
      | Alguns registros podem separar atributos HTML reais dentro de:
      |
      | attrs.attributes
      |
      */

      if(isset($args['attrs']['attributes'])) {


        $htmlAttributes = $args['attrs']['attributes'];


        if(is_object($htmlAttributes)) {

          $htmlAttributes = (array) $htmlAttributes;

        }


        unset($args['attrs']['attributes']);


        if(is_array($htmlAttributes)) {

          $args['attrs'] = array_replace(

            $args['attrs'],

            $htmlAttributes

          );

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Descarta containers internos que não são atributos HTML
      |--------------------------------------------------------------------------
      */

      $internalAttributeKeys = [

        'config',
        'settings',
        'pagination',
        'responsive',
        'access',
        'user_types',

      ];


      foreach($internalAttributeKeys as $internalAttributeKey) {

        if(

          isset($args['attrs'][$internalAttributeKey]) &&

          (

            is_array($args['attrs'][$internalAttributeKey]) ||

            is_object($args['attrs'][$internalAttributeKey])

          )

        ) {

          unset(

            $args['attrs'][$internalAttributeKey]

          );

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Resolve nome do tipo de campo
      |--------------------------------------------------------------------------
      */

      $fieldTypeName = strtolower(

        self::normalizeRelationScalarValue(

          $args['field_type']['tbl_sys_field_type_name']

          ?? '',

          [

            'tbl_sys_field_type_name',
            'type',
            'name',
            'value',

          ],

          ''

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Normaliza propriedades relacionais
      |--------------------------------------------------------------------------
      */

      if(

        $fieldTypeName === 'relation' ||

        $fieldTypeName === 'relations'

      ) {

        $args['props'] = self::normalizeRelationFieldProps(

          $args['props']

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Atualiza também a estrutura da coluna
      |--------------------------------------------------------------------------
      */

      $args['column']['props']      = $args['props'];
      $args['column']['attrs']      = $args['attrs'];
      $args['column']['config']     = $args['config'];
      $args['column']['field_type'] = $args['field_type'];


      return $args;


    }



    /*
    |--------------------------------------------------------------------------
    | Renderiza coluna de paginação
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Renderiza coluna de paginação
    |--------------------------------------------------------------------------
    */

    public static function renderPaginationColumn($columnType = 'tbody', $args = []) {


      /*
      |--------------------------------------------------------------------------
      | Normaliza os argumentos recebidos
      |--------------------------------------------------------------------------
      */

      $args = self::normalizePaginationColumnRuntimeArgs(

        $args

      );


      $args['render'] = 'paginacao';

      $args['columnType'] = $columnType;


      /*
      |--------------------------------------------------------------------------
      | Tipo do campo
      |--------------------------------------------------------------------------
      */

      $fieldType =

        $args['field_type']

        ?? $args['column']['field_type']

        ?? [];


      if(is_object($fieldType)) {

        $fieldType = (array) $fieldType;

      }


      if(!is_array($fieldType)) {

        $fieldType = [];

      }


      $args['field_type'] = $fieldType;

      $args['column']['field_type'] = $fieldType;


      /*
      |--------------------------------------------------------------------------
      | Resolve a classe responsável pela renderização
      |--------------------------------------------------------------------------
      */

      $fieldClass = self::resolveFieldClass(

        $fieldType

      );


      if($fieldClass === null) {

        return '';

      }


      if(!method_exists($fieldClass, 'paginationColumn')) {

        return '';

      }


      /*
      |--------------------------------------------------------------------------
      | Renderiza a coluna
      |--------------------------------------------------------------------------
      */

      return $fieldClass::paginationColumn(

        $args

      );


    }

    // public static function renderPaginationColumn($columnType = 'tbody', $args = []) {


    //   $args['render']     = 'paginacao';
    //   $args['columnType'] = $columnType;


    //   $fieldType = $args['column']['field_type'] ?? [];

    //   $fieldClass = self::resolveFieldClass($fieldType);


    //   if($fieldClass === null) {

    //     return '';

    //   }


    //   if(!method_exists($fieldClass, 'paginationColumn')) {

    //     return '';

    //   }


    //   return $fieldClass::paginationColumn($args);


    // }



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


      /*
      |--------------------------------------------------------------------------
      | Normaliza o container principal
      |--------------------------------------------------------------------------
      */

      if(is_object($args)) {

        $args = (array) $args;

      }


      if(!is_array($args)) {

        $args = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Estrutura padrão
      |--------------------------------------------------------------------------
      */

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


      /*
      |--------------------------------------------------------------------------
      | Normaliza form
      |--------------------------------------------------------------------------
      */

      if(is_object($args['form'])) {

        $args['form'] = (array) $args['form'];

      }


      if(!is_array($args['form'])) {

        $args['form'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza field
      |--------------------------------------------------------------------------
      */

      if(is_object($args['field'])) {

        $args['field'] = (array) $args['field'];

      }


      if(!is_array($args['field'])) {

        $args['field'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza fields
      |--------------------------------------------------------------------------
      */

      if(is_object($args['fields'])) {

        $args['fields'] = (array) $args['fields'];

      }


      if(!is_array($args['fields'])) {

        $args['fields'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza values
      |--------------------------------------------------------------------------
      */

      if(is_object($args['values'])) {

        $args['values'] = (array) $args['values'];

      }


      if(!is_array($args['values'])) {

        $args['values'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza config
      |--------------------------------------------------------------------------
      */

      if(is_object($args['config'])) {

        $args['config'] = (array) $args['config'];

      }


      if(!is_array($args['config'])) {


        if(

          is_string($args['config']) &&

          trim($args['config']) !== ''

        ) {

          $decodedConfig = json_decode(

            $args['config'],

            true

          );


          $args['config'] = is_array($decodedConfig)

            ? $decodedConfig

            : [];

        } else {

          $args['config'] = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza props
      |--------------------------------------------------------------------------
      */

      if(is_object($args['props'])) {

        $args['props'] = (array) $args['props'];

      }


      if(!is_array($args['props'])) {


        if(

          is_string($args['props']) &&

          trim($args['props']) !== ''

        ) {

          $decodedProps = json_decode(

            $args['props'],

            true

          );


          $args['props'] = is_array($decodedProps)

            ? $decodedProps

            : [];

        } else {

          $args['props'] = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza attrs
      |--------------------------------------------------------------------------
      */

      if(is_object($args['attrs'])) {

        $args['attrs'] = (array) $args['attrs'];

      }


      if(!is_array($args['attrs'])) {


        if(

          is_string($args['attrs']) &&

          trim($args['attrs']) !== ''

        ) {

          $decodedAttrs = json_decode(

            $args['attrs'],

            true

          );


          $args['attrs'] = is_array($decodedAttrs)

            ? $decodedAttrs

            : [];

        } else {

          $args['attrs'] = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza field_type principal
      |--------------------------------------------------------------------------
      */

      if(is_object($args['field_type'])) {

        $args['field_type'] = (array) $args['field_type'];

      }


      if(!is_array($args['field_type'])) {

        $args['field_type'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza field_type interno do field
      |--------------------------------------------------------------------------
      */

      if(

        isset($args['field']['field_type']) &&

        is_object($args['field']['field_type'])

      ) {

        $args['field']['field_type'] =

          (array) $args['field']['field_type'];

      }


      if(

        isset($args['field']['field_type']) &&

        !is_array($args['field']['field_type'])

      ) {

        $args['field']['field_type'] = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Resolve o nome do tipo de campo com segurança
      |--------------------------------------------------------------------------
      */

      $fieldTypeNameValue = '';


      if(

        array_key_exists(

          'tbl_sys_field_type_name',

          $args['field_type']

        )

      ) {

        $fieldTypeNameValue =

          $args['field_type']['tbl_sys_field_type_name'];

      } elseif(

        isset($args['field']['field_type']) &&

        is_array($args['field']['field_type']) &&

        array_key_exists(

          'tbl_sys_field_type_name',

          $args['field']['field_type']

        )

      ) {

        $fieldTypeNameValue =

          $args['field']['field_type']['tbl_sys_field_type_name'];

      } elseif(

        array_key_exists(

          'tbl_sys_field_type_name',

          $args['field']

        )

      ) {

        $fieldTypeNameValue =

          $args['field']['tbl_sys_field_type_name'];

      }


      $fieldTypeName = strtolower(

        self::normalizeRelationScalarValue(

          $fieldTypeNameValue,

          [

            'tbl_sys_field_type_name',

            'type',

            'name',

            'value',

            'current',

            'default',

          ],

          ''

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Normalização específica de campos relacionais
      |--------------------------------------------------------------------------
      */

      if(

        $fieldTypeName === 'relation' ||

        $fieldTypeName === 'relations'

      ) {

        $args['props'] = self::normalizeRelationFieldProps(

          $args['props']

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Renderização de formulário
      |--------------------------------------------------------------------------
      */

      if($args['render'] === 'formulario') {


        $field = $args['field'];


        $fieldID =

          $field['tbl_sys_forms_field_ID']

          ?? uniqid();


        $fieldNameValue =

          $field['tbl_sys_forms_field_name']

          ?? $field['field_name']

          ?? '';


        $fieldName = self::normalizeRelationScalarValue(

          $fieldNameValue,

          [

            'tbl_sys_forms_field_name',

            'field_name',

            'name',

            'value',

          ],

          ''

        );


        /*
        |--------------------------------------------------------------------------
        | ID do campo
        |--------------------------------------------------------------------------
        */

        $fieldIDValue =

          $field['field_id']

          ?? ('field_' . $fieldID);


        $args['field_id'] =

          self::normalizeRelationScalarValue(

            $fieldIDValue,

            [

              'field_id',

              'id',

              'value',

            ],

            'field_' . $fieldID

          );


        /*
        |--------------------------------------------------------------------------
        | Nome do campo
        |--------------------------------------------------------------------------
        */

        $args['field_name'] =

          self::normalizeRelationScalarValue(

            $field['field_name'] ?? $fieldName,

            [

              'field_name',

              'name',

              'value',

            ],

            $fieldName

          );


        /*
        |--------------------------------------------------------------------------
        | Label do campo
        |--------------------------------------------------------------------------
        */

        $fieldLabelValue =

          $field['tbl_sys_forms_field_title']

          ?? $field['tbl_sys_forms_field_label']

          ?? '';


        $args['field_label'] =

          self::normalizeRelationScalarValue(

            $fieldLabelValue,

            [

              'tbl_sys_forms_field_title',

              'tbl_sys_forms_field_label',

              'label',

              'title',

              'value',

            ],

            ''

          );


        /*
        |--------------------------------------------------------------------------
        | Valor do campo
        |--------------------------------------------------------------------------
        |
        | O valor não é convertido para string, pois checkbox, relation e campos
        | múltiplos podem utilizar arrays.
        |
        */

        $args['field_value'] =

          array_key_exists('value', $field)

            ? $field['value']

            : self::getFieldValue(

                $field,

                $args['values']

              );


        /*
        |--------------------------------------------------------------------------
        | Campo obrigatório
        |--------------------------------------------------------------------------
        */

        $args['field_required'] = self::isTruthy(

          $field['tbl_sys_forms_field_required']

          ?? false

        );


        /*
        |--------------------------------------------------------------------------
        | Classes adicionais
        |--------------------------------------------------------------------------
        */

        $args['field_class'] =

          self::normalizeRelationScalarValue(

            $field['tbl_sys_forms_field_class']

            ?? '',

            [

              'tbl_sys_forms_field_class',

              'class',

              'value',

            ],

            ''

          );


        /*
        |--------------------------------------------------------------------------
        | Seletor do campo
        |--------------------------------------------------------------------------
        */

        $defaultFieldSelector =

          ($fieldName !== '')

            ? '[name="' . $fieldName . '"]'

            : '';


        $args['field_selector'] =

          self::normalizeRelationScalarValue(

            $field['field_selector']

            ?? $defaultFieldSelector,

            [

              'field_selector',

              'selector',

              'value',

            ],

            $defaultFieldSelector

          );


        /*
        |--------------------------------------------------------------------------
        | Atributos booleanos provenientes de props
        |--------------------------------------------------------------------------
        |
        | attrs continua tendo prioridade.
        |
        */

        if(

          !array_key_exists('disabled', $args['attrs']) &&

          self::isTruthy(

            $args['props']['disabled']

            ?? false

          )

        ) {

          $args['attrs']['disabled'] = true;

        }


        if(

          !array_key_exists('readonly', $args['attrs']) &&

          (

            self::isTruthy(

              $args['props']['readonly']

              ?? false

            ) ||

            self::isTruthy(

              $args['props']['readonlue']

              ?? false

            )

          )

        ) {

          $args['attrs']['readonly'] = true;

        }


        /*
        |--------------------------------------------------------------------------
        | HTML dos atributos
        |--------------------------------------------------------------------------
        */

        $args['field_attrs'] = self::renderAttrs(

          $args['attrs']

        );


      }


      /*
      |--------------------------------------------------------------------------
      | Renderização de paginação
      |--------------------------------------------------------------------------
      */

      if($args['render'] === 'paginacao') {


        if(is_object($args['column'])) {

          $args['column'] = (array) $args['column'];

        }


        if(!is_array($args['column'])) {

          $args['column'] = [];

        }


        $column = $args['column'];


        /*
        |--------------------------------------------------------------------------
        | Nome da coluna
        |--------------------------------------------------------------------------
        */

        $columnNameValue =

          $column['column_name']

          ?? $column['tbl_sys_paginations_col_name']

          ?? $column['tbl_sys_paginations_col_field']

          ?? $column['tbl_sys_paginations_col_column']

          ?? '';


        $args['column_name'] =

          self::normalizeRelationScalarValue(

            $columnNameValue,

            [

              'column_name',

              'tbl_sys_paginations_col_name',

              'tbl_sys_paginations_col_field',

              'tbl_sys_paginations_col_column',

              'column',

              'field',

              'name',

              'value',

            ],

            ''

          );


        /*
        |--------------------------------------------------------------------------
        | Label da coluna
        |--------------------------------------------------------------------------
        */

        $columnLabelValue =

          $column['label']

          ?? $column['tbl_sys_paginations_col_title']

          ?? $column['tbl_sys_paginations_col_label']

          ?? $args['column_name'];


        $args['column_label'] =

          self::normalizeRelationScalarValue(

            $columnLabelValue,

            [

              'label',

              'tbl_sys_paginations_col_title',

              'tbl_sys_paginations_col_label',

              'title',

              'name',

              'value',

            ],

            $args['column_name']

          );


        /*
        |--------------------------------------------------------------------------
        | Valor da coluna
        |--------------------------------------------------------------------------
        */

        $args['column_value'] = self::getColumnValue(

          $args['item'],

          $args['column_name']

        );


        /*
        |--------------------------------------------------------------------------
        | Substituições de valores
        |--------------------------------------------------------------------------
        */

        if(

          isset($column['replaced']) &&

          is_object($column['replaced'])

        ) {

          $column['replaced'] =

            (array) $column['replaced'];

        }


        if(

          isset($column['replaced']) &&

          is_array($column['replaced']) &&

          (

            is_string($args['column_value']) ||

            is_int($args['column_value']) ||

            is_float($args['column_value']) ||

            is_bool($args['column_value']) ||

            $args['column_value'] === null

          ) &&

          array_key_exists(

            $args['column_value'],

            $column['replaced']

          )

        ) {

          $args['column_value'] =

            $column['replaced'][$args['column_value']];

        }


        /*
        |--------------------------------------------------------------------------
        | HTML dos atributos da coluna
        |--------------------------------------------------------------------------
        */

        $args['column_attrs'] = self::renderAttrs(

          $args['attrs']

        );


      }


      return $args;


    }



    /*
    |--------------------------------------------------------------------------
    | Normaliza argumentos para as views
    |--------------------------------------------------------------------------
    */

    // public static function normalizeArgs($args = []) {


    //   $args['form']       = $args['form'] ?? [];
    //   $args['field']      = $args['field'] ?? [];
    //   $args['fields']     = $args['fields'] ?? [];
    //   $args['props']      = $args['props'] ?? [];
    //   $args['attrs']      = $args['attrs'] ?? [];
    //   $args['config']     = $args['config'] ?? [];
    //   $args['field_type'] = $args['field_type'] ?? [];
    //   $args['values']     = $args['values'] ?? [];
    //   $args['render']     = $args['render'] ?? 'formulario';

    //   $args['pagination'] = $args['pagination'] ?? [];
    //   $args['column']     = $args['column'] ?? [];
    //   $args['columns']    = $args['columns'] ?? [];
    //   $args['item']       = $args['item'] ?? null;
    //   $args['request']    = $args['request'] ?? [];
    //   $args['columnType'] = $args['columnType'] ?? null;


    //   if(!is_array($args['props'])) {

    //     if($args['props'] != '') {

    //       $decodedProps = json_decode($args['props'], true);

    //       $args['props'] = is_array($decodedProps)
    //         ? $decodedProps
    //         : [];

    //     } else {

    //       $args['props'] = [];

    //     }

    //   }


    //   if(!is_array($args['attrs'])) {

    //     if($args['attrs'] != '') {

    //       $decodedAttrs = json_decode($args['attrs'], true);

    //       $args['attrs'] = is_array($decodedAttrs)
    //         ? $decodedAttrs
    //         : [];

    //     } else {

    //       $args['attrs'] = [];

    //     }

    //   }


    //   $fieldTypeName = strtolower((string) (
    //     $args['field_type']['tbl_sys_field_type_name']
    //     ?? $args['field']['field_type']['tbl_sys_field_type_name']
    //     ?? $args['field']['tbl_sys_field_type_name']
    //     ?? ''
    //   ));


    //   if($fieldTypeName == 'relation' || $fieldTypeName == 'relations') {

    //     $args['props'] = self::normalizeRelationFieldProps($args['props']);

    //   }


    //   if($args['render'] == 'formulario') {

    //     $field = $args['field'];

    //     $fieldID = $field['tbl_sys_forms_field_ID'] ?? uniqid();

    //     $fieldName = $field['tbl_sys_forms_field_name'] ?? '';

    //     $args['field_id'] = $field['field_id'] ?? ('field_' . $fieldID);

    //     $args['field_name'] = $field['field_name'] ?? $fieldName;

    //     $args['field_label'] = $field['tbl_sys_forms_field_title'] 
    //       ?? $field['tbl_sys_forms_field_label'] 
    //       ?? '';

    //     $args['field_value'] = $field['value'] ?? self::getFieldValue($field, $args['values']);

    //     $args['field_required'] = self::isTruthy($field['tbl_sys_forms_field_required'] ?? false);

    //     $args['field_class'] = $field['tbl_sys_forms_field_class'] ?? '';

    //     $args['field_selector'] = $field['field_selector'] ?? (($fieldName != '') ? '[name="' . $fieldName . '"]' : '');

    //     if(!isset($args['attrs']['disabled']) && self::isTruthy($args['props']['disabled'] ?? false)) {

    //       $args['attrs']['disabled'] = true;

    //     }

    //     if(
    //       !isset($args['attrs']['readonly']) &&
    //       (
    //         self::isTruthy($args['props']['readonly'] ?? false) ||
    //         self::isTruthy($args['props']['readonlue'] ?? false)
    //       )
    //     ) {

    //       $args['attrs']['readonly'] = true;

    //     }

    //     $args['field_attrs'] = self::renderAttrs($args['attrs']);

    //   }


    //   if($args['render'] == 'paginacao') {

    //     $column = $args['column'];

    //     $args['column_name'] = $column['column_name'] 
    //       ?? $column['tbl_sys_paginations_col_name'] 
    //       ?? $column['tbl_sys_paginations_col_field'] 
    //       ?? $column['tbl_sys_paginations_col_column'] 
    //       ?? '';

    //     $args['column_label'] = $column['label']
    //       ?? $column['tbl_sys_paginations_col_title']
    //       ?? $column['tbl_sys_paginations_col_label']
    //       ?? $args['column_name'];

    //     $args['column_value'] = self::getColumnValue($args['item'], $args['column_name']);

    //     if(isset($column['replaced']) && is_array($column['replaced']) && array_key_exists($args['column_value'], $column['replaced'])) {

    //       $args['column_value'] = $column['replaced'][$args['column_value']];

    //     }

    //     $args['column_attrs'] = self::renderAttrs($args['attrs']);

    //   }


    //   return $args;


    // }
    // public static function normalizeArgs($args = []) {


    //   $args['form']       = $args['form'] ?? [];
    //   $args['field']      = $args['field'] ?? [];
    //   $args['fields']     = $args['fields'] ?? [];
    //   $args['props']      = $args['props'] ?? [];
    //   $args['attrs']      = $args['attrs'] ?? [];
    //   $args['config']     = $args['config'] ?? [];
    //   $args['field_type'] = $args['field_type'] ?? [];
    //   $args['values']     = $args['values'] ?? [];
    //   $args['render']     = $args['render'] ?? 'formulario';

    //   $args['pagination'] = $args['pagination'] ?? [];
    //   $args['column']     = $args['column'] ?? [];
    //   $args['columns']    = $args['columns'] ?? [];
    //   $args['item']       = $args['item'] ?? null;
    //   $args['request']    = $args['request'] ?? [];
    //   $args['columnType'] = $args['columnType'] ?? null;


    //   if($args['render'] == 'formulario') {

    //     $field = $args['field'];

    //     $fieldID = $field['tbl_sys_forms_field_ID'] ?? uniqid();

    //     $fieldName = $field['tbl_sys_forms_field_name'] ?? '';

    //     $args['field_id'] = $field['field_id'] ?? ('field_' . $fieldID);

    //     $args['field_name'] = $field['field_name'] ?? $fieldName;

    //     $args['field_label'] = $field['tbl_sys_forms_field_title'] 
    //       ?? $field['tbl_sys_forms_field_label'] 
    //       ?? '';

    //     $args['field_value'] = $field['value'] ?? self::getFieldValue($field, $args['values']);

    //     $args['field_required'] = self::isTruthy($field['tbl_sys_forms_field_required'] ?? false);

    //     $args['field_class'] = $field['tbl_sys_forms_field_class'] ?? '';

    //     $args['field_selector'] = $field['field_selector'] ?? (($fieldName != '') ? '[name="' . $fieldName . '"]' : '');

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Atributos booleanos vindos de props
    //     |--------------------------------------------------------------------------
    //     |
    //     | Permite usar disabled/readonly diretamente em tbl_sys_forms_field_props
    //     | ou em tbl_sys_forms_field_attrs. O attrs continua tendo prioridade,
    //     | mas quando não existir, a propriedade é convertida para atributo HTML.
    //     |
    //     */

    //     if(!isset($args['attrs']['disabled']) && self::isTruthy($args['props']['disabled'] ?? false)) {

    //       $args['attrs']['disabled'] = true;

    //     }

    //     if(
    //       !isset($args['attrs']['readonly']) &&
    //       (
    //         self::isTruthy($args['props']['readonly'] ?? false) ||
    //         self::isTruthy($args['props']['readonlue'] ?? false)
    //       )
    //     ) {

    //       $args['attrs']['readonly'] = true;

    //     }

    //     $args['field_attrs'] = self::renderAttrs($args['attrs']);

    //   }


    //   if($args['render'] == 'paginacao') {

    //     $column = $args['column'];

    //     $args['column_name'] = $column['column_name'] 
    //       ?? $column['tbl_sys_paginations_col_name'] 
    //       ?? $column['tbl_sys_paginations_col_field'] 
    //       ?? $column['tbl_sys_paginations_col_column'] 
    //       ?? '';

    //     $args['column_label'] = $column['label']
    //       ?? $column['tbl_sys_paginations_col_title']
    //       ?? $column['tbl_sys_paginations_col_label']
    //       ?? $args['column_name'];

    //     $args['column_value'] = self::getColumnValue($args['item'], $args['column_name']);

    //     if(isset($column['replaced']) && is_array($column['replaced']) && array_key_exists($args['column_value'], $column['replaced'])) {

    //       $args['column_value'] = $column['replaced'][$args['column_value']];

    //     }

    //     $args['column_attrs'] = self::renderAttrs($args['attrs']);

    //   }


    //   return $args;


    // }



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

    /*
    |--------------------------------------------------------------------------
    | Renderiza atributos HTML
    |--------------------------------------------------------------------------
    */

    public static function renderAttrs($attrs = []) {


      /*
      |--------------------------------------------------------------------------
      | Normaliza o container
      |--------------------------------------------------------------------------
      */

      if(is_object($attrs)) {

        $attrs = (array) $attrs;

      }


      if(!is_array($attrs) || count($attrs) <= 0) {

        return '';

      }


      $html = '';


      foreach($attrs as $attrName => $attrValue) {


        /*
        |--------------------------------------------------------------------------
        | Nome inválido
        |--------------------------------------------------------------------------
        */

        if(

          $attrName === null ||

          trim((string) $attrName) === ''

        ) {

          continue;

        }


        $attrName = trim(

          (string) $attrName

        );


        /*
        |--------------------------------------------------------------------------
        | Containers internos não são atributos HTML
        |--------------------------------------------------------------------------
        */

        if(

          is_array($attrValue) ||

          (

            is_object($attrValue) &&

            !method_exists($attrValue, '__toString')

          )

        ) {

          continue;

        }


        /*
        |--------------------------------------------------------------------------
        | Atributos booleanos
        |--------------------------------------------------------------------------
        */

        if($attrValue === true) {

          $html .= ' ' . e($attrName);

          continue;

        }


        if(

          $attrValue === false ||

          $attrValue === null

        ) {

          continue;

        }


        /*
        |--------------------------------------------------------------------------
        | Objetos convertíveis em string
        |--------------------------------------------------------------------------
        */

        if(

          is_object($attrValue) &&

          method_exists($attrValue, '__toString')

        ) {

          $attrValue = (string) $attrValue;

        }


        /*
        |--------------------------------------------------------------------------
        | Aceita apenas valores escalares
        |--------------------------------------------------------------------------
        */

        if(!is_scalar($attrValue)) {

          continue;

        }


        $html .=

          ' ' .

          e($attrName) .

          '="' .

          e((string) $attrValue) .

          '"';


      }


      return $html;


    }

    // public static function renderAttrs($attrs = []) {


    //   if(!is_array($attrs) || count($attrs) <= 0) {

    //     return '';

    //   }


    //   $html = '';


    //   foreach($attrs as $attrName => $attrValue) {


    //     if($attrName === null || $attrName === '') {

    //       continue;

    //     }


    //     if($attrValue === true) {

    //       $html .= ' ' . e($attrName);

    //     } else if($attrValue !== false && $attrValue !== null) {

    //       $html .= ' ' . e($attrName) . '="' . e($attrValue) . '"';

    //     }


    //   }


    //   return $html;


    // }



    /*
    |--------------------------------------------------------------------------
    | Boolean helper
    |--------------------------------------------------------------------------
    */

    public static function isTruthy($value) {


      return ($value === true || $value === 1 || $value === '1' || $value === 'true');


    }


    public static function renderViewEditorField($field, $data = [], $layout = true) {


      $query = SysFieldType::where('tbl_sys_field_type_ID', $field);


      if($layout !== null) {

        $query->where('tbl_sys_field_type_layout', $layout);

      }


      $type = $query->first();


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
        ? json_decode($dados['tbl_sys_field_type_configs'], true)
        : [];


      if(!is_array($configs)) {

        $configs = [];

      }


      $pagination = (
        isset($dados['tbl_sys_field_type_pagination']) &&
        $dados['tbl_sys_field_type_pagination'] !== null &&
        trim((string) $dados['tbl_sys_field_type_pagination']) != ''
      )
        ? json_decode($dados['tbl_sys_field_type_pagination'], true)
        : [];


      if(!is_array($pagination)) {

        $pagination = [];

      }


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


      foreach($blocks as $blockKey => $blockArgs) {


        if(!isset($blockArgs['fields']) || !is_array($blockArgs['fields'])) {

          continue;

        }


        foreach($blockArgs['fields'] as $blockFieldsKey => $blockFieldsArgs) {


          if(is_array($vars) && count($vars) >= 1 && array_key_exists($blockFieldsKey, $vars)) {


            if(isset($vars[$blockFieldsKey]['type']) && $vars[$blockFieldsKey]['type'] == 'relation') {


              $varsQuery = DB::table($vars[$blockFieldsKey]['table'])
                ->get()
                ->toArray();


              if(is_array($varsQuery) && count($varsQuery) >= 1) {


                $varsData = [];

                $varsItems = [];


                foreach($varsQuery as $varKey => $varValue) {


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


                    $paramsValue = self::resolveEditorShortcodeParamsRelations(

                      $paramsValue

                    );


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


                foreach($blockFieldsArgs['onload']['add-prop'] as $propItem) {


                  if(
                    is_array($propItem) &&
                    count($propItem) >= 1 &&
                    !array_key_exists(array_keys($propItem)[0], $props)
                  ) {

                    $props[array_keys($propItem)[0]] = array_values($propItem)[0];

                  }


                }


              }


            }


          }


        }


      }


      $rendered = isset($code['rendered'])
        ? $code['rendered']
        : false;


      $prefix = isset($code['prefix'])
        ? $code['prefix']
        : false;


      $sufix = isset($code['sufix'])
        ? $code['sufix']
        : false;


      $editor = isset($code['editor'])
        ? $code['editor']
        : false;


      if($rendered == true) {


        $tag = isset($code['default'])
          ? $code['default']
          : false;


        if($tag != false) {


          $tag = str_replace(['<', '>'], '', $tag);


          $prefix = str_replace(

            '[$tag$]',

            '<' . $tag,

            $prefix

          );


          $sufix = str_replace(

            '[$tag$]',

            $tag,

            $sufix

          );


        }


      } else {


        $tag = isset($code['tag'])
          ? $code['tag']
          : false;


        if($tag != false) {


          if(is_array($tag)) {

            $tag = $code['default'] ?? '';

          }


          $tag = str_replace(['<', '>'], '', $tag);


          $prefix = str_replace(

            '[$tag$]',

            $tag,

            $prefix

          );


          $sufix = str_replace(

            '[$tag$]',

            $tag,

            $sufix

          );


        }


        if($editor == true && is_string($prefix) && $prefix != '') {

          $prefix = substr($prefix, 0, -1) . ' contenteditable="true"' . ">";

        }


      }


      $retorno = [

        'id'             => $dados['tbl_sys_field_type_ID'] ?? '',
        'type'           => $dados['tbl_sys_field_type_name'] ?? '',
        'icon'           => $dados['tbl_sys_field_type_icon'] ?? '',
        'title'          => $dados['tbl_sys_field_type_title'] ?? '',
        'description'    => $dados['tbl_sys_field_type_description'] ?? '',
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
        'pagination'     => $pagination,
        'existe'         => $existe,
        'vars'           => $vars,

      ];


      if(($dados['tbl_sys_field_type_name'] ?? '') === 'shortcode') {

        $retorno['shortcodes'] = $relationItems['shortcode'] ?? [];

      }


      return $retorno;


    }

    // public static function renderViewEditorField($field, $data = []) {

    //   $type = SysFieldType::where('tbl_sys_field_type_layout', true)
    //     ->where('tbl_sys_field_type_ID', $field)
    //     ->first();

    //   if(!$type) {
    //     return '';
    //   }

    //   $fieldType = $type->toArray();

    //   $dados = $fieldType;
    //   $dados['value'] = $data;

    //   $configs = (
    //     isset($dados['tbl_sys_field_type_configs']) &&
    //     $dados['tbl_sys_field_type_configs'] !== null &&
    //     $dados['tbl_sys_field_type_configs'] != ''
    //   )
    //     ? (array) json_decode($dados['tbl_sys_field_type_configs'], true)
    //     : [];

    //   $code = (
    //     isset($configs['code']) &&
    //     is_array($configs['code']) &&
    //     count($configs['code']) >= 1
    //   )
    //     ? $configs['code']
    //     : [];

    //   $blocks = (
    //     isset($configs['block']) &&
    //     is_array($configs['block'])
    //   )
    //     ? $configs['block']
    //     : [];

    //   $vars = (
    //     isset($code['vars'])
    //   )
    //     ? (
    //       is_array($code['vars'])
    //         ? $code['vars']
    //         : (
    //           is_object($code['vars'])
    //             ? (array) $code['vars']
    //             : []
    //         )
    //     )
    //     : false;

    //   $props = [];
    //   $existe = [];
    //   $relationItems = [];

    //   foreach ($blocks as $blockKey => $blockArgs) {

    //     if(!isset($blockArgs['fields']) || !is_array($blockArgs['fields'])) {
    //       continue;
    //     }

    //     foreach ($blockArgs['fields'] as $blockFieldsKey => $blockFieldsArgs) {

    //       if(is_array($vars) && count($vars) >= 1 && array_key_exists($blockFieldsKey, $vars)) {

    //         if(isset($vars[$blockFieldsKey]['type']) && $vars[$blockFieldsKey]['type'] == 'relation') {

    //           $varsQuery = DB::table($vars[$blockFieldsKey]['table'])->get()->toArray();

    //           if(is_array($varsQuery) && count($varsQuery) >= 1) {

    //             $varsData = [];
    //             $varsItems = [];

    //             foreach ($varsQuery as $varKey => $varValue) {

    //               $varValue = (array) $varValue;

    //               $indexColumn = $vars[$blockFieldsKey]['index'];
    //               $labelColumn = $vars[$blockFieldsKey]['label'];

    //               $indexValue = $varValue[$indexColumn] ?? '';
    //               $labelValue = $varValue[$labelColumn] ?? $indexValue;

    //               if($indexValue == '') {
    //                 continue;
    //               }

    //               $varsData[$indexValue] = $labelValue;

    //               $item = [
    //                 'value' => $indexValue,
    //                 'code'  => $indexValue,
    //                 'label' => $labelValue,
    //                 'title' => $labelValue,
    //               ];

    //               if(isset($vars[$blockFieldsKey]['description'])) {

    //                 $descriptionColumn = $vars[$blockFieldsKey]['description'];

    //                 $item['description'] = $varValue[$descriptionColumn] ?? '';

    //                 if(isset($varValue[$descriptionColumn])) {
    //                   $item[$descriptionColumn] = $varValue[$descriptionColumn];
    //                 }

    //               }

    //               if(isset($vars[$blockFieldsKey]['params'])) {

    //                 $paramsColumn = $vars[$blockFieldsKey]['params'];
    //                 $paramsValue = $varValue[$paramsColumn] ?? [];

    //                 if(is_string($paramsValue) && $paramsValue != '') {

    //                   $decodedParams = json_decode($paramsValue, true);

    //                   $paramsValue = is_array($decodedParams)
    //                     ? $decodedParams
    //                     : [];

    //                 }

    //                 $paramsValue = self::resolveEditorShortcodeParamsRelations($paramsValue);

    //                 $item['params'] = $paramsValue;

    //                 if(isset($varValue[$paramsColumn])) {
    //                   $item[$paramsColumn] = $paramsValue;
    //                 }

    //               }

    //               $varsItems[$indexValue] = $item;

    //             }

    //             $blocks[$blockKey]['fields'][$blockFieldsKey]['choices'] = $varsData;

    //             $vars[$blockFieldsKey]['choices'] = $varsData;
    //             $vars[$blockFieldsKey]['items'] = $varsItems;

    //             $relationItems[$blockFieldsKey] = $varsItems;

    //           }

    //         }

    //       }

    //       if(array_key_exists('onload', $blockFieldsArgs)) {

    //         if(is_array($blockFieldsArgs['onload'])) {

    //           if(array_key_exists('add-prop', $blockFieldsArgs['onload'])) {

    //             foreach ($blockFieldsArgs['onload']['add-prop'] as $propItem) {

    //               if(!array_key_exists(array_keys($propItem)[0], $props)) {
    //                 $props[array_keys($propItem)[0]] = array_values($propItem)[0];
    //               }

    //             }

    //           }

    //         }

    //       }

    //     }

    //   }

    //   $rendered = isset($code['rendered']) ? $code['rendered'] : false;
    //   $prefix   = isset($code['prefix']) ? $code['prefix'] : false;
    //   $sufix    = isset($code['sufix']) ? $code['sufix'] : false;
    //   $editor   = isset($code['editor']) ? $code['editor'] : false;

    //   if($rendered == true) {

    //     $tag = isset($code['default']) ? $code['default'] : false;

    //     if($tag != false) {
    //       $tag = str_replace(['<', '>'], '', $tag);
    //       $prefix = str_replace('[$tag$]', '<' . $tag, $prefix);
    //       $sufix  = str_replace('[$tag$]', $tag, $sufix);
    //     }

    //   } else {

    //     $tag = isset($code['tag']) ? $code['tag'] : false;

    //     if($tag != false) {

    //       if(is_array($tag)) {
    //         $tag = $code['default'];
    //       }

    //       $tag = str_replace(['<', '>'], '', $tag);
    //       $prefix = str_replace('[$tag$]', $tag, $prefix);
    //       $sufix  = str_replace('[$tag$]', $tag, $sufix);

    //     }

    //     if($editor == true) {
    //       $prefix = substr($prefix, 0, -1) . ' contenteditable="true"' . ">";
    //     }

    //   }

    //   $retorno = [

    //     'id'             => $dados['tbl_sys_field_type_ID'],
    //     'type'           => $dados['tbl_sys_field_type_name'],
    //     'icon'           => $dados['tbl_sys_field_type_icon'],
    //     'title'          => $dados['tbl_sys_field_type_title'],
    //     'description'    => $dados['tbl_sys_field_type_description'],
    //     'code'           => '',
    //     'class'          => isset($code['class']) ? $code['class'] : '',
    //     'tag'            => isset($code['tag']) ? $code['tag'] : '',
    //     'prefix'         => $prefix,
    //     'sufix'          => $sufix,
    //     'toolbar'        => isset($configs['toolbar']) ? $configs['toolbar'] : [],
    //     'rendered'       => $rendered,
    //     'can_have_child' => isset($code['has_child']) ? $code['has_child'] : false,
    //     'props'          => $props,
    //     'editor'         => $editor,
    //     'properties'     => $blocks,
    //     'existe'         => $existe,
    //     'vars'           => $vars,

    //   ];

    //   if($dados['tbl_sys_field_type_name'] === 'shortcode') {
    //     $retorno['shortcodes'] = $relationItems['shortcode'] ?? [];
    //   }

    //   return $retorno;

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


    /*
    |--------------------------------------------------------------------------
    | Normaliza valores escalares de configurações relacionais
    |--------------------------------------------------------------------------
    |
    | Configurações de campos relacionais podem chegar em formatos diferentes:
    |
    | Antigo:
    | "label" => "tbl_users_type_name"
    |
    | Editor:
    | "label" => [
    |   "value" => "tbl_users_type_name"
    | ]
    |
    | Esta função mantém compatibilidade com ambos os formatos e impede
    | conversões diretas de array para string.
    |
    */

    private static function normalizeRelationScalarValue(

      $value,

      array $preferredKeys = [],

      $default = ''

    ) {


      /*
      |--------------------------------------------------------------------------
      | Valor inexistente
      |--------------------------------------------------------------------------
      */

      if($value === null) {

        return $default;

      }


      /*
      |--------------------------------------------------------------------------
      | String
      |--------------------------------------------------------------------------
      */

      if(is_string($value)) {

        return trim($value);

      }


      /*
      |--------------------------------------------------------------------------
      | Valores escalares
      |--------------------------------------------------------------------------
      */

      if(

        is_int($value) ||

        is_float($value)

      ) {

        return trim((string) $value);

      }


      if(is_bool($value)) {

        return $value ? '1' : '0';

      }


      /*
      |--------------------------------------------------------------------------
      | Objetos convertíveis para string
      |--------------------------------------------------------------------------
      */

      if(

        is_object($value) &&

        method_exists($value, '__toString')

      ) {

        return trim((string) $value);

      }


      /*
      |--------------------------------------------------------------------------
      | Objetos comuns
      |--------------------------------------------------------------------------
      */

      if(is_object($value)) {

        $value = (array) $value;

      }


      /*
      |--------------------------------------------------------------------------
      | Arrays
      |--------------------------------------------------------------------------
      */

      if(is_array($value)) {


        if(count($value) <= 0) {

          return $default;

        }


        /*
        |--------------------------------------------------------------------------
        | Primeiro procura pelas chaves específicas informadas
        |--------------------------------------------------------------------------
        */

        foreach($preferredKeys as $preferredKey) {


          if(

            !array_key_exists($preferredKey, $value)

          ) {

            continue;

          }


          $resolvedValue = self::normalizeRelationScalarValue(

            $value[$preferredKey],

            $preferredKeys,

            ''

          );


          if($resolvedValue !== '') {

            return $resolvedValue;

          }


        }


        /*
        |--------------------------------------------------------------------------
        | Chaves genéricas usadas pelo editor e configurações antigas
        |--------------------------------------------------------------------------
        */

        $genericKeys = [

          'value',

          'current',

          'selected',

          'default',

          'name',

          'field',

          'column',

          'display',

          'label',

          'table',

          'index',

          'key',

          'id',

        ];


        foreach($genericKeys as $genericKey) {


          if(

            !array_key_exists($genericKey, $value)

          ) {

            continue;

          }


          $resolvedValue = self::normalizeRelationScalarValue(

            $value[$genericKey],

            $preferredKeys,

            ''

          );


          if($resolvedValue !== '') {

            return $resolvedValue;

          }


        }


        /*
        |--------------------------------------------------------------------------
        | Compatibilidade com arrays numéricos contendo um único valor
        |--------------------------------------------------------------------------
        */

        foreach($value as $arrayValue) {


          if(

            is_array($arrayValue) ||

            is_object($arrayValue)

          ) {

            continue;

          }


          $resolvedValue = self::normalizeRelationScalarValue(

            $arrayValue,

            $preferredKeys,

            ''

          );


          if($resolvedValue !== '') {

            return $resolvedValue;

          }


        }


        return $default;

      }


      return $default;


    }


    /*
    |--------------------------------------------------------------------------
    | Normaliza propriedades de campos relacionais
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Normaliza propriedades de campos relacionais
    |--------------------------------------------------------------------------
    */

    public static function normalizeRelationFieldProps($props = []) {


      /*
      |--------------------------------------------------------------------------
      | Normaliza o container principal
      |--------------------------------------------------------------------------
      */

      if(is_object($props)) {

        $props = (array) $props;

      }


      if(!is_array($props)) {


        if(

          is_string($props) &&

          trim($props) !== ''

        ) {

          $decodedProps = json_decode(

            $props,

            true

          );


          $props = is_array($decodedProps)

            ? $decodedProps

            : [];

        } else {

          $props = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza params
      |--------------------------------------------------------------------------
      */

      $params = $props['params'] ?? [];


      if(is_object($params)) {

        $params = (array) $params;

      }


      if(!is_array($params)) {

        $params = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Resolve o tipo visual do campo
      |--------------------------------------------------------------------------
      |
      | Formulários antigos:
      |
      | type = select
      | type = checkbox
      | type = radio
      |
      | Editor de paginações:
      |
      | type = single
      | type = multiple
      |
      | Em uma paginação, single/multiple representam o modo relacional, e não
      | necessariamente o elemento HTML. Para manter compatibilidade, single vira
      | select quando nenhuma configuração visual explícita existir.
      |
      */

      $originalType = self::normalizeRelationScalarValue(

        $props['type']

        ?? '',

        [

          'type',
          'value',
          'default',
          'current',

        ],

        ''

      );


      $visualTypeValue =

        $props['input-type']

        ?? $props['input_type']

        ?? $props['visual-type']

        ?? $props['visual_type']

        ?? $params['configs.type']

        ?? $params['advanced.type']

        ?? $params['type']

        ?? $originalType;


      $fieldType = strtolower(

        self::normalizeRelationScalarValue(

          $visualTypeValue,

          [

            'type',
            'value',
            'default',
            'current',

          ],

          'select'

        )

      );


      if(

        $fieldType === '' ||

        $fieldType === 'single' ||

        $fieldType === 'multiple'

      ) {

        $fieldType = 'select';

      }


      if(

        !in_array(

          $fieldType,

          [

            'select',
            'checkbox',
            'radio',

          ],

          true

        )

      ) {

        $fieldType = 'select';

      }


      /*
      |--------------------------------------------------------------------------
      | Preserva o modo original
      |--------------------------------------------------------------------------
      */

      if(

        !isset($props['selection']) &&

        in_array(

          strtolower($originalType),

          [

            'single',
            'multiple',

          ],

          true

        )

      ) {

        $props['selection'] = strtolower(

          $originalType

        );

      }


      $props['type'] = $fieldType;


      /*
      |--------------------------------------------------------------------------
      | Configuração relation existente
      |--------------------------------------------------------------------------
      */

      $relation = $props['relation'] ?? [];


      if(is_string($relation)) {

        $decodedRelation = json_decode(

          $relation,

          true

        );


        $relation = is_array($decodedRelation)

          ? $decodedRelation

          : [];

      }


      if(is_object($relation)) {

        $relation = (array) $relation;

      }


      if(!is_array($relation)) {

        $relation = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Compatibilidade com propriedades planas
      |--------------------------------------------------------------------------
      |
      | Estrutura salva atualmente pelo editor:
      |
      | table
      | column
      | display
      | mode
      | relational-table
      | relational-column
      | empty
      |
      */

      $flatRelationAliases = [

        'table',
        'column',
        'value',
        'display',
        'label',
        'index',
        'key',
        'mode',
        'empty',
        'relational-table',
        'relational-column',
        'relational_table',
        'relational_column',
        'tabela-destino',
        'campo-destino',
        'label-destino',
        'label_table',
        'label_value',
        'label_display',

      ];


      foreach($flatRelationAliases as $flatRelationAlias) {

        if(

          !array_key_exists(

            $flatRelationAlias,

            $relation

          ) &&

          array_key_exists(

            $flatRelationAlias,

            $props

          )

        ) {

          $relation[$flatRelationAlias] =

            $props[$flatRelationAlias];

        }

      }


      /*
      |--------------------------------------------------------------------------
      | Resolve tabela
      |--------------------------------------------------------------------------
      */

      $tableValue =

        $relation['table']

        ?? $relation['tabela-destino']

        ?? $relation['label_table']

        ?? $props['table']

        ?? '';


      $relation['table'] = self::normalizeRelationScalarValue(

        $tableValue,

        [

          'table',
          'value',
          'name',
          'current',
          'default',

        ],

        ''

      );


      /*
      |--------------------------------------------------------------------------
      | Resolve coluna de valor
      |--------------------------------------------------------------------------
      */

      $valueValue =

        $relation['value']

        ?? $relation['column']

        ?? $relation['key']

        ?? $relation['index']

        ?? $relation['campo-destino']

        ?? $relation['label_value']

        ?? $props['column']

        ?? $props['value']

        ?? $props['index']

        ?? '';


      $relation['value'] = self::normalizeRelationScalarValue(

        $valueValue,

        [

          'value',
          'column',
          'field',
          'key',
          'index',
          'name',
          'current',
          'default',

        ],

        ''

      );


      /*
      |--------------------------------------------------------------------------
      | Resolve coluna de exibição
      |--------------------------------------------------------------------------
      */

      $labelValue =

        $relation['label']

        ?? $relation['display']

        ?? $relation['label-destino']

        ?? $relation['label_display']

        ?? $props['display']

        ?? $props['label']

        ?? '';


      $relation['label'] = self::normalizeRelationScalarValue(

        $labelValue,

        [

          'label',
          'display',
          'column',
          'field',
          'value',
          'name',
          'current',
          'default',

        ],

        ''

      );


      /*
      |--------------------------------------------------------------------------
      | Modo da relação
      |--------------------------------------------------------------------------
      */

      $relation['mode'] = self::normalizeRelationScalarValue(

        $relation['mode']

        ?? $props['mode']

        ?? 'revert',

        [

          'mode',
          'value',
          'default',

        ],

        'revert'

      );


      /*
      |--------------------------------------------------------------------------
      | Valor para relação vazia
      |--------------------------------------------------------------------------
      */

      $relation['empty'] = self::normalizeRelationScalarValue(

        $relation['empty']

        ?? $props['empty']

        ?? '',

        [

          'empty',
          'value',
          'default',

        ],

        ''

      );


      /*
      |--------------------------------------------------------------------------
      | Tabela intermediária
      |--------------------------------------------------------------------------
      */

      $relationalTable =

        $relation['relational-table']

        ?? $relation['relational_table']

        ?? $props['relational-table']

        ?? $props['relational_table']

        ?? '';


      $relation['relational-table'] =

        self::normalizeRelationScalarValue(

          $relationalTable,

          [

            'relational-table',
            'relational_table',
            'table',
            'value',

          ],

          ''

        );


      /*
      |--------------------------------------------------------------------------
      | Coluna da tabela intermediária
      |--------------------------------------------------------------------------
      */

      $relationalColumn =

        $relation['relational-column']

        ?? $relation['relational_column']

        ?? $props['relational-column']

        ?? $props['relational_column']

        ?? '';


      $relation['relational-column'] =

        self::normalizeRelationScalarValue(

          $relationalColumn,

          [

            'relational-column',
            'relational_column',
            'column',
            'value',

          ],

          ''

        );


      /*
      |--------------------------------------------------------------------------
      | Aliases para compatibilidade com renderizadores antigos
      |--------------------------------------------------------------------------
      */

      $relation['column'] = $relation['value'];

      $relation['display'] = $relation['label'];


      $props['table'] = $relation['table'];

      $props['column'] = $relation['value'];

      $props['value'] = $relation['value'];

      $props['display'] = $relation['label'];

      $props['label'] = $relation['label'];

      $props['mode'] = $relation['mode'];

      $props['empty'] = $relation['empty'];

      $props['relational-table'] =

        $relation['relational-table'];

      $props['relational-column'] =

        $relation['relational-column'];


      /*
      |--------------------------------------------------------------------------
      | Estrutura normalizada principal
      |--------------------------------------------------------------------------
      */

      $props['relation'] = $relation;


      return $props;


    }

    // public static function normalizeRelationFieldProps($props = []) {


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Normaliza o container principal
    //   |--------------------------------------------------------------------------
    //   */

    //   if(is_object($props)) {

    //     $props = (array) $props;

    //   }


    //   if(!is_array($props)) {


    //     if(

    //       is_string($props) &&

    //       trim($props) !== ''

    //     ) {

    //       $decodedProps = json_decode(

    //         $props,

    //         true

    //       );


    //       $props = is_array($decodedProps)

    //         ? $decodedProps

    //         : [];

    //     } else {

    //       $props = [];

    //     }


    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Resolve o tipo visual do campo
    //   |--------------------------------------------------------------------------
    //   */

    //   $fieldTypeValue = $props['type'] ?? '';


    //   if(isset($props['params'])) {


    //     $params = $props['params'];


    //     if(is_object($params)) {

    //       $params = (array) $params;

    //     }


    //     if(is_array($params)) {


    //       if(

    //         $fieldTypeValue === null ||

    //         $fieldTypeValue === '' ||

    //         is_array($fieldTypeValue) ||

    //         is_object($fieldTypeValue)

    //       ) {

    //         $fieldTypeValue =

    //           $params['configs.type']

    //           ?? $params['advanced.type']

    //           ?? $params['type']

    //           ?? '';

    //       }


    //     }


    //   }


    //   $fieldType = strtolower(

    //     self::normalizeRelationScalarValue(

    //       $fieldTypeValue,

    //       [

    //         'type',

    //         'value',

    //         'default',

    //         'current',

    //       ],

    //       'select'

    //     )

    //   );


    //   if($fieldType === '') {

    //     $fieldType = 'select';

    //   }


    //   if(

    //     !in_array(

    //       $fieldType,

    //       [

    //         'select',

    //         'checkbox',

    //         'radio',

    //       ],

    //       true

    //     )

    //   ) {

    //     $fieldType = 'select';

    //   }


    //   $props['type'] = $fieldType;


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Normaliza a configuração relation
    //   |--------------------------------------------------------------------------
    //   */

    //   $relation = $props['relation'] ?? [];


    //   if(is_string($relation)) {


    //     $decodedRelation = json_decode(

    //       $relation,

    //       true

    //     );


    //     $relation = is_array($decodedRelation)

    //       ? $decodedRelation

    //       : [];

    //   }


    //   if(is_object($relation)) {

    //     $relation = (array) $relation;

    //   }


    //   if(!is_array($relation)) {

    //     $relation = [];

    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Resolve tabela
    //   |--------------------------------------------------------------------------
    //   |
    //   | Formatos compatíveis:
    //   |
    //   | relation.table
    //   | relation.tabela-destino
    //   | relation.label_table
    //   |
    //   */

    //   $tableValue =

    //     $relation['table']

    //     ?? $relation['tabela-destino']

    //     ?? $relation['label_table']

    //     ?? '';


    //   $relation['table'] = self::normalizeRelationScalarValue(

    //     $tableValue,

    //     [

    //       'table',

    //       'value',

    //       'name',

    //       'current',

    //       'default',

    //     ],

    //     ''

    //   );


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Resolve coluna de valor
    //   |--------------------------------------------------------------------------
    //   |
    //   | Formatos compatíveis:
    //   |
    //   | relation.value
    //   | relation.column
    //   | relation.key
    //   | relation.campo-destino
    //   | relation.label_value
    //   |
    //   */

    //   $valueValue =

    //     $relation['value']

    //     ?? $relation['column']

    //     ?? $relation['key']

    //     ?? $relation['campo-destino']

    //     ?? $relation['label_value']

    //     ?? '';


    //   $relation['value'] = self::normalizeRelationScalarValue(

    //     $valueValue,

    //     [

    //       'value',

    //       'column',

    //       'field',

    //       'key',

    //       'name',

    //       'current',

    //       'default',

    //     ],

    //     ''

    //   );


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Resolve coluna de exibição
    //   |--------------------------------------------------------------------------
    //   |
    //   | Formatos compatíveis:
    //   |
    //   | relation.label
    //   | relation.display
    //   | relation.label-destino
    //   | relation.label_display
    //   |
    //   */

    //   $labelValue =

    //     $relation['label']

    //     ?? $relation['display']

    //     ?? $relation['label-destino']

    //     ?? $relation['label_display']

    //     ?? '';


    //   $relation['label'] = self::normalizeRelationScalarValue(

    //     $labelValue,

    //     [

    //       'label',

    //       'display',

    //       'column',

    //       'field',

    //       'value',

    //       'name',

    //       'current',

    //       'default',

    //     ],

    //     ''

    //   );


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Mantém compatibilidade com index
    //   |--------------------------------------------------------------------------
    //   |
    //   | Algumas configurações do editor usam "index" no lugar de "value".
    //   |
    //   */

    //   if(

    //     $relation['value'] === '' &&

    //     isset($relation['index'])

    //   ) {

    //     $relation['value'] = self::normalizeRelationScalarValue(

    //       $relation['index'],

    //       [

    //         'index',

    //         'column',

    //         'field',

    //         'value',

    //       ],

    //       ''

    //     );

    //   }


    //   /*
    //   |--------------------------------------------------------------------------
    //   | Remove somente aliases já convertidos
    //   |--------------------------------------------------------------------------
    //   |
    //   | As demais propriedades da relação permanecem intactas.
    //   |
    //   */

    //   unset(

    //     $relation['column'],

    //     $relation['display'],

    //     $relation['key'],

    //     $relation['label_table'],

    //     $relation['label_value'],

    //     $relation['label_display'],

    //     $relation['tabela-destino'],

    //     $relation['campo-destino'],

    //     $relation['label-destino']

    //   );


    //   $props['relation'] = $relation;


    //   return $props;


    // }


    // public static function normalizeRelationFieldProps($props = []) {

    //   if(!is_array($props)) {
    //     $props = [];
    //   }

    //   $fieldType = strtolower((string) ($props['type'] ?? ''));

    //   if(isset($props['params']) && is_array($props['params'])) {

    //     $fieldType = strtolower((string) (
    //       $props['type']
    //       ?? $props['params']['configs.type']
    //       ?? $props['params']['advanced.type']
    //       ?? $props['params']['type']
    //       ?? $fieldType
    //     ));

    //   }

    //   if($fieldType == '') {
    //     $fieldType = 'select';
    //   }

    //   if(!in_array($fieldType, ['select', 'checkbox', 'radio'])) {
    //     $fieldType = 'select';
    //   }

    //   $props['type'] = $fieldType;

    //   if(!isset($props['relation']) || !is_array($props['relation'])) {
    //     $props['relation'] = [];
    //   }

    //   $relation = $props['relation'];

    //   $relation['table'] = trim((string) (
    //     $relation['table']
    //     ?? $relation['tabela-destino']
    //     ?? ''
    //   ));

    //   $relation['value'] = trim((string) (
    //     $relation['value']
    //     ?? $relation['column']
    //     ?? $relation['campo-destino']
    //     ?? ''
    //   ));

    //   $relation['label'] = trim((string) (
    //     $relation['label']
    //     ?? $relation['display']
    //     ?? $relation['label-destino']
    //     ?? ''
    //   ));

    //   unset(
    //     $relation['column'],
    //     $relation['display'],
    //     $relation['key'],
    //     $relation['label_table'],
    //     $relation['label_value'],
    //     $relation['label_display'],
    //     $relation['tabela-destino'],
    //     $relation['campo-destino'],
    //     $relation['label-destino']
    //   );

    //   $props['relation'] = $relation;

    //   return $props;

    // }


    /*
    |--------------------------------------------------------------------------
    | Normaliza propriedades do campo para renderização
    |--------------------------------------------------------------------------
    */

    public static function normalizeFieldPropsForRender($field = []) {


      if(is_object($field)) {

        $field = (array) $field;

      }


      if(!is_array($field)) {

        $field = [];

      }


      /*
      |--------------------------------------------------------------------------
      | Localiza as propriedades
      |--------------------------------------------------------------------------
      */

      $props =

        $field['props']

        ?? $field['tbl_sys_forms_field_props']

        ?? [];


      /*
      |--------------------------------------------------------------------------
      | Normaliza propriedades recebidas como objeto
      |--------------------------------------------------------------------------
      */

      if(is_object($props)) {

        $props = (array) $props;

      }


      /*
      |--------------------------------------------------------------------------
      | Normaliza propriedades recebidas como JSON
      |--------------------------------------------------------------------------
      */

      if(!is_array($props)) {


        if(

          is_string($props) &&

          trim($props) !== ''

        ) {

          $decodedProps = json_decode(

            $props,

            true

          );


          $props = is_array($decodedProps)

            ? $decodedProps

            : [];

        } else {

          $props = [];

        }


      }


      /*
      |--------------------------------------------------------------------------
      | Resolve o tipo do campo
      |--------------------------------------------------------------------------
      */

      $fieldType =

        $field['field_type']

        ?? [];


      if(is_object($fieldType)) {

        $fieldType = (array) $fieldType;

      }


      if(!is_array($fieldType)) {

        $fieldType = [];

      }


      $fieldTypeNameValue =

        $fieldType['tbl_sys_field_type_name']

        ?? $field['tbl_sys_field_type_name']

        ?? '';


      $fieldTypeName = strtolower(

        self::normalizeRelationScalarValue(

          $fieldTypeNameValue,

          [

            'tbl_sys_field_type_name',

            'type',

            'name',

            'value',

          ],

          ''

        )

      );


      /*
      |--------------------------------------------------------------------------
      | Normalização específica de campos relacionais
      |--------------------------------------------------------------------------
      */

      if(

        $fieldTypeName === 'relation' ||

        $fieldTypeName === 'relations'

      ) {

        $props = self::normalizeRelationFieldProps(

          $props

        );

      }


      return $props;


    }


    // public static function normalizeFieldPropsForRender($field = []) {

    //   $props = $field['props'] ?? [];

    //   if(!is_array($props)) {

    //     if($props != '') {
    //       $props = json_decode($props, true);
    //     }

    //     if(!is_array($props)) {
    //       $props = [];
    //     }

    //   }

    //   $fieldTypeName = strtolower((string) (
    //     $field['field_type']['tbl_sys_field_type_name']
    //     ?? $field['tbl_sys_field_type_name']
    //     ?? ''
    //   ));

    //   if($fieldTypeName == 'relation' || $fieldTypeName == 'relations') {
    //     $props = self::normalizeRelationFieldProps($props);
    //   }

    //   return $props;

    // }



    /*
    |--------------------------------------------------------------------------
    | Renderiza os botões de ação do formulário
    |--------------------------------------------------------------------------
    |
    | Esta função é utilizada somente quando o formulário não é modal.
    |
    | tbl_sys_form_modal:
    | - 0 / false: gera os botões Cancelar e Salvar;
    | - 1 / true: os botões continuam sendo controlados pelo modal.
    |
    */

    public static function renderFormActions($form = [], $formElementID = '') {


      if(!is_array($form)) {

        $form = [];

      }


      if($formElementID === '') {

        return '';

      }


      $cancelText = $form['tbl_sys_form_cancel'] ?? '';

      $submitText = $form['tbl_sys_form_submit'] ?? '';


      if($cancelText === null || trim((string) $cancelText) === '') {

        $cancelText = SysAutomator::SysAutomatorGetTranslateWord('Cancelar');

      }


      if($submitText === null || trim((string) $submitText) === '') {

        $submitText = SysAutomator::SysAutomatorGetTranslateWord('Salvar');

      }


      $cancelButtonID = $formElementID . '-cancel';

      $submitButtonID = $formElementID . '-submit';


      $html = '';


      $html .= '<div class="col-12">' . "\n";

        $html .= '<div class="row">' . "\n";


          /*
          |--------------------------------------------------------------------------
          | Botão cancelar/resetar
          |--------------------------------------------------------------------------
          */

          $html .= '<div class="col-12 order-2 col-md-6 order-md-1">' . "\n";

            $html .= '<button';
            $html .= ' type="reset"';
            $html .= ' id="' . e($cancelButtonID) . '"';
            $html .= ' form="' . e($formElementID) . '"';
            $html .= ' class="btn btn-secondary w-100 js-automator-pagination-modal-cancel"';
            $html .= '>';

              $html .= e($cancelText);

            $html .= '</button>' . "\n";

          $html .= '</div>' . "\n";


          /*
          |--------------------------------------------------------------------------
          | Botão submit
          |--------------------------------------------------------------------------
          */

          $html .= '<div class="col-12 order-1 col-md-6 order-md-2">' . "\n";

            $html .= '<button';
            $html .= ' type="submit"';
            $html .= ' id="' . e($submitButtonID) . '"';
            $html .= ' form="' . e($formElementID) . '"';
            $html .= ' class="btn btn-primary w-100 js-automator-pagination-modal-submit"';
            $html .= ' disabled';
            $html .= '>';

              $html .= e($submitText);

            $html .= '</button>' . "\n";

          $html .= '</div>' . "\n";


        $html .= '</div>' . "\n";

      $html .= '</div>' . "\n";


      return $html;


    }



  }