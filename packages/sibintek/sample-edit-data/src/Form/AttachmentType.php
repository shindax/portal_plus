<?php

namespace Sibintek\ConsentPersData\Form;

use Sibintek\ConsentPersData\Entity\Attachment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AttachmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fileName')
            ->add('drive')
            ->add('path')
            ->add('originName')
            ->add('messageEmail')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Attachment::class,
        ]);
    }
}
