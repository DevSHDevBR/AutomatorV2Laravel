<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysView extends Model {
    
    

    protected $table      = 'tbl_sys_views';
    protected $primaryKey = 'tbl_sys_view_ID';


    const CREATED_AT = 'tbl_sys_view_created_at';
    const UPDATED_AT = 'tbl_sys_view_updated_at';


    protected $fillable = [

      'tbl_sys_view_name',
      'tbl_sys_view_title',
      'tbl_sys_view_description',
      'tbl_sys_view_directory',
      'tbl_sys_view_file',
      'tbl_sys_view_args',
      'tbl_sys_view_status',
      'tbl_sys_view_locked',

    ];



    public static function getViewIDByName($name) {

      return self::where('tbl_sys_view_name', $name)->value('tbl_sys_view_ID');
      
    }



  }