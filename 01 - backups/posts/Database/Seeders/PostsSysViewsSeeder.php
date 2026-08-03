<?php


  namespace Posts\Database\Seeders;

  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\DB;
  



  class PostsSysViewsSeeder extends Seeder {


    private function createModuloRel($table, $column, $value) {

      DB::table('tbl_sys_modulos_rels')->insert([
        'tbl_sys_modulo_rel_name'   => 'posts',
        'tbl_sys_modulo_rel_table'  => $table,
        'tbl_sys_modulo_rel_column' => $column,
        'tbl_sys_modulo_rel_value'  => $value,
      ]);

    }


    public function run(): void {


      $views = [

        [

          'tbl_sys_view_name'        => 'posts-list-categories',
          'tbl_sys_view_title'       => 'Visualização de Categorias',
          'tbl_sys_view_description' => 'Visualização de categoria de posts.',
          'tbl_sys_view_directory'   => '/storage/app/modulos/posts/Resourses/views/',
          'tbl_sys_view_file'        => 'list-categories.blade.php',
          'tbl_sys_view_args'        => '',
          'tbl_sys_view_status'      => 'ativo',
          'tbl_sys_view_locked'      => true,

        ],

        [
          
          'tbl_sys_view_name'        => 'posts-list-categories-posts',
          'tbl_sys_view_title'       => 'Visualização de Posts da Categoria',
          'tbl_sys_view_description' => 'Visualização dos posts de uma categoria.',
          'tbl_sys_view_directory'   => '/storage/app/modulos/posts/Resourses/views/',
          'tbl_sys_view_file'        => 'list-categories-posts.blade.php',
          'tbl_sys_view_args'        => '',
          'tbl_sys_view_status'      => 'ativo',
          'tbl_sys_view_locked'      => true,

        ],

        [
          
          'tbl_sys_view_name'        => 'posts-view-post',
          'tbl_sys_view_title'       => 'Visualização de um Post',
          'tbl_sys_view_description' => 'Página de visualização de um post',
          'tbl_sys_view_directory'   => '/storage/app/modulos/posts/Resourses/views/',
          'tbl_sys_view_file'        => 'view-post.blade.php',
          'tbl_sys_view_args'        => '',
          'tbl_sys_view_status'      => 'ativo',
          'tbl_sys_view_locked'      => true,

        ],

      ];



      foreach ($views as $view) {

        $viewID = DB::table('tbl_sys_views')->insertGetId($view);

        $this->createModuloRel('tbl_sys_views', 'tbl_sys_view_ID', $viewID);

      }


    }


  }