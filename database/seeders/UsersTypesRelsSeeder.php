<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  use App\Models\UsersTypesRel;



  class UsersTypesRelsSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {


      UsersTypesRel::Create([

        'tbl_user_ID'       => 1,
        'tbl_users_type_ID' => 3,

      ]);

      UsersTypesRel::Create([

        'tbl_user_ID'       => 1,
        'tbl_users_type_ID' => 1

      ]);



      UsersTypesRel::Create([

        'tbl_user_ID'       => 2,
        'tbl_users_type_ID' => 3

      ]);

      UsersTypesRel::Create([

        'tbl_user_ID'       => 2,
        'tbl_users_type_ID' => 2

      ]);


      UsersTypesRel::Create([

        'tbl_user_ID'       => 3,
        'tbl_users_type_ID' => 3

      ]);


    }



  }
