<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysMenu extends Model {
    
    protected $table      = 'tbl_sys_menus';
    protected $primaryKey = 'tbl_sys_menu_ID';


    const CREATED_AT = 'tbl_sys_menu_created_at';
    const UPDATED_AT = 'tbl_sys_menu_updated_at';


    protected $fillable = [

      'tbl_sys_nav_ID',
      'tbl_sys_menu_title',
      'tbl_sys_menu_index',
      'tbl_sys_menu_class',
      'tbl_sys_menu_locked'

    ];

  }
