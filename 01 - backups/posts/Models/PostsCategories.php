<?php


  namespace Posts\Models;

  use Illuminate\Database\Eloquent\Model;



  class PostsCategories extends Model {



    protected $table      = 'tbl_posts_categories';
    protected $primaryKey = 'tbl_posts_categories_ID';


    public $timestamps = false;


    protected $fillable = [

      'tbl_post_ID',
      'tbl_post_categorie_ID',

    ];




  }
