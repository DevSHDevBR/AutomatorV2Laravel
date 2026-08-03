<?php


  namespace Posts\Database\Seeders;

  use Illuminate\Database\Seeder;

  // use App\Models\SysRoute;
  // use App\Models\SysRoutesAccess;

  use Illuminate\Support\Facades\DB;



  class PostsCategorieSeeder extends Seeder {



    private function createModuloRel($table, $column, $value) {


      DB::table('tbl_sys_modulos_rels')->insert([

        'tbl_sys_modulo_rel_name'   => 'posts',
        'tbl_sys_modulo_rel_table'  => $table,
        'tbl_sys_modulo_rel_column' => $column,
        'tbl_sys_modulo_rel_value'  => $value,

      ]);

    
    }



    /**
     * Run the database seeds.
     */
    public function run(): void {
      

      //

      $busca = DB::table('tbl_post_categories')->where('tbl_post_categorie_name', 'sem-categoria')->where('tbl_post_categorie_parent_id', NULL)->count();
      if($busca <= 0) {

        $categorieID = DB::table('tbl_post_categories')->insertGetId([

          'tbl_post_categorie_name'    => 'sem-categoria',
          'tbl_post_categorie_title'   => 'Sem Categoria',
          'tbl_post_categorie_content' => 'Postagens sem categoria especificas',
          'tbl_post_categorie_status'  => 'ativo',
          'tbl_post_categorie_ordem'   => 1,
          'tbl_post_categorie_locked'  => true,
          'tbl_post_categorie_access'  => 'public',
          'tbl_user_ID'                => 1,
        ]);

      }


    }



  }
