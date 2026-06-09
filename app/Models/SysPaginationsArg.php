<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysPaginationsArg extends Model {



    protected $table      = 'tbl_sys_paginations_args';
    protected $primaryKey = 'tbl_sys_paginations_arg_ID';


    const CREATED_AT = 'tbl_sys_paginations_arg_created';
    const UPDATED_AT = 'tbl_sys_paginations_arg_updated';


    protected $fillable = [

      'tbl_sys_pagination_ID',
      'tbl_sys_paginations_arg_name',
      'tbl_sys_paginations_arg_value'

    ];


    
  }
