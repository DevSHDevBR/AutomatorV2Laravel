<?php


  namespace App\Automator;



  class AutomatorFieldJson extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.json', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.json', $args, false);


    }



  }