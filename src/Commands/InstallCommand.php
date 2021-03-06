<?php

namespace Rad\Components\Commands;

use Illuminate\Console\Command as ComponentCommand;
use Rad\Components\Json;
use Rad\Components\Process\Installer;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends ComponentCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'component:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the specified component by given package name (vendor/name).';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        if (is_null($this->argument('name'))) {
            $this->installFromFile();

            return;
        }

        $this->install(
            $this->argument('name'),
            $this->argument('version'),
            $this->option('type'),
            $this->option('tree')
        );
    }

    /**
     * Install components from components.json file.
     */
    protected function installFromFile()
    {
        if (!file_exists($path = base_path('components.json'))) {
            $this->error("File 'components.json' does not exist in your project root.");

            return;
        }

        $components = Json::make($path);

        $dependencies = $components->get('require', []);

        foreach ($dependencies as $component) {
            $component = collect($component);

            $this->install(
                $component->get('name'),
                $component->get('version'),
                $component->get('type')
            );
        }
    }

    /**
     * Install the specified component.
     *
     * @param string $name
     * @param string $version
     * @param string $type
     * @param bool   $tree
     */
    protected function install($name, $version = 'dev-master', $type = 'composer', $tree = false)
    {
        $installer = new Installer(
            $name,
            $version,
            $type ?: $this->option('type'),
            $tree ?: $this->option('tree')
        );

        $installer->setRepository($this->laravel['components']);

        $installer->setConsole($this);

        if ($timeout = $this->option('timeout')) {
            $installer->setTimeout($timeout);
        }

        if ($path = $this->option('path')) {
            $installer->setPath($path);
        }

        $installer->run();

        if (!$this->option('no-update')) {
            $this->call('component:update', [
                'component' => $installer->getComponentName(),
            ]);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'The name of component will be installed.'],
            ['version', InputArgument::OPTIONAL, 'The version of component will be installed.'],
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
            ['timeout', null, InputOption::VALUE_OPTIONAL, 'The process timeout.', null],
            ['path', null, InputOption::VALUE_OPTIONAL, 'The installation path.', null],
            ['type', null, InputOption::VALUE_OPTIONAL, 'The type of installation.', null],
            ['tree', null, InputOption::VALUE_NONE, 'Install the component as a git subtree', null],
            ['no-update', null, InputOption::VALUE_NONE, 'Disables the automatic update of the dependencies.', null],
        ];
    }
}
