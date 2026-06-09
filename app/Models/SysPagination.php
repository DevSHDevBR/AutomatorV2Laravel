<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysPagination extends Model {



    protected $table      = 'tbl_sys_paginations';
    protected $primaryKey = 'tbl_sys_pagination_ID';


    const CREATED_AT = 'tbl_sys_pagination_created_at';
    const UPDATED_AT = 'tbl_sys_pagination_updated_at';


    protected $fillable = [

      'tbl_sys_pagination_name',
      'tbl_sys_pagination_route',
      'tbl_sys_pagination_title',
      'tbl_sys_pagination_table',
      'tbl_sys_pagination_index',
      'tbl_sys_pagination_locked'

    ];


    
  }