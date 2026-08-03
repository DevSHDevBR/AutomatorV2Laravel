<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysUploadsTemp extends Model {



    protected $table      = 'tbl_sys_uploads_temp';
    protected $primaryKey = 'tbl_sys_upload_temp_ID';


    const CREATED_AT = 'tbl_sys_upload_temp_created_at';
    const UPDATED_AT = 'tbl_sys_upload_temp_updated_at';


    protected $fillable = [

      'tbl_sys_uploads_type_ID',
      'tbl_sys_upload_temp_file',
      'tbl_sys_upload_temp_directory',
      'tbl_user_ID'

    ];


    
  }