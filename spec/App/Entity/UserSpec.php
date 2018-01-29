<?php

namespace spec\App\Entity;

use App\Entity\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class UserSpec
 *
 * @package spec\App\Entity
 */
class UserSpec extends ObjectBehavior
{
    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }
}
