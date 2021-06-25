<?php

namespace App\Form\Admin;

use App\Entity\Animal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class AddAnimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'animal',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
            ])
            ->add('race', TextType::class, [
                'label' => 'Race de l\'animal',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Àge de l\'animal',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
            ])
            ->add('poids', IntegerType::class, [
                'label' => 'Poids de l\'animal',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
            ])
            ->add('dateDeNaissance', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance de l\'animal',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
            ])
            ->add('description',TextareaType::class, [
                'label' => 'Description de l\'animal',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
            ])
            ->add('espece', null, [
                    'label' => 'Espece de l\'animal',
                    'label_attr' => ['class' => 'form-label h4 mb-2'],
                    'attr' => ['class' => 'form-select border-0 rounded-0 border-bottom border-1']
            ])
            ->add('photo', FileType::class, [
                'label' => 'Image',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '3000M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
            ->add('ajouter', SubmitType::class, [
                'label' => 'Ajouter à l\'adoption',
                'attr' => ['class' => ' btn text-dark border-0 px-5 rounded-0 bg-greenlight']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Animal::class,
        ]);
    }
}
