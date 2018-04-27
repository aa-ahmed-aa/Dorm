<?php
namespace Ahmedkhd\Dorm;

Class Core{

	 private $compilationPath;

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

        $sx=shell_exec("tasklist");
        
        while( strpos($sx, "program.exe") != false ) {

            $sx=shell_exec("tasklist");

            if(time()-$time>5)
            {
        
                system("taskkill /im program.exe /f");
        
                return false;
        
            }
        
        }

        return $output;
    
    }
}
?>