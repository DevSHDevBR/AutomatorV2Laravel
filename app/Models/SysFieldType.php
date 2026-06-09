<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysFieldType extends Model {
    
    
    protected $table      = 'tbl_sys_field_types';
    protected $primaryKey = 'tbl_sys_field_type_ID';

    const CREATED_AT = 'tbl_sys_field_type_created_at';
    const UPDATED_AT = 'tbl_sys_field_type_updated_at';


    protected $fillable = [

      'tbl_sys_field_type_group_ID',
      'tbl_sys_field_type_name',
      'tbl_sys_field_type_class',
      'tbl_sys_field_type_icon',
      'tbl_sys_field_type_title',
      'tbl_sys_field_type_description',
      'tbl_sys_field_type_params',
      'tbl_sys_field_type_locked',
      'tbl_sys_field_type_layout',
      'tbl_sys_field_type_configs',

    ];


    public static function getFieldTypeDataByName($name, $data = []) {

      if(is_array($data)) {

        $field = self::where('tbl_sys_field_type_name', $name)->get();
        if($field !== null) {

          return $field->toArray();

        } else {

          return '';

        }

      } else {

        return self::where('tbl_sys_field_type_name', $name)->value($data);

      }
      
    }


    public static function getFieldTypeParamsByName($name) {


      return self::where('tbl_sys_field_type_name', $name)->value('tbl_sys_field_type_params');


    }



  }
