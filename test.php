<?php 
	require ('vendor/autoload.php');
	use Ahmedkhd\Dorm\Dorm;

	$obj = new Dorm();

	//set compilation path
	$obj->setCompilationPath( __DIR__ );

	$cpp_code = <<<'EOT'
	#include<iostream>
	using namespace std;

	int main()
	{
	    cout<<"hello, world";
	    return 0;
				}
EOT;

	$comp = $obj->compile( $cpp_code, "cpp" );

	echo ( !empty( $obj->run() ) ? $obj->run() : "fail" ) ;

?>