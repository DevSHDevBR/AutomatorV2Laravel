<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysConfig extends Model {



    protected $table      = 'tbl_sys_configs';
    protected $primaryKey = 'tbl_sys_config_ID';


    const CREATED_AT = 'tbl_sys_config_created_at';
    const UPDATED_AT = 'tbl_sys_config_updated_at';


    protected $fillable = [

      'tbl_sys_field_type_ID',
      'tbl_sys_config_name',
      'tbl_sys_config_description',
      'tbl_sys_config_default',
      'tbl_sys_config_value',
      'tbl_sys_config_props',
      'tbl_sys_config_required',

    ];
    


  }
