<?php

namespace Ahmedkhd\Dorm\Strategy;

trait JavaStrategy
{
    /**
     * This function will compile the java code
     * @param $code
     * @param $compiler
     * @return bool
     */
    public function compileJava($code, $compiler)
    {
        $this->setCompiler($compiler);
        $compiler_configs = Config::getCompilerConfigs($compiler);

        //save the code in a file with that extension
        $file_name =  $this->getCompilationPath() . DS . $compiler_configs['main_class'] . $compiler_configs['file_extension'] ;
        file_put_contents($file_name, $code);

        //run the command that compiles the code in that file
        $command = $compiler_configs['path_compile'] . " " . $file_name . " 2>&1";

        //i did not use Core::runCommand because its not build for compilation
        exec($command, $output, $status);

        return ( empty($output) ? true : $output );
    }

    /**
     * This function will compile the java code
     * @param null $input_file
     * @param null $output_file
     * @return string
     */
    public function runJava($input_file = null, $output_file = null)
    {
        $configs = Config::getCompilerConfigs($this->getCompiler());

        if ($input_file == null && $output_file == null) {
            //get the class name and run it using java command
            $command = "cd " . $this->getCompilationPath() . DS . " & ";
            $command .= $configs['path_run'] . " " . $configs['main_class'] . " 2>&1";
            $output = exec($command);

            return $output;
        }
    }
}
