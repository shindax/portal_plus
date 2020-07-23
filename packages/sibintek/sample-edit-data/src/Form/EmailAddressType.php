<?php

namespace Sibintek\ConsentPersData\Form;

use Sibintek\ConsentPersData\Entity\EmailAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class EmailAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', null, [
                'required' => true,
                'label'  => ' ',
                'disabled' => true,
                'attr' => ['class' => 'input'],
            ])
            ->add('isspam', null, ['label'  => 'emailaddress.spam'])
            ->add('isnoreply', null, ['label'  => 'emailaddress.noreply'])
            ->add('dateregistration', DateType::class, [
                'required' => false,
                'label'  => 'emailaddress.datecreate',
                'widget' => 'single_text',
                'disabled' => true,
            ])
            ->add('candidate', null, ['label'  => 'candidate.title',
                'attr' => ['class' => 'select2-single input']
            ])
//            ->add('candidate_name', null, [
//                'label'  => 'candidate.title',
//                'mapped' => false,
//            ])
//            ->add('candidate_id', HiddenType::class, ['mapped' => false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmailAddress::class,
        ]);
    }
}
