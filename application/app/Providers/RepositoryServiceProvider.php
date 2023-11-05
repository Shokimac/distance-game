<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Domain\Game\Domain\Repository\GameRepositoryInterface::class, function () {
            return new \App\Domain\Game\Infrastructure\Repository\MysqlGameRepository(new \App\Models\Game);
        });
        $this->app->bind(\App\Domain\Player\Domain\Repository\PlayerRepositoryInterface::class, function () {
            return new \App\Domain\Player\Infrastructure\Repository\MysqlPlayerRepository(new \App\Models\Player);
        });
        $this->app->bind(\App\Domain\Location\Domain\Repository\LocationRepositoryInterface::class, function () {
            return new \App\Domain\Location\Infrastructure\Repository\MysqlLocationRepository(new \App\Models\Location);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
