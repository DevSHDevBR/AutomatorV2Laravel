<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class PostsCategorie extends Model {



    protected $table      = 'tbl_post_categories';
    protected $primaryKey = 'tbl_post_categorie_ID';


    const CREATED_AT = 'tbl_post_categorie_created_at';
    const UPDATED_AT = 'tbl_post_categorie_updated_at';


    protected $fillable = [

      'tbl_post_categorie_name',
      'tbl_post_categorie_title',
      'tbl_post_categorie_content',
      'tbl_post_categorie_parent_id',
      'tbl_post_categorie_status',
      'tbl_post_categorie_ordem',
      'tbl_post_categorie_access',
      'tbl_user_ID',

    ];



    public function GetPostsCategorieUserTypes() {
    
      return $this->belongsToMany(
        UsersType::class,
        'tbl_post_categories_access',
        'tbl_post_categorie_ID',
        'tbl_users_type_ID',
        'tbl_post_categorie_ID',
        'tbl_users_type_ID'
      );
    
    }




  }
