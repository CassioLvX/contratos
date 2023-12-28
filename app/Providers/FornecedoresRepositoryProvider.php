<?php

namespace App\Providers;

use App\Repositories\FornecedoresRepository;
use App\Repositories\Interfaces\FornecedoresRepositoryInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FornecedoresRepositoryProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            FornecedoresRepositoryInterface::class,
            FornecedoresRepository::class
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
            FornecedoresRepositoryInterface::class,
        ];
    }
}
