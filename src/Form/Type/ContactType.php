<?php

namespace App\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * This is Description of ContactFormType class
 *
 */
class ContactType extends AbstractType
{
    /**
     * Description:
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     *
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', EmailType::class, [
                'label' => 'Your Email',
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Your Message',
                'attr' => [
                    'placeholder' => 'Message',
                    'rows' => 10
                ]
            ])
            ->add('send', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-lg btn-primary'
                ]
            ]);
    }
}