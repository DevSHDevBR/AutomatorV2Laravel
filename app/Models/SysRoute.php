<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class SysRoute extends Model {
    
    

    protected $table      = 'tbl_sys_routes';
    protected $primaryKey = 'tbl_sys_route_ID';


    const CREATED_AT = 'tbl_sys_route_created_at';
    const UPDATED_AT = 'tbl_sys_route_updated_at';


    protected $fillable = [

      'tbl_sys_route_name',
      'tbl_sys_route_title',
      'tbl_sys_route_permalink',
      'tbl_sys_route_api',
      'tbl_sys_route_admin',
      'tbl_sys_route_locked',
      'tbl_sys_route_type',
      'tbl_sys_route_controller',
      'tbl_sys_route_method',
      'tbl_sys_route_args',
      'tbl_sys_route_content',
      'tbl_sys_route_description',
      'tbl_sys_route_area',
      'tbl_sys_route_status',
      'tbl_sys_route_parent_id'

    ];


    /*
    |--------------------------------------------------------------------------
    | Relacionamento: Rota → Tipos de Usuário
    |--------------------------------------------------------------------------
    |
    | Espelho de UsersType::UsersTypeGetRoutes().
    | Retorna todos os UsersType vinculados a esta rota
    | através da tabela pivot tbl_sys_routes_access.
    |
    */

    public function SysRouteGetUsersTypes() {


      return $this->belongsToMany(
        UsersType::class,
        'tbl_sys_routes_access',
        'tbl_sys_route_ID',
        'tbl_users_type_ID',
        'tbl_sys_route_ID',
        'tbl_users_type_ID'
      );


    }


    public static function getRouteIDByName($name) {

      return self::where('tbl_sys_route_name', $name)->value('tbl_sys_route_ID');
      
    }



    public static function getRoutes($args = []) {


      $query = self::query();

      if (count($args) >= 1) {

        $where = (isset($args['where']) ? $args['where'] : []);

        if (count($where) >= 1) {

          foreach ($where as $column => $value) {

            $query->where($column, $value);

          }

        }


        $whereIn = (isset($args['whereIn']) ? $args['whereIn'] : []);

        if (count($whereIn) >= 1) {

          foreach ($whereIn as $column => $values) {

            if (is_array($values) && count($values) >= 1) {

              $query->whereIn($column, $values);

            }

          }

        }


        $whereNotIn = (isset($args['whereNotIn']) ? $args['whereNotIn'] : []);

        if (count($whereNotIn) >= 1) {

          foreach ($whereNotIn as $column => $values) {

            if (is_array($values) && count($values) >= 1) {

              $query->whereNotIn($column, $values);

            }

          }

        }


        if (isset($args['orderBy']) && is_array($args['orderBy']) && count($args['orderBy']) >= 1) {

          foreach ($args['orderBy'] as $column => $direction) {

            $query->orderBy($column, $direction);

          }

        }

      }
      

      return $query->get()->toArray();


    }



    public static function getWebAPIRoutes($routes = []) {


      $retorno = [];

      if (!is_array($routes) || count($routes) <= 0) {

        return $retorno;

      }

      $retorno = self::whereIn('tbl_sys_route_name', $routes)
        ->where('tbl_sys_route_status', 'ativo')
        ->where('tbl_sys_route_api', true)
        ->get()
        ->toArray();

      return $retorno;


    }



  }