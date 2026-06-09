<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysNav extends Model {
    


    protected $table      = 'tbl_sys_navs';
    protected $primaryKey = 'tbl_sys_nav_ID';

    const CREATED_AT = 'tbl_sys_nav_created_at';
    const UPDATED_AT = 'tbl_sys_nav_updated_at';


    protected $fillable = [

      'tbl_sys_nav_name',
      'tbl_sys_nav_title',
      'tbl_sys_nav_admin',
      'tbl_sys_nav_locked',

    ];



  }