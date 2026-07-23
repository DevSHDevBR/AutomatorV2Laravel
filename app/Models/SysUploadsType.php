<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysUploadsType extends Model {

    

    protected $table      = 'tbl_sys_uploads_types';
    protected $primaryKey = 'tbl_sys_uploads_type_ID';


    const CREATED_AT = 'tbl_sys_uploads_type_created_at';
    const UPDATED_AT = 'tbl_sys_uploads_type_updated_at';

    protected $fillable = [

      'tbl_sys_uploads_type_icon',
      'tbl_sys_uploads_type_mine',
      'tbl_sys_uploads_type_name',
      'tbl_sys_uploads_type_title',
      'tbl_sys_uploads_type_description',
      'tbl_sys_uploads_type_locked',

    ];


    
  }
