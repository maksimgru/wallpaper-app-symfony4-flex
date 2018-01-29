<?php

namespace spec\App\Service;

use App\Service\WallpaperFilePathHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class WallpaperFilePathHelperSpec
 * @package spec\App\Service
 */
class WallpaperFilePathHelperSpec extends ObjectBehavior
{
    /**
     * This is Description of let
     *
     * @param
     *
     * @return void
     */
    public function let()
    {
        $this->beConstructedWith('/new/path/to/');
    }

    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(WallpaperFilePathHelper::class);
    }

    /**
     * This is Description of it_can_get_a_new_file_path_when_given_a_filename
     *
     * @return void
     */
    public function it_can_get_a_new_file_path_when_given_a_filename()
    {
        $this
            ->getNewFilePath('some/file.name')
            ->shouldReturn('/new/path/to/some/file.name')
        ;
    }

    /**
     * This is Description of it_gracefully_handles_no_trailing_slash_in_the_constructor_arg
     *
     * @return void
     */
    public function it_gracefully_handles_no_trailing_slash_in_the_constructor_arg()
    {
        $this
            ->beConstructedWith('/whoops/no/trailing/slash')
        ;

        $this
            ->getNewFilePath('some/file.name')
            ->shouldReturn('/whoops/no/trailing/slash/some/file.name')
        ;
    }

    /**
     * This is Description of it_removes_leading_slash_in_new_file_path_arg
     *
     * @return void
     */
    public function it_removes_leading_slash_in_new_file_path_arg()
    {
        $this
            ->getNewFilePath('/another/file.name')
            ->shouldReturn('/new/path/to/another/file.name')
        ;
    }

    /**
     * This is Description of it_throws_if_not_constructed_properly
     *
     * @return void
     */
    public function it_throws_if_not_constructed_properly()
    {
        // reset the constructor arguments
        $this->beConstructedWith();

        $this
            ->shouldThrow()
            ->duringInstantiation()
        ;
    }
}
