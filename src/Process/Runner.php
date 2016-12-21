<?php

namespace Rad\Components\Process;

use Rad\Components\Contracts\RunableInterface;
use Rad\Components\Repository;

class Runner implements RunableInterface
{
    /**
     * The component instance.
     *
     * @var \Rad\Components\Repository
     */
    protected $component;

    /**
     * The constructor.
     *
     * @param \Rad\Components\Repository $component
     */
    public function __construct(Repository $component)
    {
        $this->component = $component;
    }


    /**
     * Run the given command.
     *
     * @param string $command
     */
    public function run($command)
    {
        passthru($command);
    }
}
