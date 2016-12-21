<?php

namespace Rad\Components\Providers;

use Illuminate\Support\ServiceProvider;
use Rad\Components\Contracts\RepositoryInterface;
use Rad\Components\Repository;

class ContractsServiceProvider extends ServiceProvider
{
    /**
     * Register some binding.
     */
    public function register()
    {
        $this->app->bind(RepositoryInterface::class, Repository::class);
    }
}
