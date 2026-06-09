<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysMenusItem extends Model {

    protected $table      = 'tbl_sys_menus_items';
    protected $primaryKey = 'tbl_sys_menu_item_ID';


    const CREATED_AT = 'tbl_sys_menu_item_created_at';
    const UPDATED_AT = 'tbl_sys_menu_item_updated_at';


    protected $fillable = [

      'tbl_sys_menu_ID',
      'tbl_sys_menu_item_index',
      'tbl_sys_menu_item_icon',
      'tbl_sys_menu_item_class',
      'tbl_sys_menu_item_title',
      'tbl_sys_menu_item_type',
      'tbl_sys_route_ID',
      'tbl_sys_menu_item_link',
      'tbl_sys_menu_item_props',
      'tbl_sys_menu_item_status',
      'tbl_sys_menu_item_parent_id',
      'tbl_sys_menu_item_locked',
      'tbl_sys_menu_item_admin',
      'tbl_sys_menu_item_ordem'

    ];
      
  }
