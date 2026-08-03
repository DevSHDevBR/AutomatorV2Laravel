<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\File;
  use Illuminate\Support\Facades\Artisan;
  use Illuminate\Support\Facades\Log;
  use Illuminate\Support\Facades\Schema;


  use App\Helpers\SysAutomator;


  use App\Models\SysModulo;
  use App\Models\SysModulosRel;
  use App\Models\SysForm;


  class ModulosController extends Controller {



    private function getModuloPackageData($packagePath) {


      if(!class_exists('\ZipArchive') || !File::exists($packagePath)) {
        return null;
      }


      $zip = new \ZipArchive();


      if($zip->open($packagePath) !== true) {
        return null;
      }


      $composerData = null;
      $composerPath = '';


      for($index = 0; $index < $zip->numFiles; $index++) {

        $entryName = str_replace('\\', '/', (string) $zip->getNameIndex($index));


        if(
          str_starts_with($entryName, '/') ||
          preg_match('/(^|\/)\.\.($|\/)/', $entryName)
        ) {
          $zip->close();
          return null;
        }


        if(strtolower(basename($entryName)) !== 'composer.json') {
          continue;
        }


        $decodedData = json_decode((string) $zip->getFromIndex($index), true);


        if(is_array($decodedData)) {
          $composerData = $decodedData;
          $composerPath = $entryName;
          break;
        }

      }


      $zip->close();


      if(!is_array($composerData)) {
        return null;
      }


      $moduleName = trim((string) ($composerData['id'] ?? ''));
      $moduleVersion = trim((string) ($composerData['version'] ?? ''));


      if(
        $moduleName === '' ||
        $moduleVersion === '' ||
        !preg_match('/^[a-zA-Z0-9][a-zA-Z0-9._-]*$/', $moduleName) ||
        !preg_match('/^[a-zA-Z0-9][a-zA-Z0-9._+-]*$/', $moduleVersion)
      ) {
        return null;
      }


      return [

        'name'        => $moduleName,
        'version'     => $moduleVersion,
        'title'       => trim((string) ($composerData['name'] ?? $moduleName)),
        'description' => trim((string) ($composerData['description'] ?? '')),
        'composerPath'=> $composerPath

      ];

    }



    public function uploadModulo(Request $request) {


      if(Auth::check() !== true || Auth::id() === null) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Sua sessão expirou. Faça o login novamente para continuar.')

        ], 401);

      }


      $validatedData = $request->validate([

        'file' => [

          'required',
          'file',
          'mimes:zip'

        ]

      ], [

        'file.required' => SysAutomator::SysAutomatorGetTranslateWord('Selecione um arquivo ZIP para continuar.'),
        'file.file'     => SysAutomator::SysAutomatorGetTranslateWord('O arquivo selecionado não é válido.'),
        'file.mimes'    => SysAutomator::SysAutomatorGetTranslateWord('Apenas arquivos ZIP são permitidos.')

      ]);


      $uploadedFile = $validatedData['file'];
      $packageData = $this->getModuloPackageData($uploadedFile->getRealPath());


      if($packageData === null) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('O arquivo ZIP não possui um composer.json válido.')

        ], 422);

      }


      $module = SysModulo::where('tbl_sys_modulo_name', $packageData['name'])->first();


      if(
        $module !== null &&
        (string) $module->tbl_sys_modulo_version === $packageData['version']
      ) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Esta versão do módulo já está instalada.')

        ], 422);

      }


      $packageDirectory = storage_path('app/modulos/packages');
      $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
      $packageName = preg_replace('/[^a-zA-Z0-9._-]/', '-', $originalFileName);
      $packageName = trim((string) $packageName, '.-');


      if($packageName === '') {
        $packageName = $packageData['name'];
      }


      $packageFileName = $packageName . '-' . $packageData['version'] . '.zip';
      $packagePath = $packageDirectory . DIRECTORY_SEPARATOR . $packageFileName;


      try {

        File::ensureDirectoryExists($packageDirectory);


        if(File::exists($packagePath)) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Já existe um pacote salvo com este nome e versão.')

          ], 422);

        }


        $uploadedFile->move($packageDirectory, $packageFileName);

      } catch(\Throwable $exception) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Não foi possível salvar o pacote do módulo.')

        ], 500);

      }


      $form = SysForm::where('tbl_sys_form_name', 'admin-modulos')->first();


      if($form === null) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('O formulário de módulos não foi encontrado.')

        ], 500);

      }


      return response()->json([

        'status'  => true,
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Pacote do módulo enviado com sucesso.'),
        'data'    => [

          'formID'          => $form->getKey(),
          'isUpdate'        => ($module !== null),
          'moduleID'        => ($module !== null ? $module->getKey() : null),
          'moduleName'      => $packageData['name'],
          'version'         => $packageData['version'],
          'title'           => $packageData['title'],
          'description'     => $packageData['description'],
          'packageFileName' => $packageFileName,
          'installURL'      => SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-modulos-install', [], true)

        ]

      ]);

    }


    public function installModulo(Request $request) {

      if(Auth::check() !== true || Auth::id() === null) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Sua sessão expirou. Faça o login novamente para continuar.')

        ], 401);

      }


      $validatedData = $request->validate([

        'tbl_sys_modulo_ID'          => ['nullable', 'integer'],
        'tbl_sys_modulo_name'        => ['required', 'string', 'max:255'],
        'tbl_sys_modulo_version'     => ['required', 'string', 'max:25'],
        'tbl_sys_modulo_title'       => ['required', 'string', 'min:2', 'max:255'],
        'tbl_sys_modulo_description' => ['nullable', 'string'],
        'tbl_sys_modulo_status'      => ['required', 'in:ativo,inativo'],
        'module_package_file'        => ['required', 'string', 'max:255']

      ]);


      $packageFileName = basename($validatedData['module_package_file']);


      if($packageFileName !== $validatedData['module_package_file']) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('O pacote do módulo informado não é válido.')

        ], 422);

      }


      $packagePath = storage_path('app/modulos/packages/' . $packageFileName);
      $packageData = $this->getModuloPackageData($packagePath);


      if(
        $packageData === null ||
        $packageData['name'] !== $validatedData['tbl_sys_modulo_name'] ||
        $packageData['version'] !== $validatedData['tbl_sys_modulo_version']
      ) {

        return response()->json([

          'status'  => false,
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Os dados do módulo não correspondem ao pacote enviado.')

        ], 422);

      }


      $module = null;
      $moduleID = $validatedData['tbl_sys_modulo_ID'] ?? null;


      if($moduleID !== null) {
        $module = SysModulo::where('tbl_sys_modulo_ID', $moduleID)->first();


        if(
          $module === null ||
          $module->tbl_sys_modulo_name !== $packageData['name']
        ) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('O módulo que será atualizado não foi encontrado.')

          ], 404);

        }

      } else {

        $module = SysModulo::where('tbl_sys_modulo_name', $packageData['name'])->first();


        if($module !== null) {

          return response()->json([

            'status'  => false,
            'message' => SysAutomator::SysAutomatorGetTranslateWord('Este módulo já existe e deve ser atualizado.')

          ], 422);

        }


        $module = new SysModulo();

      }


      $installedDirectory = storage_path('app/modulos/installed');
      $temporaryDirectory = $installedDirectory . DIRECTORY_SEPARATOR . '.temporary-' . $packageData['name'] . '-' . uniqid();
      $moduleDirectory = $installedDirectory . DIRECTORY_SEPARATOR . $packageData['name'];
      $backupDirectory = $installedDirectory . DIRECTORY_SEPARATOR . '.backup-' . $packageData['name'] . '-' . uniqid();
      $moduleDirectoryMoved = false;
      $composerConfig = null;
      $migrationsExecutadas = false;


      try {

        File::ensureDirectoryExists($installedDirectory);


        $zip = new \ZipArchive();


        if($zip->open($packagePath) !== true) {
          throw new \RuntimeException('Não foi possível abrir o pacote do módulo.');
        }


        File::ensureDirectoryExists($temporaryDirectory);


        if($zip->extractTo($temporaryDirectory) !== true) {
          $zip->close();
          throw new \RuntimeException('Não foi possível extrair o pacote do módulo.');
        }


        $zip->close();


        $composerDirectory = trim(dirname($packageData['composerPath']), '.');
        $extractedDirectory = $temporaryDirectory;


        if($composerDirectory !== '') {
          $extractedDirectory .= DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $composerDirectory);
        }


        if(!File::isDirectory($extractedDirectory)) {
          throw new \RuntimeException('A estrutura extraída do módulo não é válida.');
        }


        // Se o diretório do módulo já existe, move-o para backup.
        if(File::isDirectory($moduleDirectory)) {
            if(!File::moveDirectory($moduleDirectory, $backupDirectory)) {
                throw new \RuntimeException(
                    'Não foi possível criar o backup do módulo existente.'
                );
            }
            $moduleDirectoryMoved = true;
        }

        // Move o módulo extraído para o diretório definitivo.
        if(!File::moveDirectory($extractedDirectory, $moduleDirectory)) {
            throw new \RuntimeException(
                'Não foi possível mover o módulo para o diretório definitivo.'
            );
        }


        if(File::isDirectory($temporaryDirectory)) {
          File::deleteDirectory($temporaryDirectory);
        }

        $composerConfig = $this->getModuloComposerConfig($moduleDirectory);


        if($composerConfig === null) {
          throw new \RuntimeException('Não foi possível ler o composer.json do módulo instalado.');
        }


        $this->executarMigrationsModulo($moduleDirectory, $composerConfig);
        $migrationsExecutadas = true;


        $this->executarSeedersModulo($moduleDirectory, $composerConfig);


        $module->fill([

          'tbl_sys_modulo_name'        => $packageData['name'],
          'tbl_sys_modulo_version'     => $packageData['version'],
          'tbl_sys_modulo_title'       => $validatedData['tbl_sys_modulo_title'],
          'tbl_sys_modulo_description' => $validatedData['tbl_sys_modulo_description'] ?? '',
          'tbl_sys_modulo_status'      => $validatedData['tbl_sys_modulo_status']

        ]);


        DB::transaction(function () use ($module, $composerConfig) {

            $module->save();

            SysModulosRel::where(
                'tbl_sys_modulo_rel_name',
                $composerConfig['id']
            )->update([
                'tbl_sys_modulo_ID' => $module->tbl_sys_modulo_ID
            ]);

        });


        if($moduleDirectoryMoved === true && File::isDirectory($backupDirectory)) {
          File::deleteDirectory($backupDirectory);
        }

      } catch(\Throwable $exception) {

        if($migrationsExecutadas === true && $composerConfig !== null) {
          $this->reverterMigrationsModulo($moduleDirectory, $composerConfig);
        
        }


        if(File::isDirectory($temporaryDirectory)) {
          File::deleteDirectory($temporaryDirectory);
        }


        if($moduleDirectoryMoved === true && File::isDirectory($moduleDirectory)) {
          File::deleteDirectory($moduleDirectory);
        }


        if($moduleDirectoryMoved === true && File::isDirectory($backupDirectory)) {
          File::moveDirectory($backupDirectory, $moduleDirectory);
        }


        return response()->json([

          'status'  => false,
          'migrations' => $migrationsExecutadas,
          'composer' => $composerConfig,
          'directory' => $moduleDirectoryMoved,
          'exception' => $exception,
          'file'    => $exception->getFile(),
          'line'    => $exception->getLine(),
          'trace'   => $exception->getTraceAsString(),
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Não foi possível concluir a instalação do módulo.')

        ], 500);

      }


      return response()->json([

        'status'  => true,
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Módulo instalado com sucesso.'),
        'id'      => $module->getKey()

      ]);

    }



    public function updateModulo(Request $request) {

      if (!Auth::check() || Auth::id() === null) {
          return response()->json([
              'status'  => false,
              'message' => SysAutomator::SysAutomatorGetTranslateWord(
                  'Sua sessão expirou. Faça o login novamente para continuar.'
              )
          ], 401);
      }

      $validatedData = $request->validate([

          'tbl_sys_modulo_ID'          => ['required', 'integer'],
          'tbl_sys_modulo_name'        => ['required', 'string', 'max:255'],
          'tbl_sys_modulo_version'     => ['required', 'string', 'max:25'],
          'tbl_sys_modulo_title'       => ['required', 'string', 'min:2', 'max:255'],
          'tbl_sys_modulo_description' => ['nullable', 'string'],
          'tbl_sys_modulo_status'      => ['required', 'in:ativo,inativo'],

      ]);

      $module = SysModulo::findOrFail($validatedData['tbl_sys_modulo_ID']);

      $moduleDirectory = storage_path(
          'app/modulos/installed/' .
          $module->tbl_sys_modulo_name
      );

      $composerConfig = $this->getModuloComposerConfig($moduleDirectory);

      DB::transaction(function () use (
          $module,
          $validatedData,
          $composerConfig,
          $moduleDirectory
      ) {

          $statusAnterior = $module->tbl_sys_modulo_status;

          $module->fill([
              'tbl_sys_modulo_title'       => $validatedData['tbl_sys_modulo_title'],
              'tbl_sys_modulo_description' => $validatedData['tbl_sys_modulo_description'],
              'tbl_sys_modulo_status'      => $validatedData['tbl_sys_modulo_status'],
          ]);

          $module->save();

          /*
          |--------------------------------------------------------------------------
          | Desativar módulo
          |--------------------------------------------------------------------------
          */

          if (
              $statusAnterior != 'inativo' &&
              $validatedData['tbl_sys_modulo_status'] == 'inativo'
          ) {

              $rels = SysModulosRel::where(
                      'tbl_sys_modulo_ID',
                      $module->tbl_sys_modulo_ID
                  )
                  ->orderByDesc('tbl_sys_modulo_rel_ID')
                  ->get();

              foreach ($rels as $rel) {

                  DB::table($rel->tbl_sys_modulo_rel_table)
                      ->where(
                          $rel->tbl_sys_modulo_rel_column,
                          $rel->tbl_sys_modulo_rel_value
                      )
                      ->delete();

                  $rel->delete();
              }
          }

          /*
          |--------------------------------------------------------------------------
          | Ativar módulo
          |--------------------------------------------------------------------------
          */

          if (
              $statusAnterior == 'inativo' &&
              $validatedData['tbl_sys_modulo_status'] == 'ativo'
          ) {

              $this->executarSeedersModulo(
                  $moduleDirectory,
                  $composerConfig
              );

          }

      });

      return response()->json([
          'status' => true,
          'message' => SysAutomator::SysAutomatorGetTranslateWord(
              'Módulo atualizado com sucesso.'
          )
      ]);
    }


    public function activateModule($moduleID) {

      $module = SysModulo::findOrFail($moduleID);

      $moduleDirectory = storage_path(
          'app/modulos/installed/' .
          $module->tbl_sys_modulo_name
      );

      $composerConfig = $this->getModuloComposerConfig($moduleDirectory);

      $this->executarSeedersModulo(
          $moduleDirectory,
          $composerConfig
      );

      SysModulosRel::where(
          'tbl_sys_modulo_rel_name',
          $composerConfig['id']
      )->update([
          'tbl_sys_modulo_ID' => $module->tbl_sys_modulo_ID
      ]);

    }


    public function desactivateModule($moduleID) {

      $module = SysModulo::findOrFail($moduleID);

      $moduleDirectory = storage_path(
          'app/modulos/installed/' .
          $module->tbl_sys_modulo_name
      );

      $composerConfig = $this->getModuloComposerConfig($moduleDirectory);

      $rels = SysModulosRel::where(
              'tbl_sys_modulo_ID',
              $module->tbl_sys_modulo_ID
          )
          ->orderByDesc('tbl_sys_modulo_rel_ID')
          ->get();

      foreach ($rels as $rel) {

          DB::table($rel->tbl_sys_modulo_rel_table)
              ->where(
                  $rel->tbl_sys_modulo_rel_column,
                  $rel->tbl_sys_modulo_rel_value
              )
              ->delete();

          $rel->delete();
      }

    }



    public function deleteModulo(Request $request)
    {
        if (!Auth::check() || Auth::id() === null) {

            return response()->json([
                'status'  => false,
                'message' => SysAutomator::SysAutomatorGetTranslateWord(
                    'Sua sessão expirou. Faça o login novamente para continuar.'
                )
            ], 401);

        }

        $validatedData = $request->validate([
            'id' => ['required', 'integer']
        ]);

        $module = SysModulo::find($validatedData['id']);

        if (!$module) {

            return response()->json([
                'status'  => false,
                'message' => SysAutomator::SysAutomatorGetTranslateWord(
                    'Módulo não encontrado.'
                )
            ], 404);

        }

        /*
        |--------------------------------------------------------------------------
        | Apenas módulos inativos podem ser excluídos
        |--------------------------------------------------------------------------
        */

        if ($module->tbl_sys_modulo_status !== 'inativo') {

            return response()->json([
                'status'  => false,
                'message' => SysAutomator::SysAutomatorGetTranslateWord(
                    'Somente módulos inativos podem ser excluídos.'
                )
            ], 422);

        }

        $moduleDirectory = storage_path(
            'app/modulos/installed/' .
            $module->tbl_sys_modulo_name
        );

        $backupDirectory = storage_path(
            'app/modulos/backups/' .
            $module->tbl_sys_modulo_name .
            '-' .
            uniqid()
        );

        $packagePath = storage_path(
            'app/modulos/packages/' .
            $module->tbl_sys_modulo_name .
            '-' .
            $module->tbl_sys_modulo_version .
            '.zip'
        );

        $composerConfig = $this->getModuloComposerConfig($moduleDirectory);

        try {

            /*
            |--------------------------------------------------------------------------
            | Backup da pasta do módulo
            |--------------------------------------------------------------------------
            */

            if (File::isDirectory($moduleDirectory)) {

                File::ensureDirectoryExists(dirname($backupDirectory));

                if (!File::copyDirectory($moduleDirectory, $backupDirectory)) {

                    throw new RuntimeException(
                        'Não foi possível criar o backup do módulo.'
                    );

                }

            }

            /*
            |--------------------------------------------------------------------------
            | Remove registros do sistema
            |--------------------------------------------------------------------------
            */

            DB::transaction(function () use ($module) {

                $rels = SysModulosRel::where(
                    'tbl_sys_modulo_ID',
                    $module->tbl_sys_modulo_ID
                )
                ->orderByDesc('tbl_sys_modulo_rel_ID')
                ->get();

                foreach ($rels as $rel) {

                    if (
                        Schema::hasTable($rel->tbl_sys_modulo_rel_table) &&
                        Schema::hasColumn(
                            $rel->tbl_sys_modulo_rel_table,
                            $rel->tbl_sys_modulo_rel_column
                        )
                    ) {

                        DB::table($rel->tbl_sys_modulo_rel_table)
                            ->where(
                                $rel->tbl_sys_modulo_rel_column,
                                $rel->tbl_sys_modulo_rel_value
                            )
                            ->delete();

                    }

                }

                SysModulosRel::where(
                    'tbl_sys_modulo_ID',
                    $module->tbl_sys_modulo_ID
                )->delete();

                $module->delete();

            });
            
            /*
            |--------------------------------------------------------------------------
            | Remove as tabelas do módulo
            |--------------------------------------------------------------------------
            |
            | Deve ficar FORA da transaction, pois DROP TABLE faz commit implícito
            | no MySQL.
            |
            */

            if ($composerConfig !== null) {

                $this->removerTabelasModulo(
                    $moduleDirectory,
                    $composerConfig
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Remove ZIP
            |--------------------------------------------------------------------------
            */

            if (File::exists($packagePath)) {

                File::delete($packagePath);

            }

            /*
            |--------------------------------------------------------------------------
            | Remove diretório do módulo
            |--------------------------------------------------------------------------
            */

            if (File::isDirectory($moduleDirectory)) {

                File::deleteDirectory($moduleDirectory);

            }

            /*
            |--------------------------------------------------------------------------
            | Remove backup
            |--------------------------------------------------------------------------
            */

            if (File::isDirectory($backupDirectory)) {

                File::deleteDirectory($backupDirectory);

            }

            return response()->json([

                'status'  => true,
                'title'   => 'Sucesso',
                'message' => SysAutomator::SysAutomatorGetTranslateWord(
                    'Módulo excluído com sucesso.'
                )

            ]);

        } catch (\Throwable $exception) {

            /*
            |--------------------------------------------------------------------------
            | Restaura a pasta do módulo
            |--------------------------------------------------------------------------
            */

            if (
                File::isDirectory($backupDirectory) &&
                !File::isDirectory($moduleDirectory)
            ) {

                File::copyDirectory(
                    $backupDirectory,
                    $moduleDirectory
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Remove backup
            |--------------------------------------------------------------------------
            */

            if (
                File::isDirectory($backupDirectory) &&
                File::isDirectory($moduleDirectory)
            ) {

                File::deleteDirectory($backupDirectory);

            }

            return response()->json([

                'status'    => false,
                'message'   => SysAutomator::SysAutomatorGetTranslateWord(
                    'Não foi possível excluir o módulo.'
                ),
                'exception' => $exception->getMessage(),
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
                'trace'     => $exception->getTraceAsString(),

            ], 500);

        }
    }


    private function removerTabelasModulo(
        string $moduleDirectory,
        array $composerConfig
    ): void {

        $directories = $this->resolverCaminhosModulo(
            $moduleDirectory,
            $composerConfig,
            'migrations'
        );

        Schema::disableForeignKeyConstraints();

        try {

            foreach ($directories as $directory) {

                if (!File::isDirectory($directory)) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Ordem inversa das migrations
                |--------------------------------------------------------------------------
                */

                $files = collect(File::files($directory))
                    ->sortByDesc(function ($file) {
                        return $file->getFilename();
                    });

                foreach ($files as $file) {

                    $content = File::get($file->getRealPath());

                    /*
                    |--------------------------------------------------------------------------
                    | Procura por:
                    | Schema::create('nome_tabela', function (...)
                    |--------------------------------------------------------------------------
                    */

                    if (!preg_match(
                        "/Schema::create\s*\(\s*['\"]([^'\"]+)['\"]\s*,\s*function/i",
                        $content,
                        $matches
                    )) {
                        continue;
                    }

                    $table = $matches[1];

                    if (!Schema::hasTable($table)) {
                        continue;
                    }

                    DB::statement(
                        'DROP TABLE IF EXISTS `' .
                        str_replace('`', '``', $table) .
                        '`'
                    );

                }

            }

        } finally {

            Schema::enableForeignKeyConstraints();

        }

    }



    private function executarDownMigrationsModulo(
        string $moduleDirectory,
        array $composerConfig
    ): void {

        $directories = $this->resolverCaminhosModulo(
            $moduleDirectory,
            $composerConfig,
            'migrations'
        );

        foreach ($directories as $directory) {

            if (!File::isDirectory($directory)) {
                continue;
            }

            $files = collect(File::files($directory))
                ->sortByDesc(function ($file) {
                    return $file->getFilename();
                });

            foreach ($files as $file) {

                try {

                    // Carrega uma nova instância da migration
                    $migration = require $file->getRealPath();

                    if (
                        !is_object($migration) ||
                        !method_exists($migration, 'down')
                    ) {
                        continue;
                    }

                    $migration->down();

                } catch (\Throwable $exception) {

                    throw new \RuntimeException(
                        'Erro ao executar down() da migration "' .
                        $file->getFilename() .
                        '": ' .
                        $exception->getMessage(),
                        0,
                        $exception
                    );

                }

            }

        }

    }



    private function getModuloComposerConfig(string $moduleDirectory): ?array {

      $composerFilePath = $moduleDirectory . DIRECTORY_SEPARATOR . 'composer.json';

      if(!File::exists($composerFilePath)) {
        return null;
      }

      $composerData = json_decode(File::get($composerFilePath), true);

      return is_array($composerData) ? $composerData : null;

    }



    private function resolverCaminhosModulo(string $moduleDirectory, array $composerConfig, string $chave): array {

      $caminhosRelativos = $composerConfig[$chave] ?? [];

      if(!is_array($caminhosRelativos)) {
        return [];
      }

      $caminhosResolvidos = [];

      foreach($caminhosRelativos as $caminhoRelativo) {

        $caminhoCompleto = $moduleDirectory . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, trim((string) $caminhoRelativo, '/\\'));

        if(File::isDirectory($caminhoCompleto)) {
          $caminhosResolvidos[] = $caminhoCompleto;
        }

      }

      return $caminhosResolvidos;

    }


    private function createModuloRel(
        $moduleName,
        $table,
        $column,
        $value
    ) {

        DB::table('tbl_sys_modulos_rels')->insert([

            'tbl_sys_modulo_ID'          => null,

            'tbl_sys_modulo_rel_name'    => $moduleName,

            'tbl_sys_modulo_rel_table'   => $table,

            'tbl_sys_modulo_rel_column'  => $column,

            'tbl_sys_modulo_rel_value'   => $value,

        ]);

    }


    private function executarMigrationsModulo(
        string $moduleDirectory,
        array $composerConfig
    ): void
    {

        $moduleName = $composerConfig['id'] ?? null;


        if(!$moduleName) {

            throw new RuntimeException(
                'O módulo não possui identificador no composer.json.'
            );

        }


        $migrationsDirectories = $this->resolverCaminhosModulo(
            $moduleDirectory,
            $composerConfig,
            'migrations'
        );


        foreach($migrationsDirectories as $migrationsDirectory) {


            if(!is_dir($migrationsDirectory)) {
                continue;
            }


            Artisan::call('migrate', [

                '--path'     => $migrationsDirectory,
                '--realpath' => true,
                '--force'    => true

            ]);


            Log::info(
                'Migrations módulo executadas: ' . $migrationsDirectory
            );


            $files = File::files($migrationsDirectory);


            foreach($files as $file) {


                $migrationName = pathinfo(
                    $file->getFilename(),
                    PATHINFO_FILENAME
                );


                $migrationExists = DB::table('migrations')
                    ->where(
                        'migration',
                        $migrationName
                    )
                    ->exists();


                if($migrationExists) {


                    $this->createModuloRel(

                        $moduleName,

                        'migrations',

                        'migration',

                        $migrationName

                    );


                }


            }


        }


    }

    // private function executarMigrationsModulo(string $moduleDirectory, array $composerConfig): void
    // {


    //     $migrationsDirectories = $this->resolverCaminhosModulo(
    //         $moduleDirectory,
    //         $composerConfig,
    //         'migrations'
    //     );


    //     foreach($migrationsDirectories as $migrationsDirectory) {


    //         if(!is_dir($migrationsDirectory)) {
    //             continue;
    //         }


    //         Artisan::call('migrate', [

    //             '--path'     => $migrationsDirectory,
    //             '--realpath' => true,
    //             '--force'    => true

    //         ]);


    //         if(Artisan::output()) {

    //             Log::info(
    //                 "Migrations módulo executadas: ".$migrationsDirectory
    //             );

    //         }

    //     }
    // }


    private function reverterMigrationsModulo(string $moduleDirectory, array $composerConfig): void
    {
        $migrationsDirectories = $this->resolverCaminhosModulo(
            $moduleDirectory,
            $composerConfig,
            'migrations'
        );

        foreach ($migrationsDirectories as $migrationsDirectory) {

            if (!File::isDirectory($migrationsDirectory)) {
                continue;
            }

            try {

                Artisan::call('migrate:rollback', [

                    '--path'     => $migrationsDirectory,
                    '--realpath' => true,
                    '--force'    => true,

                ]);

                $output = Artisan::output();


                /*
                |--------------------------------------------------------------------------
                | Opcional: registrar log para depuração
                |--------------------------------------------------------------------------
                */

                Log::info('Rollback migration módulo executado', [

                    'path'   => $migrationsDirectory,
                    'output' => $output,

                ]);


            } catch (\Throwable $exception) {


                Log::error('Falha no rollback da migration do módulo', [

                    'path'  => $migrationsDirectory,
                    'error' => $exception->getMessage(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Não interrompe os demais rollbacks
                |--------------------------------------------------------------------------
                */

                continue;

            }

        }

    }
    // private function reverterMigrationsModulo(string $moduleDirectory, array $composerConfig): void {

    //   $migrationsDirectories = $this->resolverCaminhosModulo($moduleDirectory, $composerConfig, 'migrations');

    //   foreach($migrationsDirectories as $migrationsDirectory) {

    //     try {

    //       Artisan::call('migrate:rollback', [

    //         '--path'     => $migrationsDirectory,
    //         '--realpath' => true,
    //         '--force'    => true

    //       ]);

    //     } catch(\Throwable $exception) {

    //       // Best-effort: apenas tenta desfazer o máximo possível, sem interromper o processo de rollback geral.

    //     }

    //   }

    // }


    private function getModulePrefix(array $composerConfig): string {
        $id = $composerConfig['id'] ?? 'Module';
        // Transforma posts-plugin em PostsPlugin
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $id)));
    }


    private function executarSeedersModulo(string $moduleDirectory, array $composerConfig): void
    {
        $seedersDirectories = $this->resolverCaminhosModulo(
            $moduleDirectory,
            $composerConfig,
            'seeders'
        );

        $prefix = $this->getModulePrefix($composerConfig);
        $mainSeederClassName = $prefix . 'DatabaseSeeder';

        foreach ($seedersDirectories as $seedersDirectory) {

            // Carrega todos os seeders da pasta
            foreach (File::files($seedersDirectory) as $file) {
                if ($file->getExtension() === 'php') {
                    require_once $file->getPathname();
                }
            }

            $fullClassName = $prefix . '\\Database\\Seeders\\' . $mainSeederClassName;

            if (!class_exists($fullClassName)) {
                throw new \RuntimeException("Seeder {$fullClassName} não encontrado.");
            }

            /** @var \Illuminate\Database\Seeder $seeder */
            $seeder = app()->make($fullClassName);

            // Executa o DatabaseSeeder
            $seeder->run();
        }
    }


    private function executarTodosSeedersDaPasta(string $directory, string $prefix): void {
        $files = File::files($directory);
        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                require_once $file->getPathname();
                $className = $prefix . "\\Database\\Seeders\\" . pathinfo($file->getFilename(), PATHINFO_FILENAME);
                
                if (class_exists($className) && is_subclass_of($className, \Illuminate\Database\Seeder::class)) {
                    $seederInstance = app()->make($className);
                    app()->call([$seederInstance, 'run']);
                }
            }
        }
    }



    private function executarArquivoSeederModulo(string $seederFilePath): void {

      $classesDeclaradasAntes = get_declared_classes();

      try {

        require $seederFilePath;

      } catch(\Throwable $exception) {

        throw new \RuntimeException(

          'Não foi possível carregar o seeder "' . basename($seederFilePath) . '". ' .
          'Provavelmente já existe uma classe com o mesmo nome carregada neste processo.'

        );

      }

      $classesDeclaradasDepois = get_declared_classes();
      $classesNovas = array_diff($classesDeclaradasDepois, $classesDeclaradasAntes);

      foreach($classesNovas as $classeName) {

        if(!is_subclass_of($classeName, \Illuminate\Database\Seeder::class)) {
          continue;
        }

        $seederInstance = app()->make($classeName);

        app()->call([$seederInstance, 'run']);

      }

    }


  }
