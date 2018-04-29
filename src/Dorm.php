<?php
namespace Ahmedkhd\Dorm;

use Ahmedkhd\Dorm\Core;
use Ahmedkhd\Dorm\Config;
 
if( ! defined('ACCEPTED') ) 
    define('ACCEPTED', 0);

if( ! defined('WRONG_ANSWER') ) 
    define('WRONG_ANSWER', 1);

if( ! defined('TIME_LIMIT_EXCEEDED') ) 
    define('TIME_LIMIT_EXCEEDED', 2);

if( ! defined('COMPILER_ERROR') ) 
    define('COMPILER_ERROR', 3);

if( ! defined('DS') ) 
    define('DS', DIRECTORY_SEPARATOR);

class Dorm extends Core{
    /**
     * this function will create a temp cpp file to run the code and will return the response
     * @param $code => the code cpp or java
     * @param $compiler => compiler we will use to compile this code
     * @return bool => true if the code run successfuly, false otherwise
     */
    public function compile( $code, $compiler )
    {
        
        $com_conf = Config::getCompiler($compiler);
        
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

    /**
     * @param $input_file => the input that we will run the code on
     * @param $output_file => the correct output to compare with
     * @return string => return the output of the run "Accepted" or "Wrong Answer" to the
     * matched test cases or "Compilation error" if not compiled
     */
    public function run($input_file , $output_file)
    {
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

    
}
?>