<?php

namespace Rad\Components\Generators;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command as Console;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Rad\Components\Repository;
use Rad\Components\Support\Stub;

class ComponentGenerator extends Generator
{
    /**
     * The component name will created.
     *
     * @var string
     */
    protected $name;

    /**
     * The laravel config instance.
     *
     * @var Config
     */
    protected $config;

    /**
     * The laravel filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * The laravel console instance.
     *
     * @var Console
     */
    protected $console;

    /**
     * The pingpong component instance.
     *
     * @var Component
     */
    protected $component;

    /**
     * Force status.
     *
     * @var bool
     */
    protected $force = false;

    /**
     * Generate a plain component.
     *
     * @var bool
     */
    protected $plain = false;

    /**
     * The constructor.
     *
     * @param            $name
     * @param Repository $component
     * @param Config     $config
     * @param Filesystem $filesystem
     * @param Console    $console
     */
    public function __construct(
        $name,
        Repository $component = null,
        Config $config = null,
        Filesystem $filesystem = null,
        Console $console = null
    ) {
        $this->name       = $name;
        $this->config     = $config;
        $this->filesystem = $filesystem;
        $this->console    = $console;
        $this->component     = $component;
    }

    /**
     * Set plain flag.
     *
     * @param bool $plain
     *
     * @return $this
     */
    public function setPlain($plain)
    {
        $this->plain = $plain;

        return $this;
    }

    /**
     * Get the name of component will created. By default in studly case.
     *
     * @return string
     */
    public function getName()
    {
        return Str::studly($this->name);
    }

    /**
     * Get the laravel config instance.
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set the laravel config instance.
     *
     * @param Config $config
     *
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get the laravel filesystem instance.
     *
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Set the laravel filesystem instance.
     *
     * @param Filesystem $filesystem
     *
     * @return $this
     */
    public function setFilesystem($filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get the laravel console instance.
     *
     * @return Console
     */
    public function getConsole()
    {
        return $this->console;
    }

    /**
     * Set the laravel console instance.
     *
     * @param Console $console
     *
     * @return $this
     */
    public function setConsole($console)
    {
        $this->console = $console;

        return $this;
    }

    /**
     * Get the pingpong component instance.
     *
     * @return Component
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * Set the pingpong component instance.
     *
     * @param mixed $component
     *
     * @return $this
     */
    public function setComponent($component)
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Get the list of folders will created.
     *
     * @return array
     */
    public function getFolders()
    {
        return array_values($this->component->config('paths.generator'));
    }

    /**
     * Get the list of files will created.
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->component->config('stubs.files');
    }

    /**
     * Set force status.
     *
     * @param bool|int $force
     *
     * @return $this
     */
    public function setForce($force)
    {
        $this->force = $force;

        return $this;
    }

    /**
     * Generate the component.
     */
    public function generate()
    {
        $name = $this->getName();

        if ($this->component->has($name)) {
            if ($this->force) {
                $this->component->delete($name);
            } else {
                $this->console->error("Component [{$name}] already exist!");

                return;
            }
        }

        $this->generateFolders();

        $this->generateFiles();

        if (!$this->plain) {
            $this->generateResources();
        }

        $this->console->info("Component [{$name}] created successfully.");
    }

    /**
     * Generate the folders.
     */
    public function generateFolders()
    {
        foreach ($this->getFolders() as $folder) {
            $path = $this->component->getComponentPath($this->getName()) . '/' . $folder;

            $this->filesystem->makeDirectory($path, 0755, true);

            $this->generateGitKeep($path);
        }
    }

    /**
     * Generate git keep to the specified path.
     *
     * @param string $path
     */
    public function generateGitKeep($path)
    {
        $this->filesystem->put($path . '/.gitkeep', '');
    }

    /**
     * Generate the files.
     */
    public function generateFiles()
    {
        foreach ($this->getFiles() as $stub => $file) {
            $path = $this->component->getComponentPath($this->getName()) . $file;

            if (!$this->filesystem->isDirectory($dir = dirname($path))) {
                $this->filesystem->makeDirectory($dir, 0775, true);
            }

            $this->filesystem->put($path, $this->getStubContents($stub));

            $this->console->info("Created : {$path}");
        }
    }

    /**
     * Generate some resources.
     */
    public function generateResources()
    {
        $this->console->call('component:make-seed', [
            'name'     => $this->getName(),
            'component'   => $this->getName(),
            '--master' => true,
        ]);

        $this->console->call('component:make-provider', [
            'name'     => $this->getName() . 'ServiceProvider',
            'component'   => $this->getName(),
            '--master' => true,
        ]);

        $this->console->call('component:make-controller', [
            'controller' => $this->getName() . 'Controller',
            'component'     => $this->getName(),
        ]);
    }

    /**
     * Get the contents of the specified stub file by given stub name.
     *
     * @param $stub
     *
     * @return Stub
     */
    protected function getStubContents($stub)
    {
        return (new Stub(
            '/' . $stub . '.stub',
            $this->getReplacement($stub))
        )->render();
    }

    /**
     * get the list for the replacements.
     */
    public function getReplacements()
    {
        return $this->component->config('stubs.replacements');
    }

    /**
     * Get array replacement for the specified stub.
     *
     * @param $stub
     *
     * @return array
     */
    protected function getReplacement($stub)
    {
        $replacements = $this->component->config('stubs.replacements');

        if (!isset($replacements[$stub])) {
            return [];
        }

        $keys = $replacements[$stub];

        $replaces = [];

        foreach ($keys as $key) {
            if (method_exists($this, $method = 'get' . ucfirst(studly_case(strtolower($key))) . 'Replacement')) {
                $replaces[$key] = call_user_func([$this, $method]);
            } else {
                $replaces[$key] = null;
            }
        }

        return $replaces;
    }

    /**
     * Get the component name in lower case.
     *
     * @return string
     */
    protected function getLowerNameReplacement()
    {
        return strtolower($this->getName());
    }

    /**
     * Get the component name in studly case.
     *
     * @return string
     */
    protected function getStudlyNameReplacement()
    {
        return $this->getName();
    }

    /**
     * Get replacement for $VENDOR$.
     *
     * @return string
     */
    protected function getVendorReplacement()
    {
        return $this->component->config('composer.vendor');
    }

    /**
     * Get replacement for $MODULE_NAMESPACE$.
     *
     * @return string
     */
    protected function getComponentNamespaceReplacement()
    {
        return str_replace('\\', '\\\\', $this->component->config('namespace'));
    }

    /**
     * Get replacement for $AUTHOR_NAME$.
     *
     * @return string
     */
    protected function getAuthorNameReplacement()
    {
        return $this->component->config('composer.author.name');
    }

    /**
     * Get replacement for $AUTHOR_EMAIL$.
     *
     * @return string
     */
    protected function getAuthorEmailReplacement()
    {
        return $this->component->config('composer.author.email');
    }
}
