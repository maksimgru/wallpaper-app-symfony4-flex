<?php

namespace App\File;

use App\Model\FileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class SymfonyUploadedFile
 * @package App\File
 */
class SymfonyUploadedFile implements FileInterface
{
    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * Getter $file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Setter $file
     *
     * @param UploadedFile $file
     *
     * @return SymfonyUploadedFile
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }


    /**
     * This is Description of getPathname
     *
     * @param
     *
     * @return string
     */
    public function getPathname()
    {
        return $this->file->getPathname();
    }

    /**
     * This is Description of getFilename
     *
     * @param
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->file->getClientOriginalName();
    }
}
