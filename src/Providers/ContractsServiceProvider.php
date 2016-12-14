<?php

namespace Rad\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Rad\Modules\Contracts\RepositoryInterface;
use Rad\Modules\Repository;

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
