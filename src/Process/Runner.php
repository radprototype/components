<?php

namespace Rad\Modules\Process;

use Rad\Modules\Contracts\RunableInterface;
use Rad\Modules\Repository;

class Runner implements RunableInterface
{
    /**
     * The module instance.
     *
     * @var \Rad\Modules\Repository
     */
    protected $module;

    /**
     * The constructor.
     *
     * @param \Rad\Modules\Repository $module
     */
    public function __construct(Repository $module)
    {
        $this->module = $module;
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
