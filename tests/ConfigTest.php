<?php

namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Config;

class ConfigTest extends \PHPUnit_Framework_TestCase
{

    /**
    * this will check for any syntax error
    */
    public function testIsThereAnySyntaxError()
    {
        $var = new Config();
        $this->assertTrue(is_object($var));

        unset($var);
    }

    /**
    * @test Config::getCompiler
    */
    public function test_get_compiler_function()
    {
        $obj = new Config();

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

        foreach ($compilers as $key => $compiler) {
            $this->assertTrue($obj->getCompiler($key) == $compiler);
        }
    }
}
