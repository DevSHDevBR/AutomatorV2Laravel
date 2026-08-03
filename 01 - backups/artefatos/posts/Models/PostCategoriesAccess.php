<?php


  namespace Posts\Models;

  use Illuminate\Database\Eloquent\Model;
  use App\Models\UsersType;



  class PostCategoriesAccess extends Model {
    


    protected $table      = 'tbl_post_categories_access';
    protected $primaryKey = 'tbl_post_categorie_access_ID';


    public $timestamps = false;

    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_post_categorie_ID'

    ];


    
  }
