<?php


  namespace App\Automator;



  class AutomatorFieldSelect extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.select', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';
      
      return parent::renderView('system.fields.select', $args, false);


    }



  }