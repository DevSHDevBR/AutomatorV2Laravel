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
        'tbl_sys_function_name'   => 'translate',
        'tbl_sys_function_fn'     => 'AutomatorTranslate',
        'tbl_sys_function_params' => "{'word': true, 'lang': false}"

      ]);


      SysFunction::Create([

        'tbl_sys_function_type'   => 'custom',
        'tbl_sys_function_name'   => 'sysDateFormat',
        'tbl_sys_function_fn'     => 'AutomatorDateFormat',
        'tbl_sys_function_params' => "{'date': true, 'translate': false}"

      ]);


    }
  


  }