<?php
  
  namespace App\Form\Blog;
  
  use App\Entity\Blog\Categorie;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  
  class CategorieType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('nom', TextType::class, [
              'label' => 'Nom de la catégorie',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
          ])
          ->add('ajouter', SubmitType::class, [
              'label' => 'Ajouter une nouvelle catégorie',
              'attr' => ['class' => 'btn bg-greenlight border-0 px-5 text-dark rounded-0'],
          ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => Categorie::class,
      ]);
    }
  }
