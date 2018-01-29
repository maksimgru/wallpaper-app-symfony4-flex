<?php

namespace spec\App\Form\Type;

use App\Entity\Category;
use App\Entity\Wallpaper;
use App\File\SymfonyUploadedFile;
use App\Form\Type\UploadedFileType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;
use Symfony\Component\OptionsResolver\Exception\AccessException;

/**
 * Class UploadedFileTypeSpec
 * @package spec\App\Form\Type
 */
class UploadedFileTypeSpec extends ObjectBehavior
{
    /**
     * This is Description of it_is_initializable
     *
     * @return void
     */
    public function it_is_initializable()
    {
        $this->shouldHaveType(UploadedFileType::class);
    }

    /**
     * This is Description of it_can_build_a_form
     *
     * @param FormBuilderInterface $formBuilder
     *
     * @return void
     */
    public function it_can_build_a_form(FormBuilderInterface $formBuilder)
    {
        $this->buildForm($formBuilder, []);

        $formBuilder->add('file', FileType::class, [
            'multiple' => false,
        ])->shouldHaveBeenCalled();
    }

    /**
     * This is Description of it_can_build_a_view
     *
     * @param FormInterface $parent
     * @param FormInterface $form
     *
     * @return void
     */
    public function it_can_build_a_view(FormInterface $parent, FormInterface $form)
    {
        $form->getParent()->willReturn($parent);

        $view = new FormView();

        $view->vars['full_name'] = 'qwerty';

        $this->buildView($view, $form, []);

        Assert::same(
            $view->vars['full_name'],
            'qwerty'
        );
    }

    /**
     * This is Description of it_can_build_a_view_happy_path
     *
     * @param FormInterface $parent,
     * @param FormInterface $form,
     * @param Wallpaper $wallpaper
     *
     * @return void
     */
    public function it_can_build_a_view_happy_path(
        FormInterface $parent,
        FormInterface $form,
        Wallpaper $wallpaper
    ) {
        $wallpaper->getFilename()->willReturn('fake-file.jpg');
        $parent->getData()->willReturn($wallpaper);
        $form->getParent()->willReturn($parent);

        $view = new FormView();

        $view->vars['full_name'] = 'qwerty';
        $view->vars['file_uri'] = null;

        $this->buildView($view, $form, []);

        Assert::same(
            $view->vars['full_name'],
            'qwerty'
        );

        Assert::same(
            $view->vars['file_uri'],
            '/images/fake-file.jpg'
        );
    }

    /**
     * This is Description of it_will_not_set_a_file_uri_view_var_if_parent_form_data_is_not_a_wallpaper
     *
     * @param FormInterface $parent
     * @param FormInterface $form
     * @param Category $category
     *
     * @return void
     */
    public function it_will_not_set_a_file_uri_view_var_if_parent_form_data_is_not_a_wallpaper(
        FormInterface $parent,
        FormInterface $form,
        Category $category
    ) {
        $parent->getData()->willReturn($category);
        $form->getParent()->willReturn($parent);

        $view = new FormView();

        $view->vars['full_name'] = 'bob';

        $this->buildView($view, $form, []);

        Assert::same(
            $view->vars['full_name'],
            'bob'
        );

        Assert::false(
            array_key_exists('file_uri', $view->vars)
        );
    }

    /**
     * This is Description of it_will_set_a_file_uri_view_var_of_null_if_wallpaper_has_no_filename
     *
     * @param FormInterface $parent
     * @param FormInterface $form
     * @param Wallpaper $wallpaper
     *
     * @return void
     */
    public function it_will_set_a_file_uri_view_var_of_null_if_wallpaper_has_no_filename(
        FormInterface $parent,
        FormInterface $form,
        Wallpaper $wallpaper
    ) {
        $wallpaper->getFilename()->willReturn(null);
        $parent->getData()->willReturn($wallpaper);
        $form->getParent()->willReturn($parent);

        $view = new FormView();

        $view->vars['full_name'] = 'qwerty';

        $this->buildView($view, $form, []);

        Assert::same(
            $view->vars['full_name'],
            'qwerty'
        );

        Assert::null($view->vars['file_uri']);
    }

    /**
     * This is Description of it_correctly_configures_the_expected_options
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     * @throws AccessException
     */
    public function it_correctly_configures_the_expected_options(OptionsResolver $resolver)
    {
        $this->configureOptions($resolver);

        $resolver
            ->setDefaults([
                'data_class' => SymfonyUploadedFile::class,
                'file_uri' => null,
            ])
            ->shouldHaveBeenCalled()
        ;
    }
}
