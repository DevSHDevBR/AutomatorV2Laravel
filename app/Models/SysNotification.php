<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysNotification extends Model {


    protected $table      = 'tbl_sys_notifications';
    protected $primaryKey = 'tbl_sys_notification_ID';


    const CREATED_AT = 'tbl_sys_notification_created_at';
    const UPDATED_AT = 'tbl_sys_notification_updated_at';


    protected $fillable = [

      'tbl_user_ID',
      'tbl_sys_notification_title',
      'tbl_sys_notification_text',
      'tbl_sys_notification_opened',

    ];
  

  }