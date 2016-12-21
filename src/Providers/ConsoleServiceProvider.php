<?php

namespace Rad\Components\Providers;

use Illuminate\Support\ServiceProvider;
use Rad\Components\Commands\MakeCommandCommand;
use Rad\Components\Commands\MakeControllerCommand;
use Rad\Components\Commands\DisableCommand;
use Rad\Components\Commands\DumpCommand;
use Rad\Components\Commands\EnableCommand;
use Rad\Components\Commands\GenerateEventCommand;
use Rad\Components\Commands\GenerateJobCommand;
use Rad\Components\Commands\GenerateListenerCommand;
use Rad\Components\Commands\GenerateMailCommand;
use Rad\Components\Commands\GenerateMiddlewareCommand;
use Rad\Components\Commands\GenerateNotificationCommand;
use Rad\Components\Commands\GenerateProviderCommand;
use Rad\Components\Commands\GenerateRouteProviderCommand;
use Rad\Components\Commands\InstallCommand;
use Rad\Components\Commands\ListCommand;
use Rad\Components\Commands\MakeCommand;
use Rad\Components\Commands\MakeRequestCommand;
use Rad\Components\Commands\MigrateCommand;
use Rad\Components\Commands\MigrateRefreshCommand;
use Rad\Components\Commands\MigrateResetCommand;
use Rad\Components\Commands\MigrateRollbackCommand;
use Rad\Components\Commands\MigrationCommand;
use Rad\Components\Commands\ModelCommand;
use Rad\Components\Commands\PublishAssetCommand;
use Rad\Components\Commands\PublishConfigurationCommand;
use Rad\Components\Commands\PublishMigrationCommand;
use Rad\Components\Commands\PublishTranslationCommand;
use Rad\Components\Commands\SeedCommand;
use Rad\Components\Commands\SeedMakeCommand;
use Rad\Components\Commands\SetupCommand;
use Rad\Components\Commands\UpdateCommand;
use Rad\Components\Commands\UseCommand;
use Rad\Components\Commands\PublishSeedCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    protected $defer = false;

    /**
     * The available commands
     *
     * @var array
     */
    protected $commands
        = [
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
