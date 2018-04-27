<?php 
namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Dorm;

class DormTest extends \PHPUnit_Framework_TestCase{

	public function tearDown()
	{
	
		foreach( glob( TEST_COMPILER_DIR . "\*.*" ) as $file )
		{
	
			unlink( $file );
	
		}

		rmdir(TEST_COMPILER_DIR);
	
	}

	/**
	* this will check for any syntax error
	*/
	public function testIsThereAnySyntaxError(){

	  	$var = new Dorm();

	  	$this->assertTrue(is_object($var));

	  	unset($var);

  	}

  	/*
  	* @test Dorm::compile code
  	*/
  	public function test_compile()
  	{

  		//get some code then compile this code
  		$correct_code = <<<'EOT'
			#include<iostream>
				using namespace std;

				int main()
				{
				    cout<<"hello, world";
				    return 0;
				}
EOT;

  		$syntax_error = <<<'EOT'
				#include<iostream>
				using namespace std;

				int main()
				{
					cout<<"hello, world";
				    return 0
				}
EOT;

	$obj = new Dorm();

	$obj->setCompilationPath( TEST_COMPILER_DIR );
	
	//check if compilation is ok or have errors
	$comp = $obj->compile( $correct_code, 'c++' );
	$this->assertTrue( $comp );

	$comp = $obj->compile( $syntax_error, 'c++');
	$this->assertTrue( ! $comp );

  	}

}

?>