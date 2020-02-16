<?php
/**
 * Created by PhpStorm.
 * User: ahmed
 * Date: 2/16/20
 * Time: 1:31 AM
 */

namespace Ahmedkhd\Dorm\Helpers;


trait CleanUpHelpers
{
    /**
     * Deletes directory content then delete the directory
     * @param $dir
     * @return bool
     */
    public function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }

    /**
     * Create the directory if not existed
     * @param $path => full path of the folder to create
     */
    public function createFolderIfNotExisted($path)
    {
        if (!file_exists($path)) {
            mkdir($path);
        }
    }

    /**
     * Removes the pathes passed to the function
     * @param $files_to_delete => files to be deleted
     */
    public function cleanCompilationFolder($files_to_delete)
    {
        foreach ($files_to_delete as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }
}
