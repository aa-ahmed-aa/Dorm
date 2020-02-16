<?php
require_once('./vendor/autoload.php');

use Ahmedkhd\Dorm\Executor;

$obj = new Executor("cpp");
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

$comp = $obj->compile($cpp_code);
echo "Compilation : " . ( ! is_array($comp) ? "Success" : "Fail" )  . "\n";
echo "Running is : " . ( ! is_array($comp) ? $obj->run() : "Fail" ) . "\n";
