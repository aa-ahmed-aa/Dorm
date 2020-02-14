<?php
require_once('./vendor/autoload.php');
require_once('./src/list_of_defines.php');
use Ahmedkhd\Dorm\Executor;

$obj = new Executor();

//set compilation path
$obj->setCompilationPath(__DIR__.'/cache');

//cpp
$cpp_code = <<<'EOT'
#include<iostream>
using namespace std;

int main()
{
	cout<<"hello, c plus plus";
	return 0;
			}
EOT;

$comp = $obj->compile($cpp_code, "cpp");
echo "Compilation : " . ( ! is_array($comp) ? "Success" : "Fail" )  . "\n";
echo "Running is : " . ( ! is_array($comp) ? $obj->run() : "Fail" ) . "\n";

echo '-----------------------------'."\n";
//java
$java_code = <<<'EOT'
public class Main {

public static void main(String[] args) {
	// Prints "Hello, World" to the terminal window.
	System.out.println("Hello, Java");
}

}
EOT;


$comp = $obj->compile( $java_code, "java" );
echo "Compilation : " . ( ! is_array($comp) ? "Success" : "Fail" )  . "\n";
echo "Running is : " . ( ! is_array($comp) ? $obj->run() : "Fail" ) . "\n";

echo '-----------------------------'."\n";
//python
$python_code = <<<'EOT'
print "Hello, Python3.4"
EOT;

$comp = $obj->compile( $python_code, "python2" );
echo "Running : " . implode( $comp )  . "\n";


?>
