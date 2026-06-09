<?php


  namespace App\Automator;



  class AutomatorFieldRow extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.text', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.text', $args, false);


    }



    public static function viewEditorField($args = []) {

      
      $configs = ( ($args['tbl_sys_field_type_configs'] !== null) ? ( ($args['tbl_sys_field_type_configs'] != '') ? ( (array) json_decode($args['tbl_sys_field_type_configs'], true) ) : [] ) : [] );

      $retorno = [

        'id'             => $args['tbl_sys_field_type_ID'],
        'icon'           => $args['tbl_sys_field_type_icon'],
        'title'          => $args['tbl_sys_field_type_title'],
        'description'    => $args['tbl_sys_field_type_description'],
        // 'code'           => $configs['code']['prefix'] . $configs['code']['sufix'],
        'code'           => '',
        'prefix'         => $configs['code']['prefix'],
        'sufix'          => $configs['code']['sufix'],
        'toolbar'        => ( (isset($configs['toolbar'])) ? $configs['toolbar'] : [] ),
        'can_have_child' => true,
        'properties'     => $configs['block']

      ];

      return $retorno;
      // $args['render'] = 'editor';

      // return parent::renderView('system.fields.paragraph', $args, false);

    }



  }