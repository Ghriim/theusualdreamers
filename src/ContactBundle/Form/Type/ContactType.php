<?php

namespace ContactBundle\Form\Type;

use ContactBundle\Form\Model\ContactModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType
 *
 * @package ContactBundle\Form\Type
 */
class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm (FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'senderName',
                TextType::class,
                ['label' => 'contact.form.field.senderName']
            )
            ->add(
                'senderEmail',
                EmailType::class,
                ['label' => 'contact.form.field.senderEmail']
            )
            ->add(
                'subject',
                TextType::class,
                ['label' => 'contact.form.field.subject']
            )
            ->add(
                'content',
                TextareaType::class,
                ['label' => 'contact.form.field.content']
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions (OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => ContactModel::class,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix ()
    {
        return 'contact';
    }
}