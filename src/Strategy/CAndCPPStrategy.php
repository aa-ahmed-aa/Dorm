<?php

namespace Ahmedkhd\Dorm\Strategy;

trait CAndCPPStrategy
{
    /**
     * Only compiles the c/cpp fields
     * @param $code => code to compile
     * @param $compiler => used compiler
     * @return bool
     */
    public function compileCAndCPP($code, $compiler)
    {
        $this->setCompiler($compiler);
        $com_conf = $this->getCompilerConfigs($compiler);

        //put the code in a random file
        $file_name = $this->getCompilationPath().DS.rand(0, 999999)."_".time().$com_conf['file_extension'];
        file_put_contents($file_name, $code);
        $executable = $this->getCompilationPath() . DS . "program." . $this->getExecutableExtension(CPP);

        //construct the command based on the compiler
        $compiler_path = $com_conf['path'];
        $command = $compiler_path . " -o ". $executable ." ".$file_name." 2>&1";

        //i did not use Core::runCommand because its not build for compilation
        exec($command, $output, $status);

        return ( empty($output) ? true : false );
    }

    /**
     * Runs the c and cpp files
     * @param null $input_file
     * @param null $output_file
     * @return bool|int|string
     */
    public function runCAndCPP($input_file = null, $output_file = null)
    {
        if ($input_file == null && $output_file == null) {
            //execute the .exe file
            $command = "cd " . $this->getCompilationPath() . DS . " & ";
            $command .= $this->getCompilationPath() . DS . "program.".$this->getExecutableExtension(CPP)." 2>&1";
            $output = exec($command);

            return $output;
        }

        //write input file to disk
        file_put_contents($this->getCompilationPath() . DS . $input_file['file_name'], $input_file['file_content']);

        //execute the .exe file
        $command = $this->runStrategy();
        $output = $this->runCommand($command);

        if ($output === TIME_LIMIT_EXCEEDED) {
            return TIME_LIMIT_EXCEEDED;
        }

        //compare the output file with user output file
        $output_file_name = $this->getCompilationPath() . DS . $output_file['file_name'];
        $user_output = file_get_contents($output_file_name);
        $correct_output = $output_file['file_content'];

        // die( "\nthis is user out\n" . $user_output . "\nthis is the correct out\n" . $correct_output );

        if (strcmp($user_output, $correct_output) == 0) {
            $this->cleanCompilationFolder([$output_file_name]);
            return ACCEPTED;
        }

        $this->cleanCompilationFolder([$output_file_name]);
        return WRONG_ANSWER;
    }
}
