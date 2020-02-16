<?php
namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Executor;
use Ahmedkhd\Dorm\Helpers\CleanUpHelpers;
use PHPUnit\Framework\TestCase;

class ExecutorTest extends TestCase
{
    use CleanUpHelpers;

    public function setUp()
    {
        require_once('./src/Defines/list_of_defines.php');
        $this->deleteDirectory(TEST_COMPILER_DIR);
        mkdir(TEST_COMPILER_DIR);
    }

    public function tearDown()
    {
        $this->deleteDirectory(TEST_COMPILER_DIR);
    }

    /**
     * this will check for any syntax error
    */
    public function testIsThereAnySyntaxError()
    {
        $var = new Executor(CPP);
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * @test Executor::compile code
     */
    public function testCompile()
    {

        //get some code then compile this code
        $correct_code = '#include<iostream>
				using namespace std;

				int main()
				{
				    cout<<"hello, world";
				    return 0;
				}
            ';
        $syntax_error = '#include<iostream>
				using namespace std;

				int main()
				{
					cout<<"hello, world";
				    return 0
				}
            ';

        $obj = new Executor(CPP);
        $obj->setCompilationPath(TEST_COMPILER_DIR);

        //check if compilation is ok or have errors
        $comp = $obj->compile($correct_code);

        $this->assertTrue($comp);
        $comp = $obj->compile($syntax_error);
        $this->assertTrue(!$comp);
    }

    /**
     *
     */
    public function testRunAccepted()
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
"];

        $correct_code = '#include <bits/stdc++.h>
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
            ';

        $obj = new Executor(CPP);
        $obj->setCompilationPath(TEST_COMPILER_DIR);

        //compile
        $comp = $obj->compile($correct_code);
        $this->assertTrue($comp);

        //test accepted
        $run = $obj->run($input_file, $correct_output_file);
        $this->assertTrue($run == ACCEPTED);
    }

    public function testRunWrongAnswer()
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

        $correct_code = '
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
            ';
        $obj = new Executor(CPP);
        $obj->setCompilationPath(TEST_COMPILER_DIR);

        //compile
        $comp = $obj->compile($correct_code);
        $this->assertTrue($comp);

        //test wrong_answer
        $run = $obj->run($input_file, $wrong_output_file);

        $this->assertTrue($run == WRONG_ANSWER);
    }

    public function testRunTimeLimitExceeded()
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

        $time_limit_code = '
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
            ';
        $obj = new Executor(CPP);
        $obj->setCompilationPath(TEST_COMPILER_DIR);

        //test time_limit_exceeded
        $comp = $obj->compile($time_limit_code);
        $this->assertTrue($comp);
        $time = $obj->run($input_file, $correct_output_file);
        $this->assertTrue($time == TIME_LIMIT_EXCEEDED);
    }
}
