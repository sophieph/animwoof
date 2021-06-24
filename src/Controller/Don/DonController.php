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
      $laastDon = $this->getDoctrine()->getRepository(Don::class)->fetchLastDon();
      
      if ($donateForm->isSubmitted() && $donateForm->isValid()) {
        
        $donateData = $donateForm->getData();
        $newDon->setUser($this->getUser());
        $newDon->setDateTransaction(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($donateData);
        $em->flush();
        return $this->redirectToRoute('comfirmDon', ['id' => $donateData->getId()]);
      }
      $userDons = new \stdClass();
      $idUser = null;
      if ($this->getUser() != null) {
        $idUser = $this->getUser()->getId();
        $userDons = $this->getDoctrine()->getRepository(Don::class)->fecthUserDonList($idUser);
        
      }
      return $this->render('don/index.html.twig', [
          'controller_name' => 'DonController',
          'lastDon' => $this->getDoctrine()->getRepository(Don::class)->fetchLastDon(),
          'userDons' => $userDons,
          'donnateForm' => $donateForm->createView(),
          'donsList' => $this->getDoctrine()->getRepository(Don::class)->fetchDonList()
      ]);
    }
    
    /** @Route("/{id}", name="single_don") */
    public function singleDon($id): Response
    {
      return $this->render('don/single.html.twig', [
          'controller_name' => 'DonController',
          'don' => $this->getDoctrine()->getRepository(Don::class)->find($id)
      ]);
    }
    
    /** @Route("/comfirm_don_message/{id}", name="comfirmDon") */
    public function comfirmDon($id): Response
    {
      return $this->render('don/comfirm_don_template.html.twig', [
          'controller_name' => 'DonController',
          'don' => $this->getDoctrine()->getRepository(Don::class)->find($id)
      ]);
    }
  }
