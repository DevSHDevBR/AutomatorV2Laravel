<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysShortcode extends Model {
    


    protected $table      = 'tbl_sys_shortcodes';
    protected $primaryKey = 'tbl_sys_shortcode_ID';


    const CREATED_AT = 'tbl_sys_shortcode_created_at';
    const UPDATED_AT = 'tbl_sys_shortcode_updated_at';


    protected $fillable = [

      'tbl_sys_shortcode_code',
      'tbl_sys_shortcode_title',
      'tbl_sys_shortcode_description',
      'tbl_sys_shortcode_class',
      'tbl_sys_shortcode_method',
      'tbl_sys_shortcode_params',
      'tbl_sys_shortcode_locked'
      
    ];



  }