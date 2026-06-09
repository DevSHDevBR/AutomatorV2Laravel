<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;
  use Illuminate\Support\Facades\Hash;


  use App\Models\User;



  class UsersSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {
      
      User::Create([

        'tbl_user_login'    => 'developer',
        'tbl_user_name'     => 'Desenvolvedor',
        'tbl_user_email'    => 'dev@automator.test',
        'tbl_user_password' => Hash::make('dev'),
        'tbl_user_status'   => 'ativo',
        'tbl_user_blocked'  => false,
        'tbl_user_actived'  => true

      ]);


      User::Create([

        'tbl_user_login'    => 'admin',
        'tbl_user_name'     => 'Administrador',
        'tbl_user_email'    => 'admin@automator.test',
        'tbl_user_password' => Hash::make('admin'),
        'tbl_user_status'   => 'ativo',
        'tbl_user_blocked'  => false,
        'tbl_user_actived'  => true

      ]);


      User::Create([

        'tbl_user_login'    => 'user',
        'tbl_user_name'     => 'Usuário',
        'tbl_user_email'    => 'user@automator.test',
        'tbl_user_password' => Hash::make('user'),
        'tbl_user_status'   => 'ativo',
        'tbl_user_blocked'  => false,
        'tbl_user_actived'  => true

      ]);

    }



  }
