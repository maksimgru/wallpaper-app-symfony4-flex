<?php

namespace App\Service;

/**
 * Class ImageFileDimensionsHelper
 * @package App\Service
 */
class ImageFileDimensionsHelper
{
    /**
     * @var array $imageSizeAttributes
     */
    private $imageSizeAttributes;


    /**
     * This is Description of setImageFilePath
     *
     * @param string $filepath
     *
     * @return void
     */
    public function setImageFilePath($filepath)
    {
        $this->imageSizeAttributes = getimagesize($filepath);
    }

    /**
     * This is Description of getWidth
     *
     * @return int
     */
    public function getWidth()
    {
        try {
            return (int) $this->imageSizeAttributes[0];
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * This is Description of getHeight
     *
     * @return int
     */
    public function getHeight()
    {
        try {
            return (int) $this->imageSizeAttributes[1];
        } catch (\Exception $e) {
            return 0;
        }
    }
}
