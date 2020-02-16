<?php

namespace Ahmedkhd\Dorm\Helpers;

trait ProcessTrait
{
    /**
     * Get the process list command
     * @param string $process
     * @return string
     */
    public static function getProcessLister($process = "program.o")
    {
        switch (PHP_OS) {
            case 'Linux':
                return 'pidof '.$process;
                break;
            case 'Windows':
                return 'tasklist';
                break;
        }
    }

    /**
     * Get process killer command
     * @param $compiler
     * @param $processToKill
     * @return string
     */
    public static function getProcessKiller($compiler, $processToKill)
    {
        switch (PHP_OS) {
            case 'Linux':
                return "kill -9 ".$processToKill;
                break;
            case 'Windows':
                return "taskkill /im ".$processToKill." /f" ;
                break;
        }
    }

    /**
     * Validate if the process is still running
     * @param $process
     * @return bool
     */
    public function isProcessStillRunning($process)
    {
        switch (PHP_OS) {
            case 'Linux':
                if (!empty(shell_exec($this->getProcessLister($process)))) {
                    return true;
                }
                break;
            case 'Windows':
                if (strpos(shell_exec($this->getProcessLister($process)), "program")) {
                    return true;
                }
                break;
        }
        return false;
    }
}
