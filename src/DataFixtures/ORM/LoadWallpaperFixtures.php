<?php

namespace App\DataFixtures\ORM;

use App\File\SymfonyUploadedFile;
use App\Entity\Wallpaper;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LoadWallpaperFixtures
 * @package App\DataFixtures\ORM
 */
class LoadWallpaperFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var string $wallpaperBaseDir
     */
    private $wallpaperBaseDir;

    /**
     * @param $wallpaperBaseDir
     */
    public function __construct($wallpaperBaseDir) {
        $this->wallpaperBaseDir= $wallpaperBaseDir;
    }

    /**
     * This is Description of load
     *
     * @param ObjectManager $manager
     *
     * @return void
     */
    public function load(ObjectManager $manager)
    {
        // -------------- setup -----------------------------------
        exec('mkdir -p ' . $this->wallpaperBaseDir);
        $imagesPath = __DIR__ . '/../images';
        $temporaryImagesPath = sys_get_temp_dir() . '/images';
        echo 'Copying images to temporary location' . PHP_EOL;
        exec('cp -R ' . $imagesPath . ' ' . $temporaryImagesPath);
        // --------------------------------------------------------

        $fixturesImagesNames = $this->getImagesNames();

        foreach($fixturesImagesNames as $catRefName => $fileNames) {
            foreach($fileNames as $fileName) {
                sleep(1);
                echo '.';
                $fileTitle=  ucwords(trim(preg_replace('/(_|-)+/', ' ', preg_replace('/(\.png|\.jpg|\.jpeg|\.gif)$/', ' ', $fileName))));
                $fileMeta = getimagesize($temporaryImagesPath . '/' . $fileName);
                $fileWidth = (int)$fileMeta[0];
                $fileHeight = (int)$fileMeta[1];
                $wallpaper = (new Wallpaper())
                    ->setFile(
                        (new SymfonyUploadedFile())
                        ->setFile(
                            new UploadedFile($temporaryImagesPath . '/' . $fileName, $fileName)
                        )
                    )
                    ->setFilename($fileName)
                    ->setTitle($fileTitle)
                    ->setWidth($fileWidth)
                    ->setHeight($fileHeight)
                    ->setCategory(
                        $this->getReference($catRefName)
                    )
                ;
                $manager->persist($wallpaper);
            }
        }

        $manager->flush();

        // --------------- tear down ---------------------------
        echo PHP_EOL . 'Removed images from temporary location' . PHP_EOL;
        exec('rm -rf ' . $temporaryImagesPath);
        // -----------------------------------------------------
    }

    /**
     * This is Description of getOrder
     *
     * @return int
     */
    public function getOrder ()
    {
        return 200;
    }

    /**
     * Description:
     *
     * @return array
     *
     */
    private function getImagesNames()
    {
        return [
            'category.abstract' => [
                'abstract-background-pink.jpg',
                'abstract-black-and-white-wave.jpg',
                'abstract-black-multi-color-wave.jpg',
                'abstract-blue-green.jpg',
                'abstract-blue-line-background.jpg',
                'abstract-red-background-pattern.jpg',
                'abstract-shards.jpeg',
                'abstract-swirls.jpeg',
            ],
            'category.summer' => [
                'landscape-summer-beach.jpg',
                'landscape-summer-field.jpg',
                'landscape-summer-flowers.jpg',
                'landscape-summer-hill.jpg',
                'landscape-summer-mountain.png',
                'landscape-summer-sea.jpg',
                'landscape-summer-sky.jpg',
            ],
            'category.winter' => [
                'landscape-winter-canada-lake.jpg',
                'landscape-winter-high-tatras.jpg',
                'landscape-winter-snowboard-jump.jpg',
                'landscape-winter-snow-lake.jpg',
                'landscape-winter-snow-mountain.jpeg',
                'landscape-winter-snow-trees.jpg',
                'landscape-winter-snowy-fisheye.png',
            ]
        ];
    }
}