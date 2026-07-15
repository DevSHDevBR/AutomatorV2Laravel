<?php


  namespace App\Automator;



  class AutomatorFieldBreakPoint extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.breakpoint', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.breakpoint', $args, false);


    }



  }