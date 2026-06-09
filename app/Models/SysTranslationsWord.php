<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysTranslationsWord extends Model {


    protected $table      = 'tbl_sys_translations_words';
    protected $primaryKey = 'tbl_translations_word_ID';


    const CREATED_AT = 'tbl_translations_word_created_at';
    const UPDATED_AT = 'tbl_translations_word_updated_at';


    protected $fillable = [

      'tbl_sys_translation_ID',
      'tbl_translations_word_name',
      'tbl_translations_word_str'
      
    ];
    
  }
