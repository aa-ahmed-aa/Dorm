<?php
namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase{

	/**
	* this will check for any syntax error
	*/
	public function testIsThereAnySyntaxError(){

	  	$var = new Config();

	  	$this->assertTrue(is_object($var));

	  	unset($var);

  	}

  	/**
  	* @test Config::getCompiler
  	*/
	public function test_get_compiler_function()
	{

		$obj = new Config();

		$compilers = [

			"cpp" => [
				"path" => "C:\MinGW\bin\g++.exe",      // if you use environment variables use g++ without the complete path
				"file_extension" =>".cpp",
				"compile_func" => "compileCAndCPP",
				"run_func" => "runCAndCPP"
			],
			
			"c" => [
				"path" => "C:\MinGW\bin\gcc.exe",      // if you use environment variables use gcc without the complete path
				"file_extension" => ".c",
				"compile_func" => "compileCAndCPP",
				"run_func" => "runCAndCPP"
			],

			"java" => [
				"path_compile" => "C:\\\"Program Files\\\"\Java\jdk1.8.0_25\bin\javac.exe",      // if you use environment variables use javac without the complete path     
				"path_run" => "C:\\\"Program Files\\\"\Java\jdk1.8.0_25\bin\java.exe",           // if you use environment variables use java without the complete path
				"main_class" => "Main",
				"file_extension" => ".java",
				"compile_func" => "compileJava",
				"run_func" => "runJava"
			],

			"python2" => [
				"path" => "C:\Python27\python2.exe",      // if you use environment variables use python2 without the complete path
				"file_extension" => ".py",
				"run_func" => "runPython"
			],

			"python3" => [
				"path" => "C:\Python34\python3.exe",       // if you use environment variables use python3 without the complete path
				"file_extension" => ".py",
				"run_func" => "runPython"
			]

		];

		foreach($compilers as $key => $compiler)
		{

			$this->assertTrue( $obj->getCompilerConfigs($key) == $compiler );	

		}
		
	}

	

}
?>