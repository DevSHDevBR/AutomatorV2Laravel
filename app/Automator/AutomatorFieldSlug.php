<?php


  namespace App\Automator;



  class AutomatorFieldSlug extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.slug', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.slug', $args, false);


    }



  }