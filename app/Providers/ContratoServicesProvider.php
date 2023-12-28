<?php

namespace App\Providers;

use App\Http\Services\ContratoServices;
use App\Http\Services\Interfaces\ContratoServicesInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class ContratoServicesProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            ContratoServicesInterface::class,
            ContratoServices::class
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
            ContratoServicesInterface::class,
        ];
    }
}
