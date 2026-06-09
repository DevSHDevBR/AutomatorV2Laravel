<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysPaginationsCol extends Model {



    protected $table      = 'tbl_sys_paginations_cols';
    protected $primaryKey = 'tbl_sys_paginations_col_ID';


    const CREATED_AT = 'tbl_sys_paginations_col_created';
    const UPDATED_AT = 'tbl_sys_paginations_col_updated';


    protected $fillable = [

      'tbl_sys_pagination_ID',
      'tbl_sys_field_type_ID',
      'tbl_sys_paginations_col_name',
      'tbl_sys_paginations_col_title',
      'tbl_sys_paginations_col_header',
      'tbl_sys_paginations_col_body',
      'tbl_sys_paginations_col_props',
      'tbl_sys_paginations_col_attrs',
      'tbl_sys_paginations_col_search',
      'tbl_sys_paginations_col_sort',
      'tbl_sys_paginations_col_ordem',

    ];


    
  }