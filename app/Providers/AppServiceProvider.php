<?php

namespace App\Providers;

use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

      // \App\Helpers\SysModuloAutoloader::registrar();
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(CommandStarting::class, function (CommandStarting $event): void {

            /*
            |------------------------------------------------------------------
            | Sincroniza os módulos em disco com migrate:fresh
            |------------------------------------------------------------------
            |
            | migrate:fresh remove os registros dos módulos instalados. Os
            | respectivos arquivos também precisam ser removidos para que uma
            | reinstalação não encontre resíduos da base anterior.
            |
            */

            if ($event->command !== 'migrate:fresh') {
                return;
            }

            $modulesDirectory = storage_path('app/modulos');

            File::ensureDirectoryExists($modulesDirectory);
            File::cleanDirectory($modulesDirectory);
        });
    }
}
