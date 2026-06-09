<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysPaginationsColsAccess extends Model {
    


    protected $table      = 'tbl_sys_paginations_cols_access';
    protected $primaryKey = 'tbl_sys_pagination_col_access_ID';


    public $timestamps = false;


    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_sys_paginations_col_ID',

    ];



  }