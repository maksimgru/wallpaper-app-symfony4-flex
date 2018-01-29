<?php

namespace spec\App\Service;

use App\Service\LocalFilesystemFileMover;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Class FileMoverSpec
 * @package spec\App\Service
 */
class LocalFilesystemFileMoverSpec extends ObjectBehavior
{

    /**
     * @var Filesystem $filesystem
     */
    private $filesystem;

    /**
     * This is Description of let
     *
     * @param Filesystem $filesystem
     *
     * @return void
     */
    public function let(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        $this
            ->beConstructedWith($filesystem)
        ;
    }

    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(LocalFilesystemFileMover::class);
    }

    /**
     * Description:
     *
     * @return void
     */
    public function it_can_move_a_file_from_temporary_to_controlled_storage()
    {
        $currentLocation = '/some/fake/tmp/path';
        $newLocation = '/some/fake/real/path';

        $this->move($currentLocation, $newLocation)->shouldReturn(true);

        $this->filesystem->rename($currentLocation, $newLocation, true)->shouldHaveBeenCalled();
    }
}
