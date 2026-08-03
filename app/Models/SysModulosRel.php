<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysModulosRel extends Model {



    protected $table      = 'tbl_sys_modulos_rels';
    protected $primaryKey = 'tbl_sys_modulo_rel_ID';


    const CREATED_AT = 'tbl_sys_modulo_rel_created_at';
    const UPDATED_AT = 'tbl_sys_modulo_rel_updated_at';


    protected $fillable = [

      'tbl_sys_modulo_rel_name',
      'tbl_sys_modulo_ID',
      'tbl_sys_modulo_rel_table',
      'tbl_sys_modulo_rel_column',
      'tbl_sys_modulo_rel_value'

    ];



  }
