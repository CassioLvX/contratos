<?php

namespace App\Providers;

use App\Repositories\ContratoDepartamentoRepository;
use App\Repositories\Interfaces\ContratoDepartamentoRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ContratoDepartamentoRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            ContratoDepartamentoRepositoryInterface::class,
            ContratoDepartamentoRepository::class
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [
            ContratoDepartamentoRepositoryInterface::class,
        ];
    }
}
