<?php
namespace Ahmedkhd\Dorm;

use Ahmedkhd\Dorm\Core;

class Dorm extends Core{
    /**
     * this function will create a temp cpp file to run the code and will return the response
     * @param $code => the code cpp or java
     * @param $compiler => compiler we will use to compile this code
     * @return bool => true if the code run successfult, false otherwise
     */
    public function compile( $code, $compiler )
    {
        $random_name = rand(0,999999)."_".time();

        if($compiler == "C")
        {
            $file_name = $this->getCompilationPath() . DS . $random_name . ".c";
        }else if($compiler == "C++")
        {
            $file_name = $this->getCompilationPath() . DS . $random_name . ".cpp";
        }


        file_put_contents($file_name,$code);

        $executable = $this->getCompilationPath() . DS . "program.exe";

        if($compiler == "C")
        {
            $command = GCC . " -o ". $executable ." ".$file_name." 2>&1";
        }else if($compiler == "C++")
        {
            $command = GPlusPLus . " -o ". $executable ." ".$file_name." 2>&1";
        }
        exec($command , $output, $status);

        if( empty($output) )
        {
            return true;
        }
        else
        {
            return false;
        }
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
        $output = $this->RunCommand($command);

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

        if( $user_output  == $correct_output )
        {
            $this->cleanCompilationFolder([$output_file_name]);
            return ACCEPTED;
        }
        $this->cleanCompilationFolder([$output_file_name]);

        return WRONG_ANSWER;
    }

    
}
?>