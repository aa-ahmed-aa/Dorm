<?php

class Config{
	
	public function getCompiler( $compiler = null )
	{
		$compilers = [
			"c++"=>[
				"path" => "C:\MinGW\bin\g++.exe",
				"file_extension" =>'.cpp'
			],
			"c"=>[
				"path" => "C:\MinGW\bin\gcc.exe",
				"file_extension" =>'.c'
			],
		];

		return ( isset( $compiler ) ? $compilers[$compiler] : $compilers );
	}
}
?>