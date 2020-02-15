<?php
namespace Ahmedkhd\Dorm;

class Core
{
    private $compilationPath;
    private $compiler;

    /**
     * Core constructor.
     */
    public function __construct()
    {
        require_once('./src/list_of_defines.php');
    }

    /**
     * Set the compiler
     * @param $compiler => compiler of the current code
     */
    public function setCompiler($compiler)
    {
        $this->compiler = $compiler;
    }

    /**
     * Get the compiler
     * @return mixed
     */
    public function getCompiler()
    {
        return $this->compiler;
    }

    /**
     * Set the compilation path and create it if not existed
     * @param $path => path of the compilation folder to can create and maintain inputs and outputs files easily
     */
    public function setCompilationPath($path)
    {
        $this->createFolderIfNotExisted($path);
        $this->compilationPath = $path;
    }

    /**
     * Get the compilation path
     * @return mixed
     */
    public function getCompilationPath()
    {
        return $this->compilationPath;
    }

    /**
     * Create the directory if not existed
     * @param $path => full path of the folder to create
     */
    public function createFolderIfNotExisted($path)
    {
        if (!file_exists($path)) {
            mkdir($path);
        }
    }

    /**
     * Removes the pathes passed to the function
     * @param $files_to_delete => files to be deleted
     */
    public function cleanCompilationFolder($files_to_delete)
    {
        foreach ($files_to_delete as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Only compiles the c/cpp fields
     * @param $code => code to compile
     * @param $compiler => used compiler
     * @return bool
     */
    public function compileCAndCPP($code, $compiler)
    {
        $this->setCompiler($compiler);
        $com_conf = Config::getCompilerConfigs($compiler);

        //put the code in a random file
        $file_name = $this->getCompilationPath().DS.rand(0, 999999)."_".time().$com_conf['file_extension'];
        file_put_contents($file_name, $code);
        $executable = $this->getCompilationPath() . DS . "program." . Config::getExecutableExtension('cpp');

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
            $command .= $this->getCompilationPath() . DS . "program.".Config::getExecutableExtension('cpp')." 2>&1";
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


    /**
    * This function will run the java code
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
        if (Config::isProcessStillRunning('program.'.Config::getExecutableExtension('cpp'))) {
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
                    " && .".DS."program.".Config::getExecutableExtension('cpp')." 2>&1";
                break;
            case 'Windows':
                return "cd ".
                    $this->getCompilationPath() . DS . " & ".
                    $this->getCompilationPath() . DS . "program.".Config::getExecutableExtension('cpp')." 2>&1";
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
                $processToKill = shell_exec(Config::getProcessLister('program.'.Config::getExecutableExtension('cpp')) . ' 2>&1');
                system(Config::getProcessKiller($this->getCompiler(), $processToKill));
                break;
            case 'Windows':
                system(Config::getProcessKiller($this->getCompiler(), "program.exe"));
                break;
        }
    }
}
