# Dorm
This is a package for running and compiling your c and c++ files add the compiler to the configurations file and you are ready to go :boom: .

## :honey_pot: Install 
You can install the package using `composer require aa-ahmed-aa/dorm`
### OR
to your `composer.json` file add this to your require list
```
{
    "require": {
        "aa-ahmed-aa/dorm": "~1.1"
    }
}
```
then run `composer update`
## :hammer: Configuration 
First you need to install c/c++ compiler gcc/g++ and configure their paths in the package<br>
- you can find the MinGW compiler <a href="https://nuwen.net/mingw.html">Here</a><br>
- after you download the compiler files copy the `MinGW` folder to your `C://` drive<br>

## :flashlight: Usage 
First you need to `setCompilationPath` in this path the package will create files of the code and compile and run your code <br>
so let's compile and run your first cpp code
```php
require ('vendor/autoload.php');
use Ahmedkhd\Dorm\Dorm;

$obj = new Dorm();

//set compilation path
$obj->setCompilationPath( __DIR__ );
echo $obj->getCompilationPath();
``` 
Now lets compile and run some real code

#### C++
here we compile and run c++ code and print the result
```php
$cpp_code = <<<'EOT'
	#include<iostream>
	using namespace std;

	int main()
	{
	    cout<<"hello, c plus plus";
	    return 0;
				}
EOT;
	
	$comp = $obj->compile( $cpp_code, "cpp" );
	echo "Compilation : " . ( ! is_array($comp) ? "Success" : "Fail" )  . "\n";
	echo "Running is : " . ( ! is_array($comp) ? $obj->run() : "Fail" ) . "\n";
```

#### Java

```php
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
```

#### Python

```php
$python_code = <<<'EOT'
print "Hello, Python3.4"
EOT;

	$comp = $obj->compile( $python_code, "python2" );
	echo "Running : " . implode( $comp )  . "\n";
```

## :electric_plug: Add your compiler 
This package is designed to handle compile/run of any other compilers in your project so you can check this class `src/Config.php` and add your configurations<br>
```php
	$compilers = [
		"__COMPILER_NAME__"=>[
			"path" => "__COMPILER_PATH__",
			"file_extension" =>'__CODE_FILE_EXTENSION_',
			"compile_func" => __NAME_FOR_YOUR_COMPILER_FUNCTION__,
			"run_func" => __NAME_FOR_YOUR_RUN_FUNCTION__
		]
	];
```
##### Steps
-Add your customized key for your configuration to use it later in your compile and run function see `src/Config.php`.
-Add run and compile functions for your compiler as you named in the configuration array.
-Test and Bom your compiler is there.
## License
The MIT License (MIT). Please see [License](https://github.com/aa-ahmed-aa/Dorm/blob/master/LICENSE) File for more information.
