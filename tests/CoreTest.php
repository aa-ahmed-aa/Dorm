<?php
namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Core;

class CoreTest extends \PHPUnit_Framework_TestCase{

	/**
	* this will check for any syntax error
	*/
	public function testIsThereAnySyntaxError(){

	  	$var = new Core();

	  	$this->assertTrue(is_object($var));

	  	unset($var);

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

		rmdir($path);
	
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

		rmdir($path);
	
	}

	/**
	* @test Core::clean_compilation_folder
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

		rmdir($path);
		
	}

}
?>