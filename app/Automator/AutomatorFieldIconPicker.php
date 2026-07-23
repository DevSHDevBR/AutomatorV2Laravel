<?php


  namespace App\Automator;



  class AutomatorFieldIconPicker extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.icon-picker', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.icon-picker', $args, false);


    }



  }