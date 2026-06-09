<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysRoutesAccess extends Model {
    


    protected $table      = 'tbl_sys_routes_access';
    protected $primaryKey = 'tbl_routes_access_ID';


    public $timestamps = false;


    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_sys_route_ID',

    ];



  }
