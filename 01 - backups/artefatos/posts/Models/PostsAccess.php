<?php


  namespace Posts\Models;

  use Illuminate\Database\Eloquent\Model;
  use App\Models\UsersType;



  class PostsAccess extends Model {
    


    protected $table      = 'tbl_posts_access';
    protected $primaryKey = 'tbl_posts_access_ID';


    public $timestamps = false;

    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_post_ID'

    ];


    
  }
