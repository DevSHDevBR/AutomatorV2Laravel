<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class UsersTypesRel extends Model {
    


    protected $table      = 'tbl_users_types_rels';
    protected $primaryKey = 'tbl_users_types_rel_ID';


    public $timestamps = false;

    protected $fillable = [

      'tbl_user_ID',
      'tbl_users_type_ID'

    ];


    
  }
