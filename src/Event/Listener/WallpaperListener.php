<?php

namespace App\Event\Listener;

use App\Entity\Wallpaper;
use App\Service\FileDeleter;
use App\Service\FileMover;
use App\Service\ImageFileDimensionsHelper;
use App\Service\WallpaperFilePathHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class WallpaperListener
 * @package App\Event\Listener
 */
class WallpaperListener
{
    /**
     * @var FileMover
     */
    private $fileMover;

    /**
     * @var FileDeleter $fileDeleter
     */
    private $fileDeleter;

    /**
     * @var WallpaperFilePathHelper
     */
    private $wallpaperFilePathHelper;

    /**
     * @var ImageFileDimensionsHelper $imageFileDimensionsHelper
     */
    private $imageFileDimensionsHelper;

    public function __construct(
        FileMover $fileMover,
        FileDeleter $fileDeleter,
        WallpaperFilePathHelper $wallpaperFilePathHelper,
        ImageFileDimensionsHelper $imageFileDimensionsHelper
    )
    {
        $this->fileMover = $fileMover;
        $this->fileDeleter = $fileDeleter;
        $this->wallpaperFilePathHelper = $wallpaperFilePathHelper;
        $this->imageFileDimensionsHelper = $imageFileDimensionsHelper;
    }

    /**
     * This is Description of prePersist
     *
     * @param LifecycleEventArgs $args
     *
     * @return boolean|Wallpaper
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        return $this->uploadFile($args->getEntity());
    }

    /**
     * This is Description of preUpdate
     *
     * @param PreUpdateEventArgs $args
     *
     * @return boolean|Wallpaper
     */
    public function preUpdate(PreUpdateEventArgs $args)
    {
        return $this->uploadFile($args->getEntity());
    }

    /**
     * This is Description of preRemove
     *
     * @param LifecycleEventArgs $args
     *
     * @return boolean|Wallpaper
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        /**
         * @var $entity Wallpaper
         */
        $entity = $args->getEntity();

        if (false === $entity instanceof Wallpaper) {
            return false;
        }

        if ($entity->getFilename() !== null) {
            $this->fileDeleter->delete($entity->getFilename());
        }

        $entity->setFile(null);

        return $entity;
    }

    /**
     * This is Description of uploadFile
     *
     * @param $entity
     *
     * @return boolean|Wallpaper
     */
    private function uploadFile($entity)
    {
        if (false === $entity instanceof Wallpaper) {
            return false;
        }

        /**
         * @var $entity Wallpaper
         */

        // get access to the file
        $file = $entity->getFile();

        if ($file && $entity->getFilename() !== null) {
            $this->fileDeleter->delete($entity->getFilename());
        }

        if (!$file) {
            return false;
        }

        $newFilePath = $this->wallpaperFilePathHelper->getNewFilePath($file->getFilename());

        // move the uploaded file
        // args: $tempPath, $newPath
        $this->fileMover->move(
            $file->getPathname(),
            $newFilePath
        );

        // update the Wallpaper entity with new info
        $this->imageFileDimensionsHelper->setImageFilePath($newFilePath);
        $entity
            ->setFilename(
                $file->getFilename()
            )
            ->setHeight(
                $this->imageFileDimensionsHelper->getHeight()
            )
            ->setWidth(
                $this->imageFileDimensionsHelper->getWidth()
            );

        if (!$entity->getTitle()) {
            $entity->setTitle(
                $fileTitle = ucwords(trim(preg_replace('/(_|-)+/', ' ', preg_replace('/(\.png|\.jpg|\.jpeg|\.gif)$/', ' ', $file->getFilename()))))
            );
        }

        return $entity;
    }
}
