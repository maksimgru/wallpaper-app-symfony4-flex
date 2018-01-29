<?php

namespace spec\App\Entity;

use App\Entity\Wallpaper;
use App\Model\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class WallpaperSpec
 * @package spec\App\Entity
 */
class WallpaperSpec extends ObjectBehavior
{
    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(Wallpaper::class);
    }

    public function it_sets_the_updated_at_timestamp_when_setting_a_file(
        FileInterface $file
    )
    {
        $this->getUpdatedAt()->shouldBe(null);

        $this
            ->setFile($file)
            ->shouldReturnAnInstanceOf(Wallpaper::class)
        ;

        $this
            ->getUpdatedAt()
            ->shouldReturnAnInstanceOf(\DateTime::class)
        ;
    }
}
