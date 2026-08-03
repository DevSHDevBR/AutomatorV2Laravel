<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class Post extends Model {



    protected $table      = 'tbl_posts';
    protected $primaryKey = 'tbl_post_ID';


    const CREATED_AT = 'tbl_post_created_at';
    const UPDATED_AT = 'tbl_post_updated_at';


    protected $fillable = [

      'tbl_post_slug',
      'tbl_post_title',
      'tbl_post_content',
      'tbl_post_featured_image',
      'tbl_post_status',
      'tbl_post_access',
      'tbl_user_ID',

    ];



    public function GetPostUserTypes() {
    
      return $this->belongsToMany(
        UsersType::class,
        'tbl_posts_access',
        'tbl_post_ID',
        'tbl_users_type_ID',
        'tbl_post_ID',
        'tbl_users_type_ID'
      );
    
    }




  }
