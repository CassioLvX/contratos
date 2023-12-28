<?php

namespace App\Providers;

use App\Repositories\ContratoRepository;
use App\Repositories\Interfaces\ContratoRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ContratoRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            ContratoRepositoryInterface::class,
            ContratoRepository::class
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
            ContratoRepositoryInterface::class,
        ];
    }
}
