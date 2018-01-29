<?php

namespace spec\App\Service;

use App\Service\FileDeleter;
use App\Service\LocalFilesystemFileDeleter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class LocalFilesystemFileDeleterSpec
 * @package spec\App\Service
 */
class LocalFilesystemFileDeleterSpec extends ObjectBehavior
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
        $this->beConstructedWith($filesystem, '/expected/base/path');
    }

    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(LocalFilesystemFileDeleter::class);
        $this->shouldImplement(FileDeleter::class);
    }

    /**
     * This is Description of it_can_delete
     *
     * @param
     *
     * @return void
     */
    public function it_can_delete()
    {
        $this->delete('to/some-file.jpg');

        $this
            ->filesystem
            ->remove('/expected/base/path/to/some-file.jpg')
            ->shouldHaveBeenCalled()
        ;
    }

}
