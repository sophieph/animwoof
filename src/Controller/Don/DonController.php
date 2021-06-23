<?php
  
  namespace App\Controller\Don;
  
  use App\Entity\Don;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  
  /** @Route("/donnations") */
  class DonController extends AbstractController
  {
    /** @Route("/", name="don") */
    public function index(): Response
    {
      $lastDon = $this->getDoctrine()->getRepository(Don::class)->fetchLastDon();
      return $this->render('don/index.html.twig', [
          'controller_name' => 'DonController',
          'lastDon' => $lastDon
      ]);
    }
  
    /** @Route("/list", name="all_dons") */
    public function dons(): Response
    {
      $donList = $this->getDoctrine()->getRepository(Don::class)->fetchDonList();
      dd($donList);
//      return $this->render('don/index.html.twig', [
//          'controller_name' => 'DonController',
//          'lastDon' => $lastDon
//      ]);
    }
  
    /** @Route("/{id}", name="single_don") */
    public function singleDon($id): Response
    {
      return $this->render('don/single.html.twig', [
          'controller_name' => 'DonController',
          'don' => $this->getDoctrine()->getRepository(Don::class)->find($id)
      ]);
    }
  }
