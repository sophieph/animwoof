<?php
  
  namespace App\Controller\Don;
  
  use App\Entity\Don;
  use App\Entity\User;
  use App\Form\Don\DonType;
  use Doctrine\ORM\Mapping\Cache;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  
  /** @Route("/donation") */
  class DonController extends AbstractController
  {
    /** @Route("/", name="don") */
    public function index(Request $request): Response
    {
      $newDon = new Don();
      
      $donateForm = $this->createForm(DonType::class, $newDon);
      $donateForm->handleRequest($request);
      
      
      if ($donateForm->isSubmitted() && $donateForm->isValid()) {
        
        $donateData = $donateForm->getData();
        $newDon->setUser($this->getUser());
        $newDon->setDateTransaction(new \DateTime());
        dump($newDon);
  
        dd($donateData);
        
        
      }
      $userDons = new \stdClass();
//      dd($userDons);
      $idUser = null;
      if ($this->getUser() != null) {
        $idUser = $this->getUser()->getId();
        $userDons = $this->getDoctrine()->getRepository(Don::class)->fecthUserDonList($idUser);
        
        
//        dd($userDons);
  
      }
      
      return $this->render('don/index.html.twig', [
          'controller_name' => 'DonController',
          'lastDon' => $this->getDoctrine()->getRepository(Don::class)->fetchLastDon(),
          'userDons' => $userDons,
          'donnateForm' => $donateForm->createView()
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
