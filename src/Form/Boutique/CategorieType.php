<?php
  
  namespace App\Form\Boutique;
  
  use App\Entity\Categorie;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\FileType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  use Symfony\Component\Validator\Constraints\File;
  
  class CategorieType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('name', TextType::class, [
              'label' => 'Nom du la catégorie',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2']])
          ->add('photo', FileType::class, [
              'label' => 'Image de la catégorie',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'formFile h4 mb-2'],
              'mapped' => false,
              'required' => true,
              'constraints' => [
                  new File([
                      'maxSize' => '2000M',
                      'mimeTypes' => [
                          'image/jpeg',
                          'image/png',
                          'image/jpg',
                      ],
                      'mimeTypesMessage' => 'Please upload a valid Image document',
                  ])
              ],
          ])
          ->add('ajouter', SubmitType::class,[
              'label' => 'Ajouter une nouvelle catégorie',
              'attr' => ['class' => ' btn text-dark border-0 rounded-0 bg-greenlight']
          ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => Categorie::class,
      ]);
    }
  }
