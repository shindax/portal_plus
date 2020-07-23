<?php

namespace Sibintek\ConsentPersData\Form;

use Sibintek\ConsentPersData\Entity\Candidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sibintek\ConsentPersData\Entity\EmailAddress;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', null, [
                'required' => true,
                'label'  => 'candidate.lastname',
                'attr' => ['class' => 'input text-line'],
                ])
            ->add('firstName', null, [
                'required' => true,
                'label'  => 'candidate.name',
                'attr' => ['class' => 'input text-line'],
                ])
            ->add('patronymic', null, [
                'required' => false,
                'label'  => 'candidate.patronymic',
                'attr' => ['class' => 'input text-line'],
                ])
            ->add('birthday', DateType::class, [
                'required' => false,
                'label'  => 'candidate.birthday',
                'widget' => 'single_text',
                'attr' => ['class' => 'date-line-2 cal2'],
                ])
//            ->add('emailadrress', null, [
//                'label'  => 'emailadrress.title',
//                'mapped' => false,
//                'attr' => ['class' => 'input'],
//            ])
            ->add('emailaddress', EntityType::class, [
                'class' => EmailAddress::class,
                'required' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
//                'mapped' => false,
//                'choice_label' => 'emailadrress',
                'label'  => 'emailaddress.title',
                'multiple' => true,
                'attr' => ['class' => 'input select2-multiple'],
            ])
            ->add('isconsent', CheckboxType::class, [
                'required' => false,
                'label'  => 'candidate.isconsent',
                'attr' => ['class' => 'input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
