<?php


  namespace App\Helpers;

  use Illuminate\Support\Facades\File;
  use Illuminate\Support\Facades\View;

  use App\Models\SysModulo;


  class SysModuloAutoloader {


    private const NAMESPACES_PERMITIDOS = [

      'App\\Http\\Controllers\\',
      'App\\Models\\'

    ];


    private const SUBDIRETORIOS_CLASSES = ['Controllers', 'Models', 'Helpers'];



    public static function registrar(): void {

      spl_autoload_register([self::class, 'carregarClasse']);

      foreach(self::getModulosInstaladosAtivos() as $moduleDirectory) {
        View::addLocation($moduleDirectory);
      }

    }



    private static function carregarClasse(string $className): void {

      $namespaceValido = false;

      foreach(self::NAMESPACES_PERMITIDOS as $namespace) {

        if(str_starts_with($className, $namespace)) {
          $namespaceValido = true;
          break;
        }

      }


      if($namespaceValido !== true) {
        return;
      }


      $classeCurta = class_basename($className);


      foreach(self::getModulosInstaladosAtivos() as $moduleDirectory) {

        foreach(self::SUBDIRETORIOS_CLASSES as $subDirectory) {

          $filePath = $moduleDirectory . DIRECTORY_SEPARATOR . $subDirectory . DIRECTORY_SEPARATOR . $classeCurta . '.php';

          if(File::exists($filePath)) {
            require_once $filePath;
            return;
          }

        }

      }

    }



    private static function getModulosInstaladosAtivos(): array {

      static $diretoriosCache = null;

      if($diretoriosCache !== null) {
        return $diretoriosCache;
      }

      $diretoriosCache = [];

      try {

        $modulosAtivos = SysModulo::where('tbl_sys_modulo_status', 'ativo')
          ->pluck('tbl_sys_modulo_name');


        foreach($modulosAtivos as $moduleName) {

          $moduleDirectory = storage_path('app/modulos/installed/' . $moduleName);

          if(File::isDirectory($moduleDirectory)) {
            $diretoriosCache[] = $moduleDirectory;
          }

        }

      } catch(\Throwable $exception) {

        // Banco de dados pode não estar disponível ainda (ex.: durante instalação inicial). Ignora silenciosamente.

      }

      return $diretoriosCache;

    }


  }