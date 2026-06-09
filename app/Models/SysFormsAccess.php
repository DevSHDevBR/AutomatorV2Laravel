<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysFormsAccess extends Model {
    


    protected $table      = 'tbl_sys_forms_access';
    protected $primaryKey = 'tbl_sys_forms_access_ID';


    public $timestamps = false;


    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_sys_form_ID',

    ];



  }
