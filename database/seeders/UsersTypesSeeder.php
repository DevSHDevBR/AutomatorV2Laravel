<?php


  namespace Database\Seeders;

  use Illuminate\Database\Seeder;

  use App\Models\UsersType;



  class UsersTypesSeeder extends Seeder {



    /**
     * Run the database seeds.
     */
    public function run(): void {


      UsersType::Create([

        'tbl_users_type_name'        => 'Desenvolvedor',
        'tbl_users_type_description' => 'Usuário responsável por gerenciar e controlar todas as funcionalidades do sistema.',
        'tbl_users_type_locked'      => true,
        'tbl_users_type_status'      => 'ativo'

      ]);


      UsersType::Create([

        'tbl_users_type_name'        => 'Administrador',        
        'tbl_users_type_description' => 'Usuário responsável por administrar todos os conteúdos e informações do sistema.',
        'tbl_users_type_locked'      => true,
        'tbl_users_type_status'      => 'ativo'

      ]);


      UsersType::Create([

        'tbl_users_type_name'        => 'Usuário',
        'tbl_users_type_description' => 'Usuário padrão do sistema com acesso as funcionalidades restritas do sistemas que contem acesso.',
        'tbl_users_type_locked'      => true,
        'tbl_users_type_status'      => 'ativo'

      ]);


      UsersType::Create([

        'tbl_users_type_name'        => 'Novo',
        'tbl_users_type_description' => 'Usuario para testes de desenvolvimento.',
        'tbl_users_type_locked'      => false,
        'tbl_users_type_status'      => 'ativo'

      ]);


    }



  }
