<?php

namespace BlogBundle\Form\Type;

use BlogBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
            ->add('englishTitle')
            ->add('frenchTitle')
            ->add('englishAbstract', TextareaType::class, ['required' => false])
            ->add('frenchAbstract', TextareaType::class)
            ->add('englishContent')
            ->add('frenchContent')
            ->add('cover')
            ->add(
                'category',
                ChoiceType::class,
                [
                    'choices' => ['travel' => 'travel', 'running' => 'running', 'vanlife' => 'vanlife']
                ]
            )
            ->add(
                'publication',
                DateType::class,
                [
                    'widget'   => 'single_text',
                    'required' => false
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'choices' => [
                        Post::STATUS_BACK_LOG  => Post::STATUS_BACK_LOG,
                        Post::STATUS_DRAFT     => Post::STATUS_DRAFT,
                        Post::STATUS_PUBLISHED => Post::STATUS_PUBLISHED,
                    ]
                ]
            );
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