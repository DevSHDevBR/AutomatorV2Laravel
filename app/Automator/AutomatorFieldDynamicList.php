<?php


  namespace App\Automator;



  class AutomatorFieldDynamicList extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.dynamic-list', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.dynamic-list', $args, false);


    }



  }