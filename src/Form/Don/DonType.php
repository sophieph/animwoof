<?php
  
  namespace App\Form\Don;
  
  use App\Entity\Don;
  use Symfony\Component\Form\AbstractType;

  use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
  use Symfony\Component\Form\Extension\Core\Type\NumberType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  
  class DonType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('montant', NumberType::class, [
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label' => 'Montant du don :',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'help' => 'Minimum 1,00 €',
            'help_attr' => ['class' => 'fw-lighter fs-6 text']
          ])
          ->add('message', TextareaType::class, [
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label' => 'Message :',
              'required' => false,
              'label_attr' => ['class' => 'form-label h4 mb-2']])
          ->add('isAnonymous', CheckboxType::class, [
              'required' => false,
              'label' => 'Rester anonyme :',
              'label_attr' => ['class' => 'form-label h4']
          ])
          ->add('Donner', SubmitType::class, [
              'attr' => ['class' => 'btn bg-greenlight border-0 px-5 text-dark rounded-0']
          ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => Don::class,
      ]);
    }
  }
