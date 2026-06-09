<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysFormsFieldsAccess extends Model {


    protected $table      = 'tbl_sys_forms_fields_access';
    protected $primaryKey = 'tbl_sys_forms_fields_access_ID';


    public $timestamps = false;


    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_sys_forms_field_ID',

    ];
  

  }
