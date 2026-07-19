<?php


  namespace App\Automator;



  class AutomatorFieldDateTime extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.datetime', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.datetime', $args, false);


    }



  }