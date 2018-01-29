<?php

namespace App\Service;

/**
 * Class WallpaperFilePathHelper
 * @package App\Service
 */
class WallpaperFilePathHelper
{
    /**
     * @var string
     */
    private $wallpaperFileDirectory;

    /**
     * @param $wallpaperFileDirectory
     */
    public function __construct($wallpaperFileDirectory)
    {
        $this->wallpaperFileDirectory = $this
            ->ensureHasTrailingSlash(
                $wallpaperFileDirectory
            )
        ;
    }

    /**
     * This is Description of getNewFilePath
     *
     * @param string $newFileName
     *
     * @return string
     */
    public function getNewFilePath($newFileName)
    {
        $newFileName = $this->ensureHasNoLeadingSlash($newFileName);

        return $this->wallpaperFileDirectory . $newFileName;
    }


    /**
     * This is Description of ensureHasTrailingSlash
     *
     * @param string $path
     *
     * @return string
     */
    private function ensureHasTrailingSlash($path)
    {
        return rtrim($path, '/') . '/';
    }

    /**
     * This is Description of ensureHasNoLeadingSlash
     *
     * @param string $path
     *
     * @return string
     */
    private function ensureHasNoLeadingSlash($path)
    {
        return ltrim($path, '/');
    }
}