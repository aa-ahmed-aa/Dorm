<?php
namespace Ahmedkhd\Dorm\Test;

use Ahmedkhd\Dorm\Core\Core;
use PHPUnit\Framework\TestCase;

class CoreTest extends TestCase
{
    /**
     * This will check for any syntax error
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
    public function testCreateFolderIfNotExisted()
    {
        $obj = new Core();
        $obj->createFolderIfNotExisted(TEST_COMPILER_DIR);
        $this->assertTrue(file_exists(TEST_COMPILER_DIR));
    }

    /**
     * @test Core::set_compilation_path
     */
    public function testSetGetCompilationPath()
    {
        //create new object of core class
        $c = new Core();

        //then set the compiler and check for the value of the compiler
        $c->setCompilationPath(TEST_COMPILER_DIR);
        $gotten_path = $c->getCompilationPath();
        $this->assertTrue($gotten_path === TEST_COMPILER_DIR);
    }

    /**
     * @test Core::clean_compilation_folder
     */
    public function testCleanCompilationFolder()
    {
        $c = new Core();
        $c->createFolderIfNotExisted(TEST_COMPILER_DIR);
        touch(TEST_COMPILER_DIR.DS.'ahmed.test');

        $this->assertTrue(file_exists(TEST_COMPILER_DIR.DS.'ahmed.test'));
        $c->cleanCompilationFolder([TEST_COMPILER_DIR.DS.'ahmed.test']);
        $this->assertTrue(!file_exists(TEST_COMPILER_DIR.DS.'ahmed.test'));
    }

//    /**
//     * @test Core::run_command
//     */
//    public function testRunCommand()
//    {
//        //this test should test for one specific task it's programe.exe
//        //and will close this task after 5 seconds
//        //and it will check for the output of this executable
//    }
}
