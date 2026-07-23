<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysUploadsAccess extends Model {
    


    protected $table      = 'tbl_sys_uploads_access';
    protected $primaryKey = 'tbl_sys_uploads_access_ID';


    public $timestamps = false;

    protected $fillable = [

      'tbl_user_ID',
      'tbl_sys_upload_ID'

    ];


    
  }
