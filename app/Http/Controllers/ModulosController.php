<?php


  namespace App\Http\Controllers;

  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\DB;
  use Illuminate\Support\Facades\File;


  use App\Helpers\SysAutomator;


  use App\Models\SysModulo;
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


        if(File::isDirectory($moduleDirectory)) {
          File::moveDirectory($moduleDirectory, $backupDirectory);
          $moduleDirectoryMoved = true;
        }


        File::moveDirectory($extractedDirectory, $moduleDirectory);


        if(File::isDirectory($temporaryDirectory)) {
          File::deleteDirectory($temporaryDirectory);
        }


        $module->fill([

          'tbl_sys_modulo_name'        => $packageData['name'],
          'tbl_sys_modulo_version'     => $packageData['version'],
          'tbl_sys_modulo_title'       => $validatedData['tbl_sys_modulo_title'],
          'tbl_sys_modulo_description' => $validatedData['tbl_sys_modulo_description'] ?? '',
          'tbl_sys_modulo_status'      => $validatedData['tbl_sys_modulo_status']

        ]);


        DB::transaction(function() use ($module) {
          $module->save();
        });


        if($moduleDirectoryMoved === true && File::isDirectory($backupDirectory)) {
          File::deleteDirectory($backupDirectory);
        }

      } catch(\Throwable $exception) {

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
          'message' => SysAutomator::SysAutomatorGetTranslateWord('Não foi possível concluir a instalação do módulo.')

        ], 500);

      }


      return response()->json([

        'status'  => true,
        'message' => SysAutomator::SysAutomatorGetTranslateWord('Módulo instalado com sucesso.'),
        'id'      => $module->getKey()

      ]);

    }

  }
