<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class PostCategoriesAccess extends Model {
    


    protected $table      = 'tbl_post_categories_access';
    protected $primaryKey = 'tbl_post_categorie_access_ID';


    public $timestamps = false;

    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_post_categorie_ID'

    ];


    
  }
