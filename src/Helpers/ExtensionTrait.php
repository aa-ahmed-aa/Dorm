<?php

namespace Ahmedkhd\Dorm\Helpers;

trait ExtensionTrait
{
    /**
     * Get the executable files extenstion for Any OS
     * @param $language
     * @return string
     */
    public function getExecutableExtension($language)
    {
        switch (PHP_OS) {
            case 'Linux':
                return $this->getExtensionForLinux($language);
                break;
            case 'Windows':
                return $this->getExtensionForWindows($language);
                break;
        }
    }

    /**
     * Get the executable files extenstion for windows
     * @param $language
     * @return string
     */
    public static function getExtensionForWindows($language)
    {
        switch ($language) {
            case C:
                return 'exe';
                break;
            case CPP:
                return 'exe';
                break;
        }
    }

    /**
     * Get the executable files extenstion for linux
     * @param $language
     * @return string
     */
    public static function getExtensionForLinux($language)
    {
        switch ($language) {
            case C:
                return 'o';
                break;
            case CPP:
                return 'o';
                break;
        }
    }
}
