<?php


  namespace Posts\Database\Seeders;

  use Illuminate\Database\Seeder;

  // use App\Models\SysRoute;
  // use App\Models\SysRoutesAccess;

  use Illuminate\Support\Facades\DB;



  class PostsSysRoutesSeeder extends Seeder {



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

      $rotas = [


        // VIEW POST - START


          [

            'tbl_sys_route_name'       => 'view-post',
            'tbl_sys_route_permalink'  => '',
            'tbl_sys_route_title'      => 'Visualizar Postagem',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => false,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'PostsController',
            'tbl_sys_route_method'     => 'viewPost',
            'tbl_sys_route_args'       => '{category?}/{name}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'public',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => []

          ],


        // VIEW POST - END


        // VIEW CATEGORIES - START


          [

            'tbl_sys_route_name'       => 'view-post-categories',
            'tbl_sys_route_permalink'  => '',
            'tbl_sys_route_title'      => 'Visualizar Categorias de Post',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => false,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'PostCategoriesController',
            'tbl_sys_route_method'     => 'viewPosts',
            'tbl_sys_route_args'       => '{category}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'public',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => []

          ],


        // VIEW CATEGORIES - END


        // [ADMIN] POSTS PARENT - START


          [

            'tbl_sys_route_name'       => 'admin-posts',
            'tbl_sys_route_permalink'  => 'posts',
            'tbl_sys_route_title'      => 'Posts',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'parentPage',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="system-pages" view="system.pages.automator-parent-pages"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],


        // [ADMIN] POSTS PARENT - END

        // [ADMIN] POSTS CATEGORIAS - START


          [

            'tbl_sys_route_name'       => 'admin-post-categories',
            'tbl_sys_route_permalink'  => 'gerenciar-categorias-de-posts',
            'tbl_sys_route_title'      => 'Gerenciar Categorias de Posts',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-posts-categories-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-categories-preview',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's PREVIEW",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getPreviewDataByModel',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="getPreviewDataByModel" model="PostsCategorie" with="GetPostsCategorieUserTypes:ids" module="Posts"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-categories-get',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's GET",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getDataByModel',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="getDataByModel" model="PostsCategorie" with="GetPostsCategorieUserTypes:ids" module="Posts"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-categories-store',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's STORE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_post_categories" model="PostsCategorie" form="admin-posts-categories" with="GetPostsCategorieUserTypes:ids" module="Posts"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-categories-update',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's UPDATE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="update-data" table="tbl_post_categories" model="PostsCategorie" index="tbl_post_categorie_ID" with="GetPostsCategorieUserTypes:ids" module="Posts"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-categories-delete',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's DELETE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'deleteData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="delete-data" table="tbl_post_categories" model="PostsCategorie" index="tbl_post_categorie_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],

          [

            'tbl_sys_route_name'       => 'admin-api-post-categories-active',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's ACTIVE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'activeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="active-data" table="tbl_post_categories" index="tbl_post_categorie_ID" status="tbl_post_categorie_status"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-categories-desactive',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's DESACTIVE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'desactiveData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="desactive-data" table="tbl_post_categories" index="tbl_post_categorie_ID" status="tbl_post_categorie_status"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],


        // [ADMIN] POSTS CATEGORIAS - END


        // [ADMIN] POSTS - START


          [

            'tbl_sys_route_name'       => 'admin-post',
            'tbl_sys_route_permalink'  => 'gerenciar--posts',
            'tbl_sys_route_title'      => 'Gerenciar Posts',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-posts-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-get',
            'tbl_sys_route_title'      => "API - POST's GET",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getDataByModel',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="getDataByModel" model="Post" with="GetPostUserTypes:ids,GetPostCategories:ids" module="Posts"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-preview',
            'tbl_sys_route_title'      => "API - POST's PREVIEW",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getDataByModel',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="getDataByModel" model="Post" with="GetPostUserTypes:ids,GetPostCategories:ids" module="Posts"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-store',
            'tbl_sys_route_title'      => "API - POST's STORE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'PostsController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-update',
            'tbl_sys_route_title'      => "API - POST's UPDATE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'PostsController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-post-delete',
            'tbl_sys_route_title'      => "API - POST's DELETE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'deleteData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="delete-data" table="tbl_posts" index="tbl_post_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],


        // [ADMIN] POSTS - END


      ];

      foreach ($rotas as $rota) {

        $usersTypes = $rota['user_types'];
        unset($rota['user_types']);

        // Resolve o ID da rota pai
        if (!empty($rota['tbl_sys_route_parent_id'])) {

            $rota['tbl_sys_route_parent_id'] = DB::table('tbl_sys_routes')
                ->where('tbl_sys_route_name', $rota['tbl_sys_route_parent_id'])
                ->value('tbl_sys_route_ID');
        }

        // Insere a rota
        $rotaID = DB::table('tbl_sys_routes')->insertGetId($rota);
        
        $this->createModuloRel('tbl_sys_routes', 'tbl_sys_route_ID', $rotaID);


        // Permissões de acesso
        if (($rota['tbl_sys_route_area'] ?? null) === 'restrict' && count($usersTypes) > 0) {

            $insertAccess = [];

            foreach ($usersTypes as $userTypeID) {

                $insertAccessID = DB::table('tbl_sys_routes_access')->insertGetId(['tbl_users_type_ID' => $userTypeID, 'tbl_sys_route_ID' => $rotaID]);

                $this->createModuloRel('tbl_sys_routes_access', 'tbl_routes_access_ID', $insertAccessID);
                // $insertAccess[] = [
                //     'tbl_users_type_ID' => $userTypeID,
                //     'tbl_sys_route_ID'  => $rotaID,
                // ];

            }

            // DB::table('tbl_sys_routes_access')->insert($insertAccess);

        }

      }


    }



  }
