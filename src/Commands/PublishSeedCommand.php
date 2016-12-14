<?php

namespace Rad\Modules\Commands;

use Illuminate\Console\Command as ModuleCommand;
use Rad\Modules\Migrations\Seeder;
use Rad\Modules\Publishing\SeedPublisher;
use Symfony\Component\Console\Input\InputArgument;

class PublishSeedCommand extends ModuleCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'module:publish-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Publish a module's seeds to the application";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if ($name = $this->argument('module')) {
            $module = $this->laravel['modules']->findOrFail($name);

            $this->publish($module);

            return;
        }

        foreach ($this->laravel['modules']->enabled() as $module) {
            $this->publish($module);
        }
    }

    /**
     * Publish migration for the specified module.
     *
     * @param \Rad\Modules\Module $module
     */
    public function publish($module)
    {
        with(new SeedPublisher(new Seeder($module)))
            ->setRepository($this->laravel['modules'])
            ->setConsole($this)
            ->publish();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('module', InputArgument::OPTIONAL, 'The name of module being used.'),
        );
    }
}
