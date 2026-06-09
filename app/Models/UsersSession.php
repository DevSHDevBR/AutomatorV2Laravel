'<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class UsersSession extends Model {



    protected $table      = 'tbl_users_sessions';
    protected $primaryKey = 'tbl_users_session_ID';


    public $timestamps = false;


    protected $fillable = [

      'tbl_user_ID',
      'tbl_users_session_token',
      'tbl_users_session_ip_address',
      'tbl_users_session_agent',
      'tbl_users_session_payload',
      'tbl_users_session_status',
      'tbl_users_session_last_activity'

    ];



    public static function countUsersOnline($seconds = 60) {


      return self::where('tbl_users_session_status', true)
                 ->where('tbl_users_session_last_activity', '>=', now()->subSeconds($seconds))
                 ->distinct('tbl_user_ID')
                 ->count('tbl_user_ID');
    

    }


    
  }
