<?php

namespace BlogBundle\Form\Type;

use BlogBundle\Entity\Comment;
use BlogBundle\Repository\CommentRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CommentType
 *
 * @package BlogBundle\Form\Type
 */
class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, ['label' => 'blog.comment.form.content'])
            ->add('authorName', TextType::class, ['label' => 'blog.comment.form.authorName'])
            ->add('authorEmail', EmailType::class, ['label' => 'blog.comment.form.authorEmail'])
            ->add('authorWebsite', UrlType::class, ['label' => 'blog.comment.form.authorWebsite'])
            ->add('notifyOnReply', CheckboxType::class, ['label' => 'blog.comment.form.notify'])
            ->add(
                'parent',
                EntityType::class,
                [
                    'class' => Comment::class,
                    'query_builder' => function (CommentRepository $repository) {
                        return $repository->getManyByCriteriaQueryBuilder();
                    },
                    'choice_label' => 'id',
                    'required' => false
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
                'data_class' => Comment::class,
                'translation_domain' => 'messages'
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix ()
    {
        return 'comment';
    }

}