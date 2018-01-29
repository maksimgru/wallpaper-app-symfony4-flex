<?php

namespace spec\App\Service;

use App\Service\ImageFileDimensionsHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class ImageFileDimensionsHelperSpec
 * @package spec\App\Service
 */
class ImageFileDimensionsHelperSpec extends ObjectBehavior
{
    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(ImageFileDimensionsHelper::class);
    }
}
