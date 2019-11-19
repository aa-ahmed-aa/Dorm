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
	$comp = $obj->compile( $correct_code, 'cpp' );
	$this->assertTrue( $comp );

	$comp = $obj->compile( $syntax_error, 'cpp');
	$this->assertTrue( ! $comp );

  	}

	/**
	* 
	*/
  	public function test_run_accepted()
	{
		$input_file = [
			'file_name' => 'in.txt',
			'file_content' => "6
4 5
87 8
8 7
9 6
4 5
5 4
"
		];

		$correct_output_file = [
			'file_name' => 'out.txt',
			'file_content' => "9
95
15
15
9
9
"
		];

		$correct_code = <<<'EOD'
		#include <bits/stdc++.h>

using namespace std;

int main()
{
    freopen("in.txt","r",stdin);
    freopen("out.txt","w",stdout);
    int n,x,y;

    cin>>n;
    while(n--)
    {
        cin>>x>>y;
        cout<<x+y<<endl;
    }

    return 0;
}
EOD;
		
		$obj = new Dorm();

		$obj->setCompilationPath( TEST_COMPILER_DIR );

		//compile
		$comp = $obj->compile( $correct_code, 'cpp' );
		$this->assertTrue( $comp );

		//test eccepted
		$run = $obj->run($input_file, $correct_output_file);
		$this->assertTrue( $run == ACCEPTED );		
	}

	public function test_run_wrong_answer()
	{
		$input_file = [
			'file_name' => 'in.txt',
			'file_content' => "6
4 5
87 8
8 7
9 6
4 5
5 4
"
		];

		$wrong_output_file = [
			'file_name' => 'out.txt',
			'file_content' => "9
95
15
15
9
"
		];

		$correct_code = <<<'EOD'
		#include <bits/stdc++.h>

		using namespace std;

		int main()
		{
		    freopen("in.txt","r",stdin);
		    freopen("out.txt","w",stdout);
		    int n,x,y;

		    cin>>n;
		    while(n--)
		    {
		        cin>>x>>y;
		        cout<<x+y<<endl;
		    }

		    return 0;
		}
EOD;

		$obj = new Dorm();
		$obj->setCompilationPath( TEST_COMPILER_DIR );

		//compile
		$comp = $obj->compile( $correct_code, 'cpp' );
		$this->assertTrue( $comp );

		//test wrong_answer
		$run = $obj->run($input_file, $wrong_output_file);
		$this->assertTrue( $run == WRONG_ANSWER );
	}

	public function test_run_time_limit_exceeded()
	{
		$input_file = [
			'file_name' => 'in.txt',
			'file_content' => "6
4 5
87 8
8 7
9 6
4 5
5 4
"
		];

		$correct_output_file = [
			'file_name' => 'out.txt',
			'file_content' => "9
95
15
15
9
9
"
		];

		$time_limit_code = <<<'EOD'
		#include <bits/stdc++.h>

		using namespace std;

		int main()
		{
		    freopen("in.txt","r",stdin);
		    freopen("out.txt","w",stdout);
		    int n,x,y;

		    cin>>n;
		    while(true)
		    {
		        cout<<"ecco";
		    }

		    return 0;
		}
EOD;

		$obj = new Dorm();
		$obj->setCompilationPath( TEST_COMPILER_DIR );

		//test time_limit_exceeded
		$comp = $obj->compile( $time_limit_code, 'cpp' );
		$this->assertTrue( $comp );

		$time = $obj->run( $input_file, $correct_output_file );
		$this->assertTrue( $time == TIME_LIMIT_EXCEEDED );
	}
}

?>