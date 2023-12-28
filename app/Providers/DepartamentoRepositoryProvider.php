<?php

namespace App\Providers;

use App\Repositories\DepartamentoRepository;
use App\Repositories\Interfaces\DepartamentoRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DepartamentoRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            DepartamentoRepositoryInterface::class,
            DepartamentoRepository::class
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
            DepartamentoRepositoryInterface::class,
        ];
    }
}
