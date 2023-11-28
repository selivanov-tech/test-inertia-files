<?php

namespace App\Providers;

use App\Src\Media\FileExtensionGetter;
use App\Src\Media\FileUpdater;
use App\Src\Media\FileUploader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // todo: bind to abstract Interfaces
        $this->app->bind(FileUploader::class, FileUploader::class);
        $this->app->bind(FileUpdater::class, FileUpdater::class);
        $this->app->bind(FileExtensionGetter::class, FileExtensionGetter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
