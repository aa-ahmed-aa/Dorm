<?php
namespace Ahmedkhd\Dorm;

require_once("list_of_defines.php");

Class Core{

	private $compilationPath;
    private $compiler;

    /*
    * Set the compiler
    * @param $compiler => compiler of the current code
    */
    public function setCompiler( $compiler )
    {
        $this->compiler = $compiler;
    }

    /*
    * Get the compiler
    * @param $compiler => compiler of the current code
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
        
        if(!file_exists($path))
        {
            mkdir($path);
        }

    }

    /**
     * Removes the pathes passed to the function
     * @param $files_to_delete => files to be deleted
     */
    public function cleanCompilationFolder($files_to_delete)
    {
           foreach($files_to_delete as $file)
           {

               if(file_exists($file))
                    unlink($file);
           
           }
    }

    /*
    * only compiles the c/cpp fiels 
    * @param $code => the code to compile
    * @param $compiler => the compile it self whether it is c or cpp 
    */
    public function compileCAndCPP( $code, $compiler )
    {
        $this->setCompiler( $compiler );

        $com_conf = Config::getCompilerConfigs($compiler);
        
        //put the code in a random file
        $file_extension = $com_conf['file_extension'];

        $random_name = rand(0,999999) . "_" . time() . $file_extension ;

        $file_name = $this->getCompilationPath() . DS . $random_name ;

        file_put_contents( $file_name, $code );

        $executable = $this->getCompilationPath() . DS . "program.exe";

        //construct the command based on the compiler
        $compiler_path = $com_conf['path'];
        
        $command = $compiler_path . " -o ". $executable ." ".$file_name." 2>&1";

        //i did not use Core::runCommand because its not build for compilation
        exec( $command , $output, $status);

        return ( empty($output) ? true : false );
    }

    /*
    * runs the c and cpp files
    * @param  
    */
    public function runCAndCPP( $input_file = NULL, $output_file = NULL )
    {
        if( $input_file == NULL && $output_file == NULL )
        {
             //execute the .exe file
            $command = "cd " . $this->getCompilationPath() . DS . " & ";
            $command .= $this->getCompilationPath() . DS . "program.exe 2>&1";
            $output = exec($command);

            return $output;
        }

        //write input file to disk
        file_put_contents($this->getCompilationPath() . DS . $input_file['file_name'], $input_file['file_content']);

        //execute the .exe file
        $command = "cd " . $this->getCompilationPath() . DS . " & ";
        $command .= $this->getCompilationPath() . DS . "program.exe 2>&1";
        $output = $this->runCommand($command);

        if($output == TIME_LIMIT_EXCEEDED)
            return TIME_LIMIT_EXCEEDED;

        //error happened while run
        if( ! empty($output) )
        {
            return WRONG_ANSWER;
        }

        //compare the output file with user output file
        $output_file_name = $this->getCompilationPath() . DS . $output_file['file_name'];
        $user_output = file_get_contents($output_file_name);
        $correct_output = $output_file['file_content'];

        // die( "\nthis is user out\n" . $user_output . "\nthis is the correct out\n" . $correct_output );

        if( strcmp($user_output, $correct_output) == 0 )
        {
            $this->cleanCompilationFolder([$output_file_name]);
            return ACCEPTED;
        }

        $this->cleanCompilationFolder([$output_file_name]);
        return WRONG_ANSWER;
    }

    /**
     * this function will timeout after 5 second to handle the time limit exceeded
     * @param $command => the command we will run
     * @return string => return the time_limit_exceeded if the time is greater than 5 second
     */
    public function runCommand($command)
    {
        $descriptorspec = array(
            
            0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
            
            1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
            
            2 => array("file", "error-output.txt", "a") // stderr is a file to write to

        );

        $time = time();

        $output = '';
        
        $process = proc_open($command, $descriptorspec, $pipes);

        sleep(2);
        
        if( strpos(shell_exec("tasklist"), "program.exe") )
        {

            system("taskkill /im program.exe /f");
            
            return TIME_LIMIT_EXCEEDED;
        
        }

        return $output;
    
    }
}
?>