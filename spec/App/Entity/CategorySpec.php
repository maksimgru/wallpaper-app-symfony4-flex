<?php

namespace spec\App\Entity;

use App\Entity\Category;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class CategorySpec
 * @package spec\App\Entity
 */
class CategorySpec extends ObjectBehavior
{
    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(Category::class);
    }
}
