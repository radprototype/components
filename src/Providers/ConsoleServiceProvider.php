<?php

namespace Rad\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Rad\Modules\Commands\MakeCommandCommand;
use Rad\Modules\Commands\MakeControllerCommand;
use Rad\Modules\Commands\DisableCommand;
use Rad\Modules\Commands\DumpCommand;
use Rad\Modules\Commands\EnableCommand;
use Rad\Modules\Commands\GenerateEventCommand;
use Rad\Modules\Commands\GenerateJobCommand;
use Rad\Modules\Commands\GenerateListenerCommand;
use Rad\Modules\Commands\GenerateMailCommand;
use Rad\Modules\Commands\GenerateMiddlewareCommand;
use Rad\Modules\Commands\GenerateNotificationCommand;
use Rad\Modules\Commands\GenerateProviderCommand;
use Rad\Modules\Commands\GenerateRouteProviderCommand;
use Rad\Modules\Commands\InstallCommand;
use Rad\Modules\Commands\ListCommand;
use Rad\Modules\Commands\MakeCommand;
use Rad\Modules\Commands\MakeRequestCommand;
use Rad\Modules\Commands\MigrateCommand;
use Rad\Modules\Commands\MigrateRefreshCommand;
use Rad\Modules\Commands\MigrateResetCommand;
use Rad\Modules\Commands\MigrateRollbackCommand;
use Rad\Modules\Commands\MigrationCommand;
use Rad\Modules\Commands\ModelCommand;
use Rad\Modules\Commands\PublishAssetCommand;
use Rad\Modules\Commands\PublishConfigurationCommand;
use Rad\Modules\Commands\PublishMigrationCommand;
use Rad\Modules\Commands\PublishTranslationCommand;
use Rad\Modules\Commands\SeedCommand;
use Rad\Modules\Commands\SeedMakeCommand;
use Rad\Modules\Commands\SetupCommand;
use Rad\Modules\Commands\UpdateCommand;
use Rad\Modules\Commands\UseCommand;
use Rad\Modules\Commands\PublishSeedCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        MakeCommand::class,
        MakeCommandCommand::class,
        MakeControllerCommand::class,
        DisableCommand::class,
        EnableCommand::class,
        GenerateEventCommand::class,
        GenerateListenerCommand::class,
        GenerateMiddlewareCommand::class,
        GenerateProviderCommand::class,
        GenerateRouteProviderCommand::class,
        InstallCommand::class,
        ListCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrationCommand::class,
        ModelCommand::class,
        PublishAssetCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UpdateCommand::class,
        UseCommand::class,
        DumpCommand::class,
        MakeRequestCommand::class,
        PublishConfigurationCommand::class,
        GenerateJobCommand::class,
        GenerateMailCommand::class,
        GenerateNotificationCommand::class,
        PublishSeedCommand::class
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
