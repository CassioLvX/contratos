<?php

namespace App\Providers;

use App\Http\Services\FornecedoresServices;
use App\Http\Services\Interfaces\FornecedoresServicesInterface;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FornecedoresServicesProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            FornecedoresServicesInterface::class,
            FornecedoresServices::class
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
            FornecedoresServicesInterface::class,
        ];
    }
}
