<?php
require_once('./vendor/autoload.php');

use Ahmedkhd\Dorm\Executor;

//java
$java_code = <<<'EOT'
public class Main {

public static void main(String[] args) {
	// Prints "Hello, World" to the terminal window.
	System.out.println("Hello, Java");
}

}
EOT;

$obj = new Executor("java");
$comp = $obj->compile($java_code);
echo "Compilation : " . ( ! is_array($comp) ? "Success" : "Fail" )  . "\n";
echo "Running is : " . ( ! is_array($comp) ? $obj->run() : "Fail" ) . "\n";
