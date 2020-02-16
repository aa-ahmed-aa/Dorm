<?php

namespace Ahmedkhd\Dorm;

use Ahmedkhd\Dorm\Core\Config;
use Ahmedkhd\Dorm\Core\Core;

class Executor extends Core
{
    /**
     * Executor constructor.
     * @param $compiler
     */
    public function __construct($compiler)
    {
        $this->setCompiler($compiler);
        parent::__construct();
    }

    /**
     * This function will create a temp cpp file to run the code and will return the response
     * @param $code => the code cpp or java
     * @param $compiler => compiler we will use to compile this code
     * @return bool => true if the code run successfuly, false otherwise
     */
    public function compile($code)
    {
        $compiler = $this->getCompiler();
        $func = Config::getCompilerConfigs($compiler)['compile_func'];
        return $this->$func($code, $compiler);
    }

    /**
     * @param $input_file => the input that we will run the code on
     * @param $output_file => the correct output to compare with
     * @return string => return the output of the run "Accepted" or "Wrong Answer" to the
     * matched test cases or "Compilation error" if not compiled
     */
    public function run($input_file = null, $output_file = null)
    {
        $func = Config::getCompilerConfigs($this->getCompiler())['run_func'];
        return $this->$func($input_file, $output_file);
    }
}
