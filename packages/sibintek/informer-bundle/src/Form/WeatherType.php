<?php

namespace Sibintek\InformerBundle\Form;

use Sibintek\InformerBundle\Entity\Weather;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WeatherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('temperature')
            ->add('name')
            ->add('pressure')
            ->add('humidity')
            ->add('type')
            ->add('winddirection')
            ->add('windpower')
            ->add('source')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Weather::class,
        ]);
    }
}
