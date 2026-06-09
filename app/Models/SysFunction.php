<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class SysFunction extends Model {
    


    protected $table      = 'tbl_sys_functions';
    protected $primaryKey = 'tbl_sys_function_ID';


    const CREATED_AT = 'tbl_sys_function_created_at';
    const UPDATED_AT = 'tbl_sys_function_updated_at';


    protected $fillable = [

      'tbl_sys_function_type',
      'tbl_sys_function_name',
      'tbl_sys_function_fn',
      'tbl_sys_function_params'
      
    ];



  }
