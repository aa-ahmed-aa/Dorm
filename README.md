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
First you need to install compilers and configure their paths in `src/Config.php`<br>
#### C++
- you can find the MinGW compiler <a href="https://nuwen.net/mingw.html">Here</a><br>
- after you download the compiler files copy the `MinGW` folder to your `C://` drive<br>
#### Java
- install jdk and configure the path in your environment variables you can find the judk <a href="http://www.oracle.com/technetwork/java/javase/downloads/index.html">Here</a><br>
#### Python
- install python from <a href="https://www.python.org/downloads/">Here</a> 
- if you want this package to handle both versions of `python2.x` and `python3.x` the package already do this and you can look at <a href="https://stackoverflow.com/a/4621277/5701752">This Question</a> to cnfigure both of them on the command line  

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
You can check this <a href="https://dev.to/aaahmedaa/dorm-introducing-multi-compiler-package--for-php-15m6">blog post</a> for more information.<br>
<br>
This package is designed to handle compile/run of any other compilers in your project <br>
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
- Add your customized key for your configuration to use it later in your compile and run function see `src/Config.php`.<br>
- Add run and compile functions for your compiler as you named in the configuration array.<br>
- Test and Bom your compiler is there.<br>
## License
The MIT License (MIT). Please see [License](https://github.com/aa-ahmed-aa/Dorm/blob/master/LICENSE) File for more information.
