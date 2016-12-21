<?php

namespace Rad\Components\Commands;

use Illuminate\Console\Command as ComponentCommand;
use Rad\Components\Migrations\Migrator;
use Rad\Components\Traits\MigrationLoaderTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateResetCommand extends ComponentCommand
{
    use MigrationLoaderTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'component:migrate-reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the components migrations.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $component = $this->argument('component');

        if (!empty($component)) {
            $this->reset($component);

            return;
        }

        foreach (array_reverse($this->laravel['components']->all()) as $component) {
            $this->line('Running for component: <info>' . $component->getName() . '</info>');

            $this->reset($component);
        }
    }

    /**
     * Rollback migration from the specified component.
     *
     * @param $component
     */
    public function reset($component)
    {
        if (is_string($component)) {
            $component = $this->laravel['components']->findOrFail($component);
        }

        $migrator = new Migrator($component);

        $database = $this->option('database');

        if (!empty($database)) {
            $migrator->setDatabase($database);
        }

        $migrated = $migrator->reset();

        if (count($migrated)) {
            foreach ($migrated as $migration) {
                $this->line("Rollback: <info>{$migration}</info>");
            }

            return;
        }

        $this->comment('Nothing to rollback.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['component', InputArgument::OPTIONAL, 'The name of component will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.'],
        ];
    }
}
