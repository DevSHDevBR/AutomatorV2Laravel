<?php


  namespace App\Automator;



  class AutomatorFieldTextArea extends AutomatorFields {



    public static function formField($args = []) {


      $args['render'] = 'formulario';

      return parent::renderView('system.fields.textarea', $args);


    }



    public static function paginationColumn($args = []) {


      $args['render'] = 'paginacao';

      return parent::renderView('system.fields.textarea', $args, false);


    }



  }