<?php
namespace App\Service;

/**
 * Class FileMover
 * @package App\Service
 */
interface FileMover
{
    /**
     * This is Description of move
     *
     * @param string $existingFilePath
     * @param string $newFilePath
     *
     * @return boolean
     */
    public function move ($existingFilePath, $newFilePath);
}