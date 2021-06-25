<?php
  
  namespace App\Form;
  
  use App\Entity\User;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\EmailType;
  use Symfony\Component\Form\Extension\Core\Type\PasswordType;
  use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  use Symfony\Component\Validator\Constraints\Length;
  use Symfony\Component\Validator\Constraints\NotBlank;
  
  class SignUpType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('pseudo', TextType::class, [
              'label' => 'Nom d\'utilisateur',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2'],
          ])
          ->add('email', EmailType::class, [
              'label' => 'Adresse e-mail',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
          ])
          ->add('password', RepeatedType::class, [
              
              'type' => PasswordType::class,
              'mapped' => false,
              'constraints' => [
                  new NotBlank([
                      'message' => 'Entrer un mot de passe',
                  ]),
                  new Length([
                      'min' => 6,
                      'minMessage' => 'Votre mot de passe doit avoir au moins {{ limit }} caractères',
                      'max' => 4096,
                  ]),
              ],
              'first_options' => [
                  'label' => 'Votre mot de passe',
                  'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
                  'label_attr' => ['class' => 'form-label h4 mb-2']
              ],
              'second_options' => [
                  'label' => 'Veuillez confirmez votre mot de passe',
                  'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
                  'label_attr' => ['class' => 'form-label h4 mb-2']]
          ])
          ->add('save', SubmitType::class, [
              'label' => "S'inscrire",
              'attr' => ['class' => 'btn bg-greenlight border-0 px-5 text-dark rounded-0']
          ]);
      }
    
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => User::class,
      ]);
    }
  }
