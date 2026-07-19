<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  use App\Models\SysRoute;
  use App\Models\SysRoutesAccess;



  class SysRoutesSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {
      

      //

      $rotas = [

        [

          'tbl_sys_route_name'       => 'index',
          'tbl_sys_route_title'      => 'Home',
          'tbl_sys_route_permalink'  => '/',
          'tbl_sys_route_api'        => false,
          'tbl_sys_route_admin'      => false,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'GET',
          'tbl_sys_route_controller' => 'SiteController',
          'tbl_sys_route_method'     => 'index',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'tbl_sys_route_parent_id'  => '',
          'user_types'               => []

        ],
        [

          'tbl_sys_route_name'       => 'admin-login',
          'tbl_sys_route_title'      => 'Login',
          'tbl_sys_route_api'        => false,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'GET',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'login',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => []

        ],
        [

          'tbl_sys_route_name'       => 'admin-api-login',
          'tbl_sys_route_title'      => 'API Login',
          'tbl_sys_route_api'        => true,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'POST',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'loginAPI',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => []

        ],
        [

          'tbl_sys_route_name'       => 'admin-esqueci-minha-senha',
          'tbl_sys_route_title'      => 'Esqueci minha senha',
          'tbl_sys_route_api'        => false,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'GET',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'forgetPassword',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => []

        ],
        [

          'tbl_sys_route_name'       => 'admin-api-esqueci-minha-senha',
          'tbl_sys_route_title'      => 'API - Esqueci minha senha',
          'tbl_sys_route_api'        => true,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'POST',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'forgetPasswordAPI',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => []

        ],
        [

          'tbl_sys_route_name'       => 'admin-recuperar-conta',
          'tbl_sys_route_title'      => 'Recuperar conta',
          'tbl_sys_route_api'        => false,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'GET',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'recoverAccount',
          'tbl_sys_route_args'       => '{token}',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => []

        ],
        [

          'tbl_sys_route_name'       => 'admin-api-recuperar-conta',
          'tbl_sys_route_title'      => 'API - Recuperar conta',
          'tbl_sys_route_api'        => true,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'POST',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'recoverAccountAPI',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => []

        ],



        // DASHBOARD - START


          [

            'tbl_sys_route_name'       => 'admin-dashboard',
            'tbl_sys_route_title'      => 'Dashboard',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'SystemController',
            'tbl_sys_route_method'     => 'dashboard',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="system-pages" view="system.pages.dashboard"]</code>',
            // 'tbl_sys_route_content'    => '<code>[system-pages view="system.pages.dashboard"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2, 3, 4]

          ],


        // DASHBOARD - END


        // NOTIFICAÇÕES - START


          [

            'tbl_sys_route_name'       => 'admin-notificacoes',
            'tbl_sys_route_permalink'  => 'notificacoes',
            'tbl_sys_route_title'      => 'Notificações',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-notificacoes-pagination" index="tbl_sys_notification_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2, 3, 4]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-notificacoes',
            'tbl_sys_route_title'      => 'API - Notificações GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="get-data" table="tbl_sys_notifications" index="tbl_sys_notification_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2, 3, 4]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-notificacoes-store',
            'tbl_sys_route_title'      => 'API - Notificações STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_sys_notifications" form="admin-notifications"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2, 3, 4]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-notificacoes-update',
            'tbl_sys_route_title'      => 'API - Notificações UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="update-data" table="tbl_sys_notifications" index="tbl_sys_notification_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2, 3, 4]

          ],


        // NOTIFICAÇÕES - END


        // MINHA CONTA - START


          [

            'tbl_sys_route_name'       => 'admin-minha-conta',
            'tbl_sys_route_title'      => 'Minha Conta',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'SystemController',
            'tbl_sys_route_method'     => 'myAccount',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<p>Utilize o formulário abaixo para atualizar os dados de sua conta. <br /><br /></p><code>[automator function="system-form" form="admin-minha-conta" vars="$currentUser"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2, 3, 4]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-minha-conta',
            'tbl_sys_route_title'      => 'API - Minha Conta',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'SystemController',
            'tbl_sys_route_method'     => 'myAccountAPI',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2, 3, 4]

          ],


        // MINHA CONTA - END



        // GALERIA - START


          [

            'tbl_sys_route_name'       => 'admin-galeria',
            'tbl_sys_route_permalink'  => 'galeria',
            'tbl_sys_route_title'      => 'Galeria',
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


        // GALERIA - END



        // GALERIA => TIPOS DE MIDIA - START


          [

            'tbl_sys_route_name'       => 'admin-galeria-uploads-types',
            'tbl_sys_route_title'      => 'Gerenciar Tipos de Midia',
            'tbl_sys_route_permalink'  => 'gerenciar-tipos-de-midia',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-midia-types-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-types-get',
            'tbl_sys_route_title'      => 'API - Tipos de Midia GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_sys_field_types" index="tbl_sys_field_type_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-types-store',
            'tbl_sys_route_title'      => 'API - Tipos de Midia STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_sys_uploads_types" form="admin-midia-types"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-types-update',
            'tbl_sys_route_title'      => 'API - Tipos de Midia UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="update-data" table="tbl_sys_uploads_types" index="tbl_sys_uploads_type_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-types-delete',
            'tbl_sys_route_title'      => 'API - Tipos de Midia DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'deleteData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],


        // GALERIA => TIPOS DE MIDIA - END



        // GALERIA => UPLOADS - START


          [

            'tbl_sys_route_name'       => 'admin-galeria-uploads',
            'tbl_sys_route_title'      => 'Gerenciar Uploads',
            'tbl_sys_route_permalink'  => 'gerenciar-uplodas',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'UploadsController',
            'tbl_sys_route_method'     => 'index',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-get',
            'tbl_sys_route_title'      => 'API - Uploads GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_sys_field_types" index="tbl_sys_field_type_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-store',
            'tbl_sys_route_title'      => 'API - Uploads STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UploadsController',
            'tbl_sys_route_method'     => 'storeUpload',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-update',
            'tbl_sys_route_title'      => 'API - Uploads UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UploadsController',
            'tbl_sys_route_method'     => 'updateUpload',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-galeria-uploads-delete',
            'tbl_sys_route_title'      => 'API - Uploads DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UploadsController',
            'tbl_sys_route_method'     => 'deleteUpload',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-galeria',
            'user_types'               => [1, 2]

          ],


        // GALERIA => UPLOADS - END
        


        // ADMINISTRAÇÃO - START


          [

            'tbl_sys_route_name'       => 'admin-administracao',
            'tbl_sys_route_permalink'  => 'administracao',
            'tbl_sys_route_title'      => 'Administração',
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


        // ADMINISTRAÇÃO - END



        // ROTAS / API's - START


          [

            'tbl_sys_route_name'       => 'admin-routes-apis',
            'tbl_sys_route_permalink'  => 'gerenciar-rotas-apis',
            'tbl_sys_route_title'      => 'Gerenciar Rotas de API',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-apis-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-apis-get',
            'tbl_sys_route_title'      => "API - API's GET",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_sys_routes" index="tbl_sys_route_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-apis-store',
            'tbl_sys_route_title'      => "API - API's STORE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'storeRoute',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-apis-update',
            'tbl_sys_route_title'      => "API - API's UPDATE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'updateRoute',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-apis-delete',
            'tbl_sys_route_title'      => "API - API's DELETE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'deleteRoute',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-apis-access',
            'tbl_sys_route_title'      => "API - API's Permissões",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'getRouteAccess',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-apis-access-update',
            'tbl_sys_route_title'      => "API - API's Permissões UPDATE",
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'updateRouteAccess',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],


        // ROTAS / API's - END



        // ROTAS / PAGINAS - START


          [

            'tbl_sys_route_name'       => 'admin-routes',
            'tbl_sys_route_permalink'  => 'gerenciar-paginas',
            'tbl_sys_route_title'      => 'Gerenciar Páginas',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-routes-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-get',
            'tbl_sys_route_title'      => 'API - Páginas GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="get-data" table="tbl_sys_routes" index="tbl_sys_route_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-store',
            'tbl_sys_route_title'      => 'API - Páginas STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'storeRoute',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-update',
            'tbl_sys_route_title'      => 'API - Páginas UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'updateRoute',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-delete',
            'tbl_sys_route_title'      => 'API - Páginas DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'deleteRoute',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-access',
            'tbl_sys_route_title'      => 'API - Páginas Permissões',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'getRouteAccess',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-routes-access-update',
            'tbl_sys_route_title'      => 'API - Páginas Permissões UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'RoutesController',
            'tbl_sys_route_method'     => 'updateRouteAccess',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],


        // ROTAS / PAGINAS - END



        // NAVS - START

          [

            'tbl_sys_route_name'       => 'admin-navs',
            'tbl_sys_route_permalink'  => 'gerenciar-navs',
            'tbl_sys_route_title'      => 'Gerenciar Navegação',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-navs-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-navs-get',
            'tbl_sys_route_title'      => 'API - Navs GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_sys_navs" index="tbl_sys_nav_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-navs-store',
            'tbl_sys_route_title'      => 'API - Navs STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            // 'tbl_sys_route_controller' => 'NavsController',
            // 'tbl_sys_route_method'     => 'storeNav',
            // 'tbl_sys_route_args'       => '',
            // 'tbl_sys_route_content'    => '',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_sys_navs" form="admin-navs"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-navs-update',
            'tbl_sys_route_title'      => 'API - Navs UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="update-data" table="tbl_sys_navs" index="tbl_sys_nav_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-navs-delete',
            'tbl_sys_route_title'      => 'API - Navs DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'NavsController',
            'tbl_sys_route_method'     => 'deleteNav',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],

        // NAVS - END
        


        // MENUS - START


          [

            'tbl_sys_route_name'       => 'admin-menus',
            'tbl_sys_route_permalink'  => 'gerenciar-menus',
            'tbl_sys_route_title'      => 'Gerenciar Menus',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'MenusController',
            'tbl_sys_route_method'     => 'index',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="system-pages" view="system.pages.gerenciar-menu" vars="$adminMenuPage"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-menus-select',
            'tbl_sys_route_title'      => 'API - Menu SELECT',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'MenusController',
            'tbl_sys_route_method'     => 'selectMenu',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-menus-update',
            'tbl_sys_route_title'      => 'API - Menu UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'MenusController',
            'tbl_sys_route_method'     => 'updateMenu',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-administracao',
            'user_types'               => [1, 2]

          ],


        // MENUS - END



        // USERS - START


          [

            'tbl_sys_route_name'       => 'admin-usuarios',
            'tbl_sys_route_permalink'  => 'usuarios',
            'tbl_sys_route_title'      => 'Usuários',
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


        // USERS - END



        // TIPOS DE USUARIOS - START


          [

            'tbl_sys_route_name'       => 'admin-users-types',
            'tbl_sys_route_permalink'  => 'gerenciar-tipos-de-usuarios',
            'tbl_sys_route_title'      => 'Gerenciar Tipos de Usuários',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-users-types-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-types-get',
            'tbl_sys_route_title'      => 'API - Tipo de Usuário GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_users_types" index="tbl_users_type_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-types-store',
            'tbl_sys_route_title'      => 'API - Tipo de Usuário STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_users_types" form="admin-users-types"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-types-update',
            'tbl_sys_route_title'      => 'API - Tipo de Usuário UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="update-data" table="tbl_users_types" index="tbl_users_type_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          // [

          //   'tbl_sys_route_name'       => 'admin-users-types-update',
          //   'tbl_sys_route_title'      => 'API - Tipo de Usuário UPDATE',
          //   'tbl_sys_route_api'        => true,
          //   'tbl_sys_route_admin'      => true,
          //   'tbl_sys_route_locked'     => true,
          //   'tbl_sys_route_type'       => 'POST',
          //   'tbl_sys_route_controller' => 'UsersTypesController',
          //   'tbl_sys_route_method'     => 'updateUserType',
          //   'tbl_sys_route_args'       => '{id?}',
          //   'tbl_sys_route_content'    => '',
          //   'tbl_sys_route_area'       => 'restrict',
          //   'tbl_sys_route_status'     => 'ativo',
          //   'user_types'               => [1, 2]

          // ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-types-delete',
            'tbl_sys_route_title'      => 'API - Tipo de Usuário DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UsersTypesController',
            'tbl_sys_route_method'     => 'deleteUserType',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-types-access',
            'tbl_sys_route_title'      => 'API - Tipo de Usuário Permissões',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'UsersTypesController',
            'tbl_sys_route_method'     => 'getUserTypeAccess',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-types-access-update',
            'tbl_sys_route_title'      => 'API - Tipo de Usuário Permissões UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UsersTypesController',
            'tbl_sys_route_method'     => 'updateUserTypeAccess',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],


        // TIPOS DE USUARIOS - END



        // USUARIOS - START


          [

            'tbl_sys_route_name'       => 'admin-users',
            'tbl_sys_route_permalink'  => 'gerenciar-usuarios',
            'tbl_sys_route_title'      => 'Gerenciar Usuários',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-users-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-get',
            'tbl_sys_route_title'      => 'API - Usuário GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getDataByModel',
            'tbl_sys_route_args'       => '{id?}',
            // 'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_users" index="tbl_user_ID"]</code>',
            'tbl_sys_route_content'    => '<code>[automator function="getDataByModel" model="User" with="UserGetTypes:ids"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-store',
            'tbl_sys_route_title'      => 'API - Usuário STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="store-data" table="tbl_users" model="User" form="admin-users" with="UserGetTypes:ids"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-update',
            'tbl_sys_route_title'      => 'API - Usuário UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'updateData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="update-data" table="tbl_users" index="tbl_user_ID" with="UserGetTypes:ids"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-users-delete',
            'tbl_sys_route_title'      => 'API - Usuário DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UsersController',
            'tbl_sys_route_method'     => 'deleteUser',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-usuarios',
            'user_types'               => [1, 2]

          ],


        // USUARIOS - END



        // NOTIFICAÇÕES - START


          [

            'tbl_sys_route_name'       => 'admin-notifications',
            'tbl_sys_route_permalink'  => 'gerenciar-notificacoes',
            'tbl_sys_route_title'      => 'Gerenciar Notificações',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-notifications-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-notifications-get',
            'tbl_sys_route_title'      => 'API - Gerenciar Notificações GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="get-data" table="tbl_sys_notifications" index="tbl_sys_notification_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-notifications-store',
            'tbl_sys_route_title'      => 'API - Gerenciar Notificações STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'storeData',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_sys_notifications" form="admin-notifications"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-notifications-update',
            'tbl_sys_route_title'      => 'API - Gerenciar Notificações UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UsersController',
            'tbl_sys_route_method'     => 'updateUser',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-notifications-delete',
            'tbl_sys_route_title'      => 'API - Gerenciar Notificações DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'UsersController',
            'tbl_sys_route_method'     => 'deleteUser',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],


        // NOTIFICAÇÕES - END



        // CONFIGURAÇÕES - START


          [

            'tbl_sys_route_name'       => 'admin-configs',
            'tbl_sys_route_permalink'  => 'configuracoes',
            'tbl_sys_route_title'      => 'Configurações',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'SystemController',
            'tbl_sys_route_method'     => 'configs',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="system-pages" view="system.pages.configs"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-configs-update',
            'tbl_sys_route_title'      => 'API - Configurações UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'SystemController',
            'tbl_sys_route_method'     => 'storeConfigs',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],


        // CONFIGURAÇÕES - END



        // AUTOMATOR - START


          [

            'tbl_sys_route_name'       => 'admin-automator',
            'tbl_sys_route_permalink'  => 'automator',
            'tbl_sys_route_title'      => 'Automator',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'index',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="system-pages" view="system.pages.automator-index"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],


        // AUTOMATOR - END



        // AUTOMATOR => FIELDS - START


          [

            'tbl_sys_route_name'       => 'admin-fields',
            'tbl_sys_route_title'      => 'Gerenciar Campos',
            'tbl_sys_route_permalink'  => 'gerenciar-campos',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-fields-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-fields-get',
            'tbl_sys_route_title'      => 'API - Campos GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '[automator function="get-data" table="tbl_sys_field_types" index="tbl_sys_field_type_ID"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-fields-store',
            'tbl_sys_route_title'      => 'API - Campos STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FieldsTypesController',
            'tbl_sys_route_method'     => 'storeField',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-fields-update',
            'tbl_sys_route_title'      => 'API - Campos UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FieldsTypesController',
            'tbl_sys_route_method'     => 'updateField',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-fields-delete',
            'tbl_sys_route_title'      => 'API - Campos DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FieldsTypesController',
            'tbl_sys_route_method'     => 'deleteField',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],


        // AUTOMATOR => FIELDS - END



        // AUTOMATOR => MODULOS - START


          [

            'tbl_sys_route_name'       => 'admin-modulos',
            'tbl_sys_route_title'      => 'Gerenciar Módulos',
            'tbl_sys_route_permalink'  => 'gerenciar-modulos',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-modulos-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-modulos-get',
            'tbl_sys_route_title'      => 'API - Módulos GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_sys_modulos" index="tbl_sys_modulo_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-modulos-store',
            'tbl_sys_route_title'      => 'API - Módulos STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'ModulosController',
            'tbl_sys_route_method'     => 'storeModulo',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-modulos-update',
            'tbl_sys_route_title'      => 'API - Módulos UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'ModulosController',
            'tbl_sys_route_method'     => 'updateModulo',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-modulos-delete',
            'tbl_sys_route_title'      => 'API - Módulos DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'ModulosController',
            'tbl_sys_route_method'     => 'deleteModulo',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],


        // AUTOMATOR => MODULOS - END



        // AUTOMATOR => FORMS - START


          [

            'tbl_sys_route_name'       => 'admin-forms',
            'tbl_sys_route_title'      => 'Gerenciar Formulários',
            'tbl_sys_route_permalink'  => 'gerenciar-formularios',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-forms-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-forms-get',
            'tbl_sys_route_title'      => 'API - Formulários GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => false,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'FormsController',
            'tbl_sys_route_method'     => 'getForm',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'public',
            'tbl_sys_route_status'     => 'ativo',
            // 'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => []

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-forms-editor-field',
            'tbl_sys_route_title'      => 'API - Editor Field POST',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => false,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FormsController',
            'tbl_sys_route_method'     => 'getFormEditorField',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'public',
            'tbl_sys_route_status'     => 'ativo',
            // 'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => []

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-forms-store',
            'tbl_sys_route_title'      => 'API - Formulários STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FormsController',
            'tbl_sys_route_method'     => 'storeForm',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-forms-update',
            'tbl_sys_route_title'      => 'API - Formulários UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FormsController',
            'tbl_sys_route_method'     => 'updateForm',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-forms-delete',
            'tbl_sys_route_title'      => 'API - Formulários DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FormsController',
            'tbl_sys_route_method'     => 'deleteForm',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-forms-access',
            'tbl_sys_route_title'      => 'API - Formulários Permissões',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'FormsController',
            'tbl_sys_route_method'     => 'getFormAccess',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-forms-access-update',
            'tbl_sys_route_title'      => 'API - Formulários Permissões UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'FormsController',
            'tbl_sys_route_method'     => 'updateFormAccess',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],


        // AUTOMATOR => FORMS - END



        // AUTOMATOR => PAGINATIONS - START


          [

            'tbl_sys_route_name'       => 'admin-paginations',
            'tbl_sys_route_title'      => 'Gerenciar Paginações',
            'tbl_sys_route_permalink'  => 'gerenciar-paginacoes',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-paginations-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-paginations-get',
            'tbl_sys_route_title'      => 'API - Paginations GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'PaginationsController',
            'tbl_sys_route_method'     => 'getPagination',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-paginations-store',
            'tbl_sys_route_title'      => 'API - Paginations STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'PaginationsController',
            'tbl_sys_route_method'     => 'storePagination',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-paginations-update',
            'tbl_sys_route_title'      => 'API - Paginations UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'PaginationsController',
            'tbl_sys_route_method'     => 'updatePagination',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-paginations-delete',
            'tbl_sys_route_title'      => 'API - Paginations DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'PaginationsController',
            'tbl_sys_route_method'     => 'deletePagination',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],


        // AUTOMATOR => PAGINATIONS - END



        // AUTOMATOR => SHORTCODES - START


          [

            'tbl_sys_route_name'       => 'admin-shortcodes',
            'tbl_sys_route_title'      => 'Gerenciar Shortcodes',
            'tbl_sys_route_permalink'  => 'gerenciar-shortcodes',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-shortcodes-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-shortcodes-get',
            'tbl_sys_route_title'      => 'API - Shortcodes GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getData',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="get-data" table="tbl_sys_shortcodes" index="tbl_sys_shortcode_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => '',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-shortcodes-store',
            'tbl_sys_route_title'      => 'API - Shortcodes STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '[automator function="store-data" table="tbl_sys_shortcodes" form="admin-shortcodes"]',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-shortcodes-update',
            'tbl_sys_route_title'      => 'API - Shortcodes UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="update-data" table="tbl_sys_shortcodes" form="admin-shortcodes" index="tbl_sys_shortcode_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-shortcodes-delete',
            'tbl_sys_route_title'      => 'API - Shortcodes DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '<code>[automator function="delete-data" table="tbl_sys_shortcodes" index="tbl_sys_shortcode_ID"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-automator',
            'user_types'               => [1, 2]

          ],


        // AUTOMATOR => SHORTCODES - END



        // IDIOMAS - START


          [

            'tbl_sys_route_name'       => 'admin-languages',
            'tbl_sys_route_title'      => 'Gerenciar Idiomas',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'AutomatorController',
            'tbl_sys_route_method'     => 'getFunction',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '<code>[automator function="pagination" name="admin-languages-pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-languages-get',
            'tbl_sys_route_title'      => 'API - Idiomas GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'TranslationsController',
            'tbl_sys_route_method'     => 'getTranslation',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-languages-store',
            'tbl_sys_route_title'      => 'API - Idiomas STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'TranslationsController',
            'tbl_sys_route_method'     => 'storeTranslation',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-languages-update',
            'tbl_sys_route_title'      => 'API - Idiomas UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'TranslationsController',
            'tbl_sys_route_method'     => 'updateTranslation',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-languages-delete',
            'tbl_sys_route_title'      => 'API - Idiomas DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'TranslationsController',
            'tbl_sys_route_method'     => 'deleteTranslation',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],


          [

            'tbl_sys_route_name'       => 'admin-languages-words',
            'tbl_sys_route_title'      => 'Gerenciar Idiomas - Traduções',
            'tbl_sys_route_api'        => false,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'TranslationsWordsController',
            'tbl_sys_route_method'     => 'index',
            'tbl_sys_route_args'       => '{lang?}',
            'tbl_sys_route_content'    => '<code>[automator function="system-pages" view="system.pages.pagination"]</code>',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'tbl_sys_route_parent_id'  => 'admin-languages',
            'user_types'               => [1, 2]

          ],

          [

            'tbl_sys_route_name'       => 'admin-api-languages-words-get',
            'tbl_sys_route_title'      => 'API - Idiomas Traduções GET',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'GET',
            'tbl_sys_route_controller' => 'TranslationsWordsController',
            'tbl_sys_route_method'     => 'getTranslationWord',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-languages-words-store',
            'tbl_sys_route_title'      => 'API - Idiomas Traduções STORE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'TranslationsWordsController',
            'tbl_sys_route_method'     => 'storeTranslationWord',
            'tbl_sys_route_args'       => '',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-languages-words-update',
            'tbl_sys_route_title'      => 'API - Idiomas Traduções UPDATE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'TranslationsWordsController',
            'tbl_sys_route_method'     => 'updateTranslationWord',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],
          [

            'tbl_sys_route_name'       => 'admin-api-languages-words-delete',
            'tbl_sys_route_title'      => 'API - Idiomas Traduções DELETE',
            'tbl_sys_route_api'        => true,
            'tbl_sys_route_admin'      => true,
            'tbl_sys_route_locked'     => true,
            'tbl_sys_route_type'       => 'POST',
            'tbl_sys_route_controller' => 'TranslationsWordsController',
            'tbl_sys_route_method'     => 'deleteTranslationWord',
            'tbl_sys_route_args'       => '{id?}',
            'tbl_sys_route_content'    => '',
            'tbl_sys_route_area'       => 'restrict',
            'tbl_sys_route_status'     => 'ativo',
            'user_types'               => [1, 2]

          ],


        // IDIOMAS - END


        [

          'tbl_sys_route_name'       => 'admin-api-functions',
          'tbl_sys_route_title'      => 'API - Funções Admin',
          'tbl_sys_route_api'        => true,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'POST',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'adminFunctions',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'restrict',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => [1, 2, 3, 4]

        ],

        [

          'tbl_sys_route_name'       => 'admin-api-view-get',
          'tbl_sys_route_title'      => 'API - Get Views',
          'tbl_sys_route_api'        => true,
          'tbl_sys_route_admin'      => false,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'POST',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'adminGetView',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'public',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => [1, 2, 3, 4]

        ],


        [

          'tbl_sys_route_name'       => 'admin-api-logout',
          'tbl_sys_route_title'      => 'API - Logout',
          'tbl_sys_route_api'        => true,
          'tbl_sys_route_admin'      => true,
          'tbl_sys_route_locked'     => true,
          'tbl_sys_route_type'       => 'POST',
          'tbl_sys_route_controller' => 'SystemController',
          'tbl_sys_route_method'     => 'logout',
          'tbl_sys_route_args'       => '',
          'tbl_sys_route_content'    => '',
          'tbl_sys_route_area'       => 'restrict',
          'tbl_sys_route_status'     => 'ativo',
          'user_types'               => [1, 2, 3, 4]

        ],

      ];


      foreach ($rotas as $rota) {

        $users_types = $rota['user_types'];
        unset($rota['user_types']);
        if(isset($rota['tbl_sys_route_parent_id'])) {

          if($rota['tbl_sys_route_parent_id'] != '') {

            $rota['tbl_sys_route_parent_id'] = SysRoute::getRouteIDByName($rota['tbl_sys_route_parent_id']);

          }

        }

        $route = SysRoute::create($rota);

        $rotaID = $route->getKey();

        if (($rota['tbl_sys_route_area'] ?? null) === 'restrict') {

          if(count($users_types) >= 1) {

            foreach ($users_types as $userTypeID) {

              SysRoutesAccess::create([
                'tbl_users_type_ID' => $userTypeID,
                'tbl_sys_route_ID'  => $rotaID,
              ]);

            }

          }

        }

      }


    }



  }
