<?php
namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Core\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * This will check for any syntax error
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
    public function testGetCompilerFunction()
    {
        $obj = new Config();
        $compilers = Config::getCompilerConfigs();

        foreach ($compilers as $key => $compiler) {
            $this->assertTrue($obj->getCompilerConfigs($key) == $compiler);
        }
    }
}
