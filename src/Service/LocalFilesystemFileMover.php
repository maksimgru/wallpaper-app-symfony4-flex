<?php

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class FileMover
 * @package App\Service
 */
class LocalFilesystemFileMover implements FileMover
{
    /**
     * @var Filesystem $fileSystem
     */
    private $fileSystem;

    public function __construct(Filesystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    /**
     * This is Description of move
     *
     * @param string $tempFilePath
     * @param string $newFilePath
     * @param bool $overwrite Whether to overwrite the target if it already exists
     *
     * @return boolean
     */
    public function move($tempFilePath, $newFilePath, $overwrite = true)
    {
        $this->fileSystem->rename($tempFilePath, $newFilePath, $overwrite);

        return true;
    }
}
