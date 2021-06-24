<?php
  
  namespace App\Controller\Homepage;
  
  use App\Entity\Animal;
  use App\Entity\Don;
  use App\Entity\Products;
  use App\Form\Don\DonType;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  
  class HomepageController extends AbstractController
  {
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(Request $request): Response
    {
      $animals = $this->getDoctrine()->getRepository(Animal::class)->getRandomAnimals();
      $produits = $this->getDoctrine()->getRepository(Products::class)->getRandomProducts();

//        dons formulaire
      $newDon = new Don();
      
      $donateForm = $this->createForm(DonType::class, $newDon);
      $donateForm->handleRequest($request);
      if ($donateForm->isSubmitted() && $donateForm->isValid()) {
    
        $donateData = $donateForm->getData();
        $newDon->setUser($this->getUser());
        $newDon->setDateTransaction(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($donateData);
        $em->flush();
        return $this->redirectToRoute('comfirmDon', ['id' => $donateData->getId()]);
      }
      
      return $this->render('homepage/index.html.twig', [
          'produits' => $produits,
          'animals' => $animals,
          'donateForm' => $donateForm->createView()
      ]);
    }
  }
