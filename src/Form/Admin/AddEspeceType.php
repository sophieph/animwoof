<?php

namespace App\Form\Admin;

use App\Entity\Espece;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddEspeceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom de l\'espèce',
                'label_attr' => ['class' => 'form-label h4 mb-2'],
                'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
            ])
            ->add('Creer', SubmitType::class, [
                'label' => 'Ajouter une espèce',
                'attr' => ['class' => ' btn text-dark border-0 px-5 rounded-0 bg-greenlight']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Espece::class,
        ]);
    }
}
