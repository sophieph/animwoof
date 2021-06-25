<?php
  
  namespace App\Form\Adoption;
  
  use App\Entity\Animal;
  use App\Entity\Reservation;
  use Symfony\Bridge\Doctrine\Form\Type\EntityType;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  
  class ReservationType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('prenom', TextType::class, [
              'label' => 'Prénom',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
          ])
          ->add('nom', TextType::class, [
              'label' => 'Nom de famille',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
          ])
          ->add('zipcode', TextType::class, [
              'label' => 'Code Postale',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
          ])
          ->add('phoneNumber', TextType::class, [
              'label' => 'Numéro de téléphone',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
          ])
          ->add('Reserver', SubmitType::class, [
              'attr' => ['class' => 'btn bg-greenlight border-0 px-5 text-dark rounded-0']
          ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => Reservation::class,
      ]);
    }
  }
