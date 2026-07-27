<?php


  namespace Database\Seeders;


  use Illuminate\Database\Seeder;


  use App\Models\SysConfig;
  use App\Models\SysFieldType;



  class SysConfigsSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {


      SysConfig::Create([
        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-default-language',
        'tbl_sys_config_description' => "Idioma do sistema",
        'tbl_sys_config_value'       => 'pt-br',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6'

        ])


      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-multi-language',
        'tbl_sys_config_description' => "Habilitar seleção de Idiomas",
        'tbl_sys_config_value'       => 'false',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([
          
          'wrapper_class' => 'col-12 col-md-6',
          'choices'       => [

            false => "Não",
            true  => "Sim"

          ]

        ])
      
      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'site-home',
        'tbl_sys_config_description' => "Página inicial do site",
        'tbl_sys_config_value'       => '/',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-admin',
        'tbl_sys_config_description' => "URL de administração",
        'tbl_sys_config_value'       => '/admin/',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'site-title',
        'tbl_sys_config_description' => "Título do site",
        'tbl_sys_config_value'       => 'Automator v2',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-5'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'site-description',
        'tbl_sys_config_description' => "Descrição do site",
        'tbl_sys_config_value'       => 'Sistema de gerenciamento de informações automatizado.',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('image', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'site-favicon',
        'tbl_sys_config_description' => "Ícone do site",
        'tbl_sys_config_value'       => '',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('image', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'site-logo',
        'tbl_sys_config_description' => "Logo do site",
        'tbl_sys_config_value'       => '',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-enable-register',
        'tbl_sys_config_description' => "Registro público liberado",
        'tbl_sys_config_value'       => 'false',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([
          
          'wrapper_class' => 'col-12 col-md-6',
          'choices'       => [

            false => "Não",
            true  => "Sim"

          ]

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'site-default-user-type-register',
        'tbl_sys_config_description' => "Tipo de usuário padrão de cadastro",
        'tbl_sys_config_value'       => '3',
        'tbl_sys_config_required'    => false,
        'tbl_sys_config_props'       => json_encode([
          
          'wrapper_class' => 'col-12 col-md-6',
          'choices'       => [

            1 => "Administrador",
            2 => "Usuário"

          ]

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-enable-date-formats',
        'tbl_sys_config_description' => "Formato de datas do sistema",
        'tbl_sys_config_value'       => "Y-m-d",
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([
          
          'wrapper_class' => 'col-12 col-md-6',
          'choices'       => [
            'j \d\e F \d\e Y' => 'j \d\e F \d\e Y',
            'Y-m-d'           => 'Y-m-d',
            'd/m/Y'           => 'd/m/Y',
            'd.m.Y'           => 'd.m.Y',
            'custom'          => 'Personalizado'
          ]

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-default-date-format',
        'tbl_sys_config_description' => "Formato de data",
        'tbl_sys_config_value'       => 'Y-m-d',
        'tbl_sys_config_required'    => false,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-enable-time-formats',
        'tbl_sys_config_description' => "Formato de horas do sistema",
        'tbl_sys_config_value'       => "H:i",
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([
          
          'wrapper_class' => 'col-12 col-md-6',
          'choices'       => [

            'H:i'    => 'H:i',
            'g:i A'  => 'g:i A',
            'custom' => 'Personalizado'

          ]

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-default-time-format',
        'tbl_sys_config_description' => "Formato de hora",
        'tbl_sys_config_value'       => 'H:i',
        'tbl_sys_config_required'    => false,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6'

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-week-days-name',
        'tbl_sys_config_description' => "Nome dos dias da semana",
        'tbl_sys_config_value'       => "7",
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6',
          'choices'       => [
            '1' => 'Segunda',
            '2' => 'Terça-Feira',
            '3' => 'Quarta-Feira',
            '4' => 'Quinta-Feira',
            '5' => 'Sexta-Feira',
            '6' => 'Sábado',
            '7' => 'Domingo',
          ]

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('select', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-default-week-day-start',
        'tbl_sys_config_description' => "Dia de inicio da semana",
        'tbl_sys_config_value'       => '1',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-6',
          'choices'       => [
            '1' => 'Segunda',
            '2' => 'Terça-Feira',
            '3' => 'Quarta-Feira',
            '4' => 'Quinta-Feira',
            '5' => 'Sexta-Feira',
            '6' => 'Sábado',
            '7' => 'Domingo',
          ]

        ])

      ]);


      SysConfig::Create([

        'tbl_sys_field_type_ID'      => SysFieldType::getFieldTypeDataByName('text', 'tbl_sys_field_type_ID'),
        'tbl_sys_config_name'        => 'system-default-uploads-dir',
        'tbl_sys_config_description' => "Diretório padrão de uploads do sistema",
        'tbl_sys_config_value'       => 'uploads',
        'tbl_sys_config_required'    => true,
        'tbl_sys_config_props'       => json_encode([

          'wrapper_class' => 'col-12 col-md-5'

        ])

      ]);
    

    }
  


  }