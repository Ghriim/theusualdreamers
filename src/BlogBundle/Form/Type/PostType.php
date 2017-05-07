<?php

namespace BlogBundle\Form\Type;

use BlogBundle\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
            ->add(
                'coverFile',
                FileType::class,
                [
                    'mapped'   => false,
                    'required' => false
                ]
            )
            ->add('content')
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
                        Post::STATUS_ACTIVE  => Post::STATUS_ACTIVE,
                        Post::STATUS_PENDING => Post::STATUS_PENDING
                    ]
                ]
            )
            ->add('save', SubmitType::class);


        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
            /** @var Post $post */
            $post      = $event->getData();
            $coverFile = $event->getForm()->get('coverFile')->getData();
            if ($coverFile) {
                $post->setCover(base64_encode(file_get_contents($coverFile)));
            }
        });


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