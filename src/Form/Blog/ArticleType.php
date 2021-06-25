<?php
  
  namespace App\Form\Blog;
  
  use App\Entity\Blog\Article;
  use Symfony\Component\Form\AbstractType;
  use Symfony\Component\Form\Extension\Core\Type\TextType;
  use Symfony\Component\Form\Extension\Core\Type\SubmitType;
  use Symfony\Component\Form\Extension\Core\Type\TextareaType;
  use Symfony\Component\Form\FormBuilderInterface;
  use Symfony\Component\OptionsResolver\OptionsResolver;
  
  class ArticleType extends AbstractType
  {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder
          ->add('titre', TextType::class, [
              'label' => 'Titre de l\'article',
              'label_attr' => ['class' => 'form-label h4 mb-2'],
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1']
          ])
          ->add('contenu', TextareaType::class, [
              'attr' => ['class' => 'form-control border-0 rounded-0 border-bottom border-1'],
              'label' => 'Contenu de l\'article',
              'label_attr' => ['class' => 'form-label h4 mb-2']
          ])
          ->add('categorie',null,[
              'label' => 'Categories de l\'article',
              'attr' => ['class' => 'form-select border-0 rounded-0 border-bottom border-1'],
              'label_attr' => ['class' => 'form-label h4 mb-2'],
          ])
          ->add('ajouter', SubmitType::class, [
              'label' => 'Sauvegarder',
              'attr' => ['class' => ' btn text-dark border-0 px-5 rounded-0 bg-greenlight']
          ]);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
      $resolver->setDefaults([
          'data_class' => Article::class,
      ]);
    }
  }
