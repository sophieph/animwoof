<?php
  
  namespace App\Controller\Don;
  
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  
  class DonController extends AbstractController
  {
    /** @Route("/donnations", name="don") */
    public function index(): Response
    {
      return $this->render('don/index.html.twig', [
          'controller_name' => 'DonController',
      ]);
    }
  }
