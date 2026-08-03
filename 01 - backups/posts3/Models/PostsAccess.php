<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class PostsAccess extends Model {
    


    protected $table      = 'tbl_posts_access';
    protected $primaryKey = 'tbl_posts_access_ID';


    public $timestamps = false;

    protected $fillable = [

      'tbl_users_type_ID',
      'tbl_post_ID'

    ];


    
  }
