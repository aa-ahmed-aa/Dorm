<?php
namespace Ahmedkhd\Dorm;

class Config
{
    /**
     * Get compiler configurations
     * @param null $compiler
     * @return array|mixed
     */
    public function getCompilerConfigs($compiler = null)
    {
        $compilers = [
            "cpp" => [
                // if you use environment variables use g++ without the complete path
                "path" => "g++",
                "file_extension" =>".cpp",
                "compile_func" => "compileCAndCPP",
                "run_func" => "runCAndCPP"
            ],
            "c" => [
                // if you use environment variables use gcc without the complete path
                "path" => "gcc",
                "file_extension" => ".c",
                "compile_func" => "compileCAndCPP",
                "run_func" => "runCAndCPP"
            ],
            "java" => [
                // make sure you did this TODO you must add path to jdk/bin to your environment variable
                "path_compile" => "javac",
                // make sure you did this TODO you must add path to jdk/bin to your environment variable
                "path_run" => "java",
                "main_class" => "Main",
                "file_extension" => ".java",
                "compile_func" => "compileJava",
                "run_func" => "runJava"
            ],
            "python2" => [
                // if you use environment variables use python2 without the complete path
                "path" => "python2",
                "file_extension" => ".py",
                "compile_func" => "runPython"
            ],
            "python3" => [
                // if you use environment variables use python3 without the complete path
                "path" => "python3",
                "file_extension" => ".py",
                "compile_func" => "runPython"
            ]
        ];

        return ($compiler != null ? $compilers[$compiler] : $compilers);
    }

    /**
     * Get the executable files extenstion for Any OS
     * @param $language
     * @return string
     */
    public function getExecutableExtension($language)
    {
        switch (PHP_OS) {
            case 'Linux':
                return Config::getExtensionForLinux($language);
                break;
            case 'Windows':
                return Config::getExtensionForWindows($language);
                break;
        }
    }

    /**
     * Get the executable files extenstion for windows
     * @param $language
     * @return string
     */
    public static function getExtensionForWindows($language)
    {
        switch ($language) {
            case 'c':
                return 'exe';
                break;
            case 'cpp':
                return 'exe';
                break;
        }
    }

    /**
     * Get the executable files extenstion for linux
     * @param $language
     * @return string
     */
    public static function getExtensionForLinux($language)
    {
        switch ($language) {
            case 'c':
                return 'o';
                break;
            case 'cpp':
                return 'o';
                break;
        }
    }

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
                if (!empty(shell_exec(Config::getProcessLister($process)))) {
                    return true;
                }
                break;
            case 'Windows':
                if (strpos(shell_exec(Config::getProcessLister($process)), "program")) {
                    return true;
                }
                break;
        }
        return false;
    }
}
