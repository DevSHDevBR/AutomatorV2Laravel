<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  // use App\Models\SysRoute;
  // use App\Models\SysRoutesAccess;

  use Illuminate\Support\Facades\DB;



  class SysRoutesSeeder extends Seeder {



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



        // POSTS - START


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


        // POSTS - END

        // CATEGORIAS - START


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

            'tbl_sys_route_name'       => 'admin-api-post-categories-get',
            'tbl_sys_route_title'      => "API - POST CATEGORIE's GET",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getDataByModel',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="getDataByModel" model="PostsCategorie" with="GetPostsCategorieUserTypes:ids"]',
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
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_post_categories" model="PostsCategorie" form="admin-posts-categories" with="GetPostsCategorieUserTypes:ids"]',
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
            'tbl_sys_route_content'    => '[automator function="update-data" table="tbl_post_categories" index="tbl_post_categorie_ID" with="GetPostsCategorieUserTypes:ids"]',
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
            'tbl_sys_route_content'    => '[automator function="delete-data" table="tbl_post_categories" index="tbl_post_categorie_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-posts',
            'user_types'               => [1, 2]

          ],


        // CATEGORIAS - END


        // POST - START


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
            'tbl_sys_route_content'    => '[automator function="getDataByModel" model="Post" with="GetPostUserTypes:ids"]',
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
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_posts" model="Post" form="admin-posts" with="GetPostUserTypes:ids"]',
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
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="update-data" table="tbl_posts" index="tbl_post_ID" with="GetPostUserTypes:ids"]',
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


        // POST - END


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

        // Permissões de acesso
        if (($rota['tbl_sys_route_area'] ?? null) === 'restrict' && count($usersTypes) > 0) {

            $insertAccess = [];

            foreach ($usersTypes as $userTypeID) {

                $insertAccess[] = [
                    'tbl_users_type_ID' => $userTypeID,
                    'tbl_sys_route_ID'  => $rotaID,
                ];

            }

            DB::table('tbl_sys_routes_access')->insert($insertAccess);

        }

    }
      // foreach ($rotas as $rota) {

      //   $users_types = $rota['user_types'];
      //   unset($rota['user_types']);
      //   if(isset($rota['tbl_sys_route_parent_id'])) {

      //     if($rota['tbl_sys_route_parent_id'] != '') {

      //       $rota['tbl_sys_route_parent_id'] = SysRoute::getRouteIDByName($rota['tbl_sys_route_parent_id']);

      //     }

      //   }

      //   $route = SysRoute::create($rota);

      //   $rotaID = $route->getKey();

      //   if (($rota['tbl_sys_route_area'] ?? null) === 'restrict') {

      //     if(count($users_types) >= 1) {

      //       foreach ($users_types as $userTypeID) {

      //         SysRoutesAccess::create([
      //           'tbl_users_type_ID' => $userTypeID,
      //           'tbl_sys_route_ID'  => $rotaID,
      //         ]);

      //       }

      //     }

      //   }

      // }


    }



  }
