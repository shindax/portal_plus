<?php

namespace Sibintek\ConsentPersData\Form;

use Sibintek\ConsentPersData\Entity\MessageEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class MessageEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject', null, [
                'required' => true,
                'label'  => 'messageemail.subject',
                'attr' => ['class' => 'input'],
            ])
            ->add('body', null, [
                'required' => true,
                'label'  => 'messageemail.body',
                'attr' => ['class' => 'input'],
            ])
            ->add('dateTimeReceived', DateTimeType::class, [
                'required' => false,
                'label'  => 'messageemail.datereceipt',
                'widget' => 'single_text',
            ])
            ->add('dateTimeSent', DateTimeType::class, [
                'required' => false,
                'label'  => 'messageemail.datesent',
                'widget' => 'single_text',
            ])
            ->add('isAttachment', CheckboxType::class, [
                'required' => false,
                'label'  => 'messageemail.isattachment',
                'attr' => ['class' => 'input'],
            ])
            ->add('sender')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MessageEmail::class,
        ]);
    }
}
