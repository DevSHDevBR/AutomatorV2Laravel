<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysTranslation extends Model {
    


    protected $table      = 'tbl_sys_translations';
    protected $primaryKey = 'tbl_sys_translation_ID';


    const CREATED_AT = 'tbl_sys_translation_created_at';
    const UPDATED_AT = 'tbl_sys_translation_updated_at';


    protected $fillable = [

      'tbl_sys_translation_key',
      'tbl_sys_translation_name',
      'tbl_sys_translation_description',
      'tbl_sys_translation_locked'
      
    ];



  }
