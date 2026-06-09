<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysFieldTypesGroup extends Model {
    
    
    protected $table      = 'tbl_sys_field_types_groups';
    protected $primaryKey = 'tbl_sys_field_type_group_ID';

    const CREATED_AT = 'tbl_sys_field_type_group_created';
    const UPDATED_AT = 'tbl_sys_field_type_group_updated';


    protected $fillable = [

      'tbl_sys_field_type_group_name',
      'tbl_sys_field_type_group_title',
      'tbl_sys_field_type_group_locked',
      'tbl_sys_field_type_group_ordem',

    ];



  }