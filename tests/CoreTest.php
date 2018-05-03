<?php

namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Core;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

if (!defined('TEST_COMPILER_DIR')) {
    define('TEST_COMPILER_DIR', __DIR__ . DS . 'testDir');
}

class CoreTest extends \PHPUnit_Framework_TestCase
{
    /**
    * this will check for any syntax error
    */
    public function testIsThereAnySyntaxError()
    {
        $var = new Core();

        $this->assertTrue(is_object($var));

        unset($var);
    }

    /**
    * @test Core::create_folder_if_not_existed
    */
    public function test_create_folder_if_not_existed()
    {

        $obj = new Core();

        $obj->createFolderIfNotExisted(TEST_COMPILER_DIR);
        $this->assertTrue(file_exists(TEST_COMPILER_DIR));
    }

    /**
    * @test Core::set_compilation_path
    */
    public function test_set_get_compilation_path()
    {
        //create new object of core class
        $core = new Core();

        //then set the compiler and check for the value of the compiler
        $core->setCompilationPath(TEST_COMPILER_DIR);
        $gotten_path = $core->getCompilationPath();
        $this->assertTrue($gotten_path === TEST_COMPILER_DIR);
    }

    /**
    * @test Core::clean_compilation_folder
    */
    public function test_clean_compilation_folder()
    {

        $core = new Core();
        $core->createFolderIfNotExisted(TEST_COMPILER_DIR);

        touch(TEST_COMPILER_DIR . '\ahmed.test');

        $this->assertTrue(file_exists(TEST_COMPILER_DIR .DS. 'ahmed.test'));

        $core->cleanCompilationFolder([ TEST_COMPILER_DIR .DS. 'ahmed.test' ]);

        $this->assertTrue(!file_exists(TEST_COMPILER_DIR .DS. 'ahmed.test'));
    }
}
