<?php

namespace Sibintek\ConsentPersData\Form;

use Sibintek\ConsentPersData\Entity\Feedback;
use Sibintek\ConsentPersData\Entity\EmailAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class FeedbackType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emailaddress',
                EntityType::class, [
                'class' => EmailAddress::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('e')
                        ->orderBy('e.name', 'ASC');
                },
                'mapped' => false,
//                'choice_label' => 'emailadrress',
                'label'  => 'feedback.email',
                'multiple' => true,
                'attr' => ['class' => 'input select2-multiple'],
            ])
            ->add('subject', null, [
                'required' => false,
                'label'  => 'feedback.subject',
                'attr' => ['class' => 'input'],
            ])
            ->add('body', CKEditorType::class, [
                'required' => false,
                'label'  => 'feedback.body',
                'attr' => ['class' => 'tinymce'],
            ])

            ->add('fileupload', FileType::class, [
                'label' => 'feedback.files',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
//                    new File([
//                        'maxSize' => '1024k',
//                        'mimeTypes' => [
//                            'application/pdf',
//                            'application/x-pdf',
//                        ],
//                        'mimeTypesMessage' => 'Please upload a valid PDF document',
//                    ])
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Feedback::class,
        ]);
    }
}
