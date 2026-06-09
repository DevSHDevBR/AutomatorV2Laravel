<?php


  namespace App\Automator;



  class AutomatorFieldBreakLine extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.breakline', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.breakline', $args, false);


    }



  }