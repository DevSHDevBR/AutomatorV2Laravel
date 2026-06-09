<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysMenusItemsAccess extends Model {
    


    protected $table      = 'tbl_sys_menus_access';
    protected $primaryKey = 'tbl_menus_access_ID';


    public $timestamps = false;


    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_sys_menu_item_ID',

    ];



  }