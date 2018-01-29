<?php

namespace spec\App\Event\Listener;

use App\Entity\Category;
use App\Entity\Wallpaper;
use App\Service\FileDeleter;
use App\Service\FileMover;
use App\Event\Listener\WallpaperListener;
use App\Model\FileInterface;
use App\Service\ImageFileDimensionsHelper;
use App\Service\WallpaperFilePathHelper;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * Class WallpaperListenerSpec
 * @package spec\App\Event\Listener
 */
class WallpaperListenerSpec extends ObjectBehavior
{
    /**
     * @var FileMover
     */
    private $fileMover;

    /**
     * @var FileDeleter
     */
    private $fileDeleter;

    /**
     * @var WallpaperFilePathHelper $wallpaperFilePathHelper
     */
    private $wallpaperFilePathHelper;

    /**
     * @var ImageFileDimensionsHelper $imageFileDimensionsHelper
     */
    private $imageFileDimensionsHelper;

    /**
     * This is Description of let
     * this method will always be called before any of our PhpSpec tests are
     *
     * @param FileMover $fileMover
     * @param FileDeleter $fileDeleter
     * @param WallpaperFilePathHelper $wallpaperFilePathHelper
     * @param ImageFileDimensionsHelper $imageFileDimensionsHelper
     *
     * @return void
     */
    public function let(
        FileMover $fileMover,
        FileDeleter $fileDeleter,
        WallpaperFilePathHelper $wallpaperFilePathHelper,
        ImageFileDimensionsHelper $imageFileDimensionsHelper
    )
    {
        // PhpSpec will now check our implementation
        // for a __construct function with one argument
        $this->beConstructedWith(
            $fileMover,
            $fileDeleter,
            $wallpaperFilePathHelper,
            $imageFileDimensionsHelper
        );

        $this->fileMover = $fileMover;
        $this->fileDeleter = $fileDeleter;
        $this->wallpaperFilePathHelper = $wallpaperFilePathHelper;
        $this->imageFileDimensionsHelper = $imageFileDimensionsHelper;
    }

    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(WallpaperListener::class);
    }

    /**
     * This is Description of it_returns_early_if_prePersist_LifecycleEventArgs_entity_is_not_a_Wallpaper_instance
     *
     * @param LifecycleEventArgs $eventArgs
     *
     * @return void
     */
    public function it_returns_early_if_prePersist_LifecycleEventArgs_entity_is_not_a_Wallpaper_instance(
        LifecycleEventArgs $eventArgs
    )
    {
        $eventArgs->getEntity()->willReturn(new Category());
        $this->prePersist($eventArgs)->shouldReturn(false);
        $this->fileMover->move(
            Argument::any(),
            Argument::any()
        )->shouldNotHaveBeenCalled();
    }

    /**
     * This is Description of it_can_prePersist
     *
     * @param LifecycleEventArgs $eventArgs
     * @param FileInterface $file
     *
     * @return void
     */
    public function it_can_prePersist(
        LifecycleEventArgs $eventArgs,
        FileInterface $file
    )
    {
        // setup - not actually used in our tests just yet
        $fakeTempPath = '/tmp/some.file';
        $fakeFileName = 'some.file';

        $file->getPathname()->willReturn($fakeTempPath);
        $file->getFilename()->willReturn($fakeFileName);

        $wallpaper = new Wallpaper();
        $wallpaper->setFile($file->getWrappedObject());

        $eventArgs->getEntity()->willReturn($wallpaper);

        $fakeNewFilePath = '/some/new/fake/' . $fakeFileName;
        $this
            ->wallpaperFilePathHelper
            ->getNewFilePath($fakeFileName)
            ->willReturn($fakeNewFilePath);

        // mock image dimensions helper
        $this->imageFileDimensionsHelper->setImageFilePath($fakeNewFilePath)->shouldBeCalled();
        $this->imageFileDimensionsHelper->getWidth()->willReturn(1024);
        $this->imageFileDimensionsHelper->getHeight()->willReturn(768);

        // the method we are testing
        $outcome = $this->prePersist($eventArgs);

        // what we expect to have happened, if this test is passing
        $this->fileDeleter->delete(Argument::any())->shouldNotHaveBeenCalled();
        $this->fileMover->move($fakeTempPath, $fakeNewFilePath)->shouldHaveBeenCalled();

        $outcome->shouldBeAnInstanceOf(Wallpaper::class);
        $outcome->getFilename()->shouldReturn($fakeFileName);
        $outcome->getWidth()->shouldReturn(1024);
        $outcome->getHeight()->shouldReturn(768);
    }

    /**
     * This is Description of it_returns_early_if_preUpdate_LifecycleEventArgs_entity_is_not_a_Wallpaper_instance
     *
     * @param PreUpdateEventArgs $eventArgs
     *
     * @return void
     */
    public function it_returns_early_if_preUpdate_LifecycleEventArgs_entity_is_not_a_Wallpaper_instance(
        PreUpdateEventArgs $eventArgs
    )
    {
        $eventArgs->getEntity()->willReturn(new Category());
        $this->preUpdate($eventArgs)->shouldReturn(false);
        $this->fileMover->move(
            Argument::any(),
            Argument::any()
        )->shouldNotHaveBeenCalled();
    }

    /**
     * This is Description of it_can_preUpdate
     *
     * @param PreUpdateEventArgs $eventArgs
     * @param FileInterface $file
     *
     * @return void
     */
    public function it_can_preUpdate(
        PreUpdateEventArgs $eventArgs,
        FileInterface $file
    )
    {
        // setup - not actually used in our tests just yet
        $fakeTempPath = '/tmp/some.file';
        $fakeFileName = 'some.file';

        $file->getPathname()->willReturn($fakeTempPath);
        $file->getFilename()->willReturn($fakeFileName);

        $wallpaper = new Wallpaper();
        $wallpaper->setFile($file->getWrappedObject());
        $wallpaper->setFilename($fakeFileName);

        $eventArgs->getEntity()->willReturn($wallpaper);

        $fakeNewFilePath = '/some/new/fake/' . $fakeFileName;
        $this
            ->wallpaperFilePathHelper
            ->getNewFilePath($fakeFileName)
            ->willReturn($fakeNewFilePath);

        // mock image dimensions helper
        $this->imageFileDimensionsHelper->setImageFilePath($fakeNewFilePath)->shouldBeCalled();
        $this->imageFileDimensionsHelper->getWidth()->willReturn(1024);
        $this->imageFileDimensionsHelper->getHeight()->willReturn(768);

        // the method we are testing
        $outcome = $this->preUpdate($eventArgs);

        // what we expect to have happened, if this test is passing
        $this->fileDeleter->delete(Argument::any())->shouldHaveBeenCalled();
        $this->fileMover->move($fakeTempPath, $fakeNewFilePath)->shouldHaveBeenCalled();

        $outcome->shouldBeAnInstanceOf(Wallpaper::class);
        $outcome->getFilename()->shouldReturn($fakeFileName);
        $outcome->getWidth()->shouldReturn(1024);
        $outcome->getHeight()->shouldReturn(768);
    }

    /**
     * This is Description of it_can_preRemove
     *
     * @param LifecycleEventArgs $eventArgs
     * @param Wallpaper $wallpaper
     *
     * @return void
     */
    public function it_can_preRemove(LifecycleEventArgs $eventArgs, Wallpaper $wallpaper)
    {
        $wallpaper->setFile(null)->shouldBeCalled();

        $wallpaper->getFilename()->willReturn('fake-filename.jpg');
        $eventArgs->getEntity()->willReturn($wallpaper);

        $this->preRemove($eventArgs);

        $this->fileDeleter->delete('fake-filename.jpg')->shouldHaveBeenCalled();
    }

    /**
     * This is Description of it_will_not_continue_with_preRemove_if_not_a_Wallpaper_instance
     *
     * @param LifecycleEventArgs $eventArgs
     *
     * @return void
     */
    public function it_will_not_continue_with_preRemove_if_not_a_Wallpaper_instance(LifecycleEventArgs $eventArgs)
    {
        $eventArgs->getEntity()->willReturn(new Category());

        $this->preRemove($eventArgs)->shouldReturn(false);

        $this->fileDeleter->delete(
            Argument::any()
        )->shouldNotHaveBeenCalled();
    }
}
