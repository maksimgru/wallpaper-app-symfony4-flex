<?php
namespace App\Service;

/**
 * Class FileDeleter
 * @package App\Service
 */
interface FileDeleter
{
    /**
     * This is Description of delete
     *
     * @param string $relPathToFile
     *
     * @return void
     */
    public function delete($relPathToFile);
}