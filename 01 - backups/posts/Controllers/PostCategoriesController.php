<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\View;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\Storage;
  use Illuminate\Support\Str;

  use App\Models\SysUpload;
  use App\Models\SysUploadsTemp;
  use Posts\Models\Post;
  use Posts\Models\PostsAccess;
  use Posts\Models\PostCategorie;
  use Posts\Models\PostCategoriesAccess;



  class PostCategoriesController extends Controller {


    public function viewPosts($category) {


      return '';


    }

  }