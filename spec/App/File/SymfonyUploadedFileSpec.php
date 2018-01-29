<?php

namespace spec\App\File;

use App\File\SymfonyUploadedFile;
use App\Model\FileInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class SymfonyUploadedFileSpec
 * @package spec\App\File
 */
class SymfonyUploadedFileSpec extends ObjectBehavior
{
    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(SymfonyUploadedFile::class);
        $this->shouldImplement(FileInterface::class);
    }
}
