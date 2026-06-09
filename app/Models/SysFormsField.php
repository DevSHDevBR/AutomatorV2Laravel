<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysFormsField extends Model {



    protected $table      = 'tbl_sys_forms_fields';
    protected $primaryKey = 'tbl_sys_forms_field_ID';


    const CREATED_AT = 'tbl_sys_forms_field_created_at';
    const UPDATED_AT = 'tbl_sys_forms_field_updated_at';


    protected $fillable = [

      'tbl_sys_form_ID',
      'tbl_sys_field_type_ID',
      'tbl_sys_forms_field_title',
      'tbl_sys_forms_field_name',
      'tbl_sys_forms_field_index',
      'tbl_sys_forms_field_class',
      'tbl_sys_forms_field_default',
      'tbl_sys_forms_field_props',
      'tbl_sys_forms_field_attrs',
      'tbl_sys_forms_field_required',
      'tbl_sys_forms_field_locked',
      'tbl_sys_forms_field_ordem',

    ];


    
  }
