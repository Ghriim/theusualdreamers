<?php

namespace BlogBundle\Form\Type;

use BlogBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class PostType
 *
 * @package BlogBundle\Form\Type
 */
class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content')
            ->add(
                'publication',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy HH:mm:ss',
                ]
            )
            ->add('save', SubmitType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions (OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Post::class,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix ()
    {
        return 'post';
    }

}