<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysModulo extends Model {



    protected $table      = 'tbl_sys_modulos';
    protected $primaryKey = 'tbl_sys_modulo_ID';


    const CREATED_AT = 'tbl_sys_modulo_created_at';
    const UPDATED_AT = 'tbl_sys_modulo_updated_at';


    protected $fillable = [

      'tbl_sys_modulo_name',
      'tbl_sys_modulo_title',
      'tbl_sys_modulo_description',
      'tbl_sys_modulo_locked',
      'tbl_sys_modulo_status'

    ];



  }
