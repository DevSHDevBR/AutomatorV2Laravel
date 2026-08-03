<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;


  use App\Models\SysFunction;



  class SysFunctionsSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {
      
      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysTranslations',
        'tbl_sys_function_fn'     => 'AutomatorGetTranslations',
        'tbl_sys_function_params' => "",
        'tbl_sys_function_props'  => "",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysTranslate',
        'tbl_sys_function_fn'     => 'AutomatorTranslate',
        'tbl_sys_function_params' => "{ 'word': true, 'lang': false }",
        'tbl_sys_function_props'  => "{ 'lang': @SysFunctions['sysTranslations'] }",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysDateFormat',
        'tbl_sys_function_fn'     => 'AutomatorDateFormat',
        'tbl_sys_function_params' => "{ 'date': true, 'translate': false }",
        'tbl_sys_function_props'  => "",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetRouteDataInfo',
        'tbl_sys_function_fn'     => 'AutomatorGetRouteDataInfo',
        'tbl_sys_function_params' => "",
        'tbl_sys_function_props'  => "",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetCurrentRouteData',
        'tbl_sys_function_fn'     => 'AutomatorGetCurrentRouteData',
        'tbl_sys_function_params' => "{ 'data': true }",
        'tbl_sys_function_props'  => "{ 'data': @SysFunctions['sysGetRouteDataInfo'] }",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetRouteData',
        'tbl_sys_function_fn'     => 'AutomatorGetRouteData',
        'tbl_sys_function_params' => "{ 'data': true, 'route': true }",
        'tbl_sys_function_props'  => "{ 'data': @SysFunctions['sysGetRouteDataInfo'] }",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetUserDataInfo',
        'tbl_sys_function_fn'     => 'AutomatorGetUserDataInfo',
        'tbl_sys_function_params' => "",
        'tbl_sys_function_props'  => "",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetUserData',
        'tbl_sys_function_fn'     => 'AutomatorGetUserData',
        'tbl_sys_function_params' => "{ 'data': true, 'user': true }",
        'tbl_sys_function_props'  => "{ 'data': @SysFunctions['sysGetUserDataInfo'] }",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetCurrentUserData',
        'tbl_sys_function_fn'     => 'AutomatorGetCurrentUserData',
        'tbl_sys_function_params' => "{ 'data': true }",
        'tbl_sys_function_props'  => "{ 'data': @SysFunctions['sysGetUserDataInfo'] }",

      ]);

      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetTableListWithOrder',
        'tbl_sys_function_fn'     => 'AutomatorGetTableListWithOrder',
        'tbl_sys_function_params' => "",
        'tbl_sys_function_props'  => "",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetTableOrderValue',
        'tbl_sys_function_fn'     => 'AutomatorGetTableOrderValue',
        'tbl_sys_function_params' => "{ 'table': true }",
        'tbl_sys_function_props'  => "{ 'table': @SysFunctions['sysGetTableListWithOrder'] }",

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysGetCurrentItemData',
        'tbl_sys_function_fn'     => 'AutomatorGetCurrentItemValue',
        'tbl_sys_function_params' => "{ 'table': true, 'field': true, current: false }",
        'tbl_sys_function_props'  => "{ 'table': @SysFunctions['sysGetTableList'] }",

      ]);


    }
  


  }