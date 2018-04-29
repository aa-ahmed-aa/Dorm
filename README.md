# Dorm
This is a package for running and compiling your c and c++ files add the compiler to the configurations file and you are ready to go :boom: .

## :honey_pot: Install 
You can install the package using `composer require aa-ahmed-aa/dorm`
### OR
to your `composer.json` file add this to your require list
```
{
    "require": {
        "aa-ahmed-aa/dorm": "~1.0"
    }
}
then run `composer update`
```
## :hammer: Configuration 
First you need to install c/c++ compiler gcc/g++ and configure their paths in the package<br>
- you can find the MinGW compiler <a href="https://nuwen.net/mingw.html">Here</a><br>
- after you download the compiler files copy the `MinGW` folder to your `C://` drive<br>

## :flashlight: Usage 
First you need to `setCompilationPath` in this path the package will create files of the code and compile and run your code <br>
so let's compile and run your first cpp code
```
require ('vendor/autoload.php');
use Ahmedkhd\Dorm\Dorm;

$obj = new Dorm();

//set compilation path
$obj->setCompilationPath( __DIR__ );
echo $obj->getCompilationPath();
``` 
Now lets compile some cpp stuff
```
$cpp_code = <<<'EOT'
	#include<iostream>
	using namespace std;

	int main()
	{
	    cout<<"hello, world";
	    return 0;
				}
EOT;
	$comp = $obj->compile( cpp_code, 'c++' );
	echo ($comp ? "success" : "fail" ) ;
```

## :electric_plug: Add your compiler 
This package is designed to handle compile/run of any other compilers in your project so you can check this class `src/Config.php` and add your configurations<br>
```
	$compilers = [
		"c++"=>[
			"path" => "__COMPILER_PATH__",
			"file_extension" =>'__CODE_FILE_EXTENSION_'
		]
	];
```
## Liscence
The MIT License (MIT). Please see [License](https://github.com/aa-ahmed-aa/Dorm/blob/master/LICENSE) File for more information.