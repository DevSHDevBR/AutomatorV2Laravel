<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysForm extends Model {


    protected $table      = 'tbl_sys_forms';
    protected $primaryKey = 'tbl_sys_form_ID';


    const CREATED_AT = 'tbl_sys_form_created_at';
    const UPDATED_AT = 'tbl_sys_form_updated_at';


    protected $fillable = [

      'tbl_sys_form_name',
      'tbl_sys_form_title',
      'tbl_sys_form_cancel',
      'tbl_sys_form_submit',
      'tbl_sys_form_result',
      'tbl_sys_form_method',
      'tbl_sys_form_route',
      'tbl_sys_form_modal',
      'tbl_sys_form_admin',
      'tbl_sys_form_validate',
      'tbl_sys_form_locked',

    ];
  


  }
