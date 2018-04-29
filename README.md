# Dorm
This is a package for running and compiling your c and c++ files add the compiler to the configurations file and you are ready to go :boom: .

## Install :honey_pot:

## Configuration :hammer:
First you need to install c/c++ compiler gcc/g++ and configure their paths in the package<br>
- you can find the MinGW compiler <a href="https://nuwen.net/mingw.html">Here</a><br>
- after you download the compiler files copy the `MinGW` folder to your `C://` drive<br>

## Usage :flashlight:

## Add your compiler :electric_plug:
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