<?php


  namespace App\Automator;



  class AutomatorFieldHidden extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.hidden', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.hidden', $args, false);


    }



  }