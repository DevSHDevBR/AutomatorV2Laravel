<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysUpload extends Model {



    protected $table      = 'tbl_sys_uploads';
    protected $primaryKey = 'tbl_sys_upload_ID';


    const CREATED_AT = 'tbl_sys_upload_created_at';
    const UPDATED_AT = 'tbl_sys_upload_updated_at';


    protected $fillable = [

      'tbl_sys_uploads_type_ID',
      'tbl_sys_upload_file',
      'tbl_sys_upload_title',
      'tbl_sys_upload_directory',
      'tbl_user_ID',
      'tbl_sys_upload_access'

    ];


    
  }