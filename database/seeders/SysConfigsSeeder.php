<?php


  namespace Database\Seeders;

  // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;

  use App\Models\SysConfig;



  class SysConfigsSeeder extends Seeder {
    


    /**
     * Run the database seeds.
     */
    public function run(): void {


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-default-language',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Idioma do sistema"' . "]",
        'tbl_sys_config_value'       => 'pt-br'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-multi-language',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Habilitar seleção de Idiomas"' . "]",
        'tbl_sys_config_value'       => 'false'
      
      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'site-home',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Página inicial do site"' . "]",
        'tbl_sys_config_value'       => '/'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-admin',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"URL de administração"' . "]",
        'tbl_sys_config_value'       => '/admin/'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'site-title',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Título do site"' . "]",
        'tbl_sys_config_value'       => 'Automator v2'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'site-description',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Descrição do site"' . "]",
        'tbl_sys_config_value'       => 'Sistema de gerenciamento de informações automatizado.'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'site-favicon',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Ícone do site"' . "]",
        'tbl_sys_config_value'       => ''

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'site-logo',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Logo do site"' . "]",
        'tbl_sys_config_value'       => ''

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-enable-register',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Registro público liberado"' . "]",
        'tbl_sys_config_value'       => 'false'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'site-default-user-type-register',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Tipo de usuário padrão de cadastro"' . "]",
        'tbl_sys_config_value'       => '3'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-enable-date-formats',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Formato de datas do sistema"' . "]",
        'tbl_sys_config_value'       => "{'j \d\e F \d\e Y': '[sysfunction return=" . '"string"' . " fn=" . '"sysDateFormat"' . " params=" . '"j \d\e F \d\e Y";"sysconfig(system-default-language)"' . "]', 'Y-m-d': '[sysfunction return=" . '"string"' . " fn=" . '"sysDateFormat"' . " params=" . '"Y-m-d";"sysconfig(system-default-language)"' . "]', 'm/d/Y': '[sysfunction return=" . '"string"' . " fn=" . '"sysDateFormat"' . " params=" . '"m/d/Y";"sysconfig(system-default-language)"' . "]', 'd/m/Y': '[sysfunction return=" . '"string"' . " fn=" . '"sysDateFormat"' . " params=" . '"d/m/Y";"sysconfig(system-default-language)"' . "]', 'd.m.Y': '[sysfunction return=" . '"string"' . " fn=" . '"sysDateFormat"' . " params=" . '"d.m.Y";"sysconfig(system-default-language)"' . "]', 'custom': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Personalizado"' . "]'}"

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-default-date-format',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Formato de data"' . "]",
        'tbl_sys_config_value'       => 'Y-m-d'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-enable-time-formats',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Formato de horas do sistema"' . "]",
        'tbl_sys_config_value'       => "{'H:i': '[sysfunction return=" . '"string"' . " fn=" . '"sysDateFormat"' . " params=" . '"H:i"' . "]', 'g:i A': '[sysfunction return=" . '"string"' . " fn=" . '"sysDateFormat"' . " params=" . '"g:i A";"sysconfig(system-default-language)"' . "]', 'custom': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Personalizado"' . "]'}"

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-default-time-format',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Formato de hora"' . "]",
        'tbl_sys_config_value'       => 'H:i'

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-week-days-name',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Nome dos dias da semana"' . "]",
        'tbl_sys_config_value'       => "{'1': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"segunda-feira"' . "]', '2': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"terça-feira"' . "]', '3': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"quarta-feira"' . "]', '4': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"quinta-feira"' . "]', '5': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"sexta-feira"' . "]', '6': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"sábado"' . "]', '7': '[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"domingo"' . "]'}"

      ]);


      SysConfig::Create([

        'tbl_sys_config_name'        => 'system-default-week-day-start',
        'tbl_sys_config_description' => "[sysfunction return=" . '"string"' . " fn=" . '"translate"' . " params=" . '"Dia de inicio da semana"' . "]",
        'tbl_sys_config_value'       => '1'

      ]);
    

    }
  


  }