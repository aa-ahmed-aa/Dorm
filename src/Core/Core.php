<?php
namespace Ahmedkhd\Dorm\Core;

use Ahmedkhd\Dorm\Helpers\CleanUpHelpers;
use Ahmedkhd\Dorm\Helpers\CompilerTrait;
use Ahmedkhd\Dorm\Strategy\CAndCPPStrategy;
use Ahmedkhd\Dorm\Strategy\JavaStrategy;
use Ahmedkhd\Dorm\Strategy\PythonStrategy;

class Core extends Config
{
    use CompilerTrait;
    use CleanUpHelpers;

    use CAndCPPStrategy;
    use JavaStrategy;
    use PythonStrategy;

    /**
     * This function will timeout after 5 second to handle the time limit exceeded
     * @param $command => Command to run
     * @param int $timeToSleep
     * @return bool|int
     */
    public function runCommand($command, $timeToSleep = 5)
    {
        $descriptorspec = array(
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            2 => array("file", "error-output.txt", "a") // stderr is a file to write to
        );

        $time = time();
        $process = proc_open($command, $descriptorspec, $pipes);
        sleep($timeToSleep);
        //the task is still running
        if (Config::isProcessStillRunning('program.'.Config::getExecutableExtension(CPP))) {
            $this->killProcess();
            return TIME_LIMIT_EXCEEDED;
        }
        return true;
    }

    /**
     * Get Command based on the os and the compiler
     * @return string
     */
    public function runStrategy()
    {
        switch (PHP_OS) {
            case 'Linux':
                return "cd " . $this->getCompilationPath().DS.
                    " && .".DS."program.".Config::getExecutableExtension(CPP)." 2>&1";
                break;
            case 'Windows':
                return "cd ".
                    $this->getCompilationPath() . DS . " & ".
                    $this->getCompilationPath() . DS . "program.".Config::getExecutableExtension(CPP)." 2>&1";
                break;
        }
    }

    /**
     * Kill process strategy
     */
    public function killProcess()
    {
        switch (PHP_OS) {
            case 'Linux':
                $processToKill = shell_exec(Config::getProcessLister('program.'.Config::getExecutableExtension(CPP)) . ' 2>&1');
                system(Config::getProcessKiller($this->getCompiler(), $processToKill));
                break;
            case 'Windows':
                system(Config::getProcessKiller($this->getCompiler(), "program.exe"));
                break;
        }
    }
}
