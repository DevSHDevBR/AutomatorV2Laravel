<?php


  namespace App\Automator;



  class AutomatorFieldGallery extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.gallery', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.gallery', $args, false);


    }



  }