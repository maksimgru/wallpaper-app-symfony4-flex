<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class LocalFilesystemFileDeleter
 * @package App\Service
 */
class LocalFilesystemFileDeleter implements FileDeleter
{
    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;
    /**
     * @var string $wallpaperBaseDir
     */
    private $wallpaperBaseDir;

    /**
     * Create new LocalFilesystemFileDeleter instance.
     *
     * @param Filesystem $filesystem
     * @param string $wallpaperBaseDir
     */
    public function __construct (Filesystem $filesystem, $wallpaperBaseDir)
    {
        $this->filesystem = $filesystem;
        $this->wallpaperBaseDir = $wallpaperBaseDir;
    }


    /**
     * This is Description of delete
     *
     * @param string $fileName
     *
     * @return void
     */
    public function delete($fileName)
    {
        $this->filesystem->remove(
            $this->wallpaperBaseDir . '/' . $fileName
        );
    }
}