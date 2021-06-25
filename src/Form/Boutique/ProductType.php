<?php
  
  namespace App\Form\Boutique;
  
  use App\Entity\Categorie;
  use App\Entity\Products;
  use Symfony\Bridge\Doctrine\Form\Type\EntityType;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\FileType;
  use Symfony\Component\Form\Extension\Core\Type\IntegerType;
  use Symfony\Component\Form\Extension\Core\Type\NumberType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  use Symfony\Component\Validator\Constraints\File;
  
  class ProductType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('name', TextType::class, [
              'label' => 'Nom du produit',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2'],
          ])
          ->add('description', TextareaType::class, [
              'label' => 'Description du produit',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2']
          ])
          ->add('price', NumberType::class, [
              'label' => 'Prix du produit',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2'],
          ])
          ->add('quantity', IntegerType::class, [
              'label' => 'Quantité du stock',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2']
          ])
          ->add('categorie', EntityType::class, [
              'label' => 'Catégorie du produit',
              'attr' => ['class' => 'form-select border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'class' => Categorie::class,
              'choice_label' => 'name'
          ])
          ->add('image', FileType::class, [
              'label' => 'Image du produit',
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'formFile h4 mb-2'],
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
              'label' => 'Ajouter un nouvel article',
              'attr' => ['class' => ' btn text-dark border-0 rounded-0 bg-greenlight']
          ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => Products::class,
      ]);
    }
  }
