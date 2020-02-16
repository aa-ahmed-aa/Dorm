<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 2/16/20
 * Time: 1:51 AM
 */

namespace Ahmedkhd\Dorm\Strategy;


trait PythonStrategy
{
    /**
     * This function will run the python code
     */
    public function runPython($code, $compiler)
    {
        // put the code in a  random file with .py extension
        $this->setCompiler($compiler);

        // die($code);
        $compiler_configs = Config::getCompilerConfigs($compiler);

        //put the code in a random file
        $file_name = $this->getCompilationPath() . DS . rand(0, 999999) . "_" . time() . $compiler_configs['file_extension'];

        file_put_contents($file_name, $code);

        //run code and return output
        $command =  $compiler_configs['path'] . " " . $file_name;

        exec($command, $output, $status);

        return ( empty($output) ? true : $output );
    }
}
