<?php

namespace App\Providers;

use App\Http\Services\DepartamentoServices;
use App\Http\Services\Interfaces\DepartamentoServicesInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class DepartamentoServicesProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            DepartamentoServicesInterface::class,
            DepartamentoServices::class
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
            DepartamentoServicesInterface::class,
        ];
    }
}
