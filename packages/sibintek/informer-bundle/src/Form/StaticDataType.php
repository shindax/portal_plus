<?php

namespace Sibintek\InformerBundle\Form;

use Sibintek\InformerBundle\Entity\StaticData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frequency')
            ->add('updated')
            ->add('value')
            ->add('success')
            ->add('lastValue')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StaticData::class,
        ]);
    }
}
