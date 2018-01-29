<?php

namespace App\Form\Type;

use App\Entity\Wallpaper;
use App\File\SymfonyUploadedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UploadedFileType
 * @package App\Form\Type
 */
class UploadedFileType extends AbstractType
{
    /**
     * This is Description of buildForm
     *
     * @inheritdoc
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'multiple' => false,
            ])
        ;
    }

    /**
     * This is Description of buildView
     *
     * @inheritdoc
     */
    public function buildView (FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);

        /**
         * @var Wallpaper $entity
         */
        $entity = $form->getParent()->getData();

        if ($entity instanceof Wallpaper) {
            $view->vars['file_uri'] = ($entity->getFilename() === null)
                ? null
                : '/images/' . $entity->getFilename()
            ;
        }

        //$view->vars['full_name'] = $view->vars['full_name'] . '[file]';
    }

    /**
     * This is Description of configureOptions
     *
     * @inheritdoc
     *
     */
    public function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'data_class' => SymfonyUploadedFile::class,
            'file_uri' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'uploaded_file';
    }
}