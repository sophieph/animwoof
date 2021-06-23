<?php
  
  namespace App\Controller\Admin;
  
  use App\Entity\Don;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  
  /**
   * @Route("/admin/donation")
   * Class AdminDonationController
   * @package App\Controller\Admin
   * @IsGranted("ROLE_ADMIN")
   */
  class AdminDonationController extends AbstractController
  {
    
    
    /** @Route("/", name="admin_donation") */
    public function donation(): Response
    {
      return $this->render('admin/donation/donation.html.twig', [
          'donList' => $this->getDoctrine()->getRepository(Don::class)->fetchDonList()
      ]);
    }
    
    /** @Route("/{id}", name="admin_single_don")   */
    public function don($id): Response
    {
//      dd($this->getDoctrine()->getRepository(Don::class)->find($id));
      return $this->render('admin/donation/single.html.twig', [
          'don' => $this->getDoctrine()->getRepository(Don::class)->find($id)
      ]);
    }
  }
