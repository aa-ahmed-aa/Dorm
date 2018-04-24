<?php 
include_once('..\src\configuration.php');

include_once('..\src\Core.php');

include_once('..\src\Dorm.php');


class ConfigurationTest extends PHPUnit_Framework_TestCase{

	public function setUp(){ }

	public function tearDown(){ }

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

			"c++"=>[

				"path" => "C:\MinGW\bin\g++.exe",

				"file_extension" =>'.cpp'

			],

			"c"=>[

				"path" => "C:\MinGW\bin\gcc.exe",

				"file_extension" =>'.c'

			],

		];

		foreach($compilers as $key => $compiler)
		{

			$this->assertTrue( $obj->getCompiler($key) == $compiler );	

		}
		
	}

	/**
	* @test Core::create_folder_if_not_existed
	*/
	public function test_create_folder_if_not_existed()
	{

		$obj = new Core();

		$path = 'C:\xampp\htdocs\Dorm\testdir';

		$obj->createFolderIfNotExisted($path);

		$this->assertTrue( file_exists($path) );

	}

	/**
  	* @test Core::set_compilation_path
  	*/
	public function test_set_get_compilation_path()
	{
		//create new object of core class
		$c = new Core();

		//then set the compiler and check for the value of the compiler
		$path = 'C:\xampp\htdocs\Dorm\testdir';

		$c->setCompilationPath( $path );

		$gotten_path = $c->getCompilationPath();

		$this->assertTrue( $gotten_path === $path );
	}

	/**
	*
	*/
	public function test_clean_compilation_folder()
	{
		
		$c = new Core();
		
		$path = 'C:\xampp\htdocs\Dorm\testdir';
		
		$c->createFolderIfNotExisted($path);

		touch( $path.'\ahmed.test' );

		$this->assertTrue( file_exists('C:\xampp\htdocs\Dorm\testdir\ahmed.test') );

		$c->cleanCompilationFolder([ $path . '\ahmed.test' ]);

		$this->assertTrue( !file_exists('C:\xampp\htdocs\Dorm\testdir\ahmed.test') );

	}


}
?>