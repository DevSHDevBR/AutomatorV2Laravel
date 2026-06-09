<?php


  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;



  class UsersType extends Model {



    protected $table      = 'tbl_users_types';
    protected $primaryKey = 'tbl_users_type_ID';


    const CREATED_AT = 'tbl_users_type_created_at';
    const UPDATED_AT = 'tbl_users_type_updated_at';


    protected $fillable = [

      'tbl_users_type_name',
      'tbl_users_type_description',
      'tbl_users_type_locked',
      'tbl_users_type_status'

    ];



    public function UsersTypeGetUsers() {


      return $this->belongsToMany(
        User::class,
        'tbl_users_types_rels',
        'tbl_users_type_ID',
        'tbl_user_ID',
        'tbl_users_type_ID',
        'tbl_user_ID'
      );


    }



    public function UsersTypeGetRoutes() {


      return $this->belongsToMany(
        SysRoute::class,
        'tbl_sys_routes_access',
        'tbl_users_type_ID',
        'tbl_sys_route_ID',
        'tbl_users_type_ID',
        'tbl_sys_route_ID'
      );


    }


    public static function UsersTypeGetRoutesByID($usersTypeID, $args = []) {


      $retorno = [];


      if($usersTypeID == null || $usersTypeID == '') {

        return $retorno;

      }


      $query = SysRoute::query();

      $query->select('tbl_sys_routes.*');

      $query->join(
        'tbl_sys_routes_access',
        'tbl_sys_routes_access.tbl_sys_route_ID',
        '=',
        'tbl_sys_routes.tbl_sys_route_ID'
      );

      $query->where('tbl_sys_routes_access.tbl_users_type_ID', $usersTypeID);


      if(isset($args['status']) && $args['status'] != '') {

        $query->where('tbl_sys_routes.tbl_sys_route_status', $args['status']);

      }


      if(isset($args['admin'])) {

        $query->where('tbl_sys_routes.tbl_sys_route_admin', $args['admin']);

      }


      if(isset($args['api'])) {

        $query->where('tbl_sys_routes.tbl_sys_route_api', $args['api']);

      }


      if(isset($args['area']) && $args['area'] != '') {

        $query->where('tbl_sys_routes.tbl_sys_route_area', $args['area']);

      }


      if(isset($args['orderBy']) && is_array($args['orderBy']) && count($args['orderBy']) >= 1) {

        foreach($args['orderBy'] as $column => $direction) {

          $query->orderBy($column, $direction);

        }

      } else {

        $query->orderBy('tbl_sys_routes.tbl_sys_route_ID', 'asc');

      }


      $retorno = $query->get()->toArray();

      return $retorno;


    }



    // public function getUsersTypesRoutes() {
      

    //   return $this->belongsToMany(SysRoute::class, 'tbl_usuarios_tipos_tbl_paginas_rel', 'tbl_usuario_tipo_ID', 'tbl_pagina_ID');


    // }



  }
