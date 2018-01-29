<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

/**
 * Class LoadCategoryFixtures
 * @package App\DataFixtures\ORM
 */
class LoadCategoryFixtures extends AbstractFixture implements OrderedFixtureInterface
{
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
        echo 'Start loading category fixtures' . PHP_EOL;
        // --------------------------------------------------------

        $fixturesCategoryNames = $this->getCategoryNames();

        foreach ($fixturesCategoryNames as $catItem) {
            sleep(1);
            echo '.';
            $category = (new Category())->setName($catItem['title']);
            $this->addReference($catItem['ref_name'], $category);
            $manager->persist($category);
        }

        $manager->flush();

        // --------------- tear down ---------------------------
        echo PHP_EOL . 'Finished loading category fixtures' . PHP_EOL;
        // -----------------------------------------------------
    }

    /**
     * This is Description of getOrder
     *
     * @return int
     */
    public function getOrder()
    {
        return 100;
    }

    /**
     * Description:
     *
     * @return array
     *
     */
    private function getCategoryNames()
    {
        return [
            ['title' => 'Abstract Texture', 'ref_name' => 'category.abstract'],
            ['title' => 'Summer Nature', 'ref_name' => 'category.summer'],
            ['title' => 'Winter Landscape', 'ref_name' => 'category.winter']
        ];
    }
}