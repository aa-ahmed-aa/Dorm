<?php

namespace Ahmedkhd\Dorm\Helpers;

trait CompilerTrait
{
    private $compilationPath;
    private $compiler;

    /**
     * Set the compiler
     * @param $compiler => compiler of the current code
     */
    public function setCompiler($compiler)
    {
        $this->compiler = $compiler;
    }

    /**
     * Get the compiler
     * @return mixed
     */
    public function getCompiler()
    {
        return $this->compiler;
    }

    /**
     * Set the compilation path and create it if not existed
     * @param $path => path of the compilation folder to can create and maintain inputs and outputs files easily
     */
    public function setCompilationPath($path)
    {
        $this->createFolderIfNotExisted($path);
        $this->compilationPath = $path;
    }

    /**
     * Get the compilation path
     * @return mixed
     */
    public function getCompilationPath()
    {
        return $this->compilationPath;
    }
}
