<?php
  
  namespace App\Controller\User;
  
  use App\Entity\Commande;
  use App\Entity\Don;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;
  
  /**
   * @Route("/profil")
   * Class UserController
   * @package App\Controller\User
   * @IsGranted("ROLE_USER")
   */
  class UserController extends AbstractController
  {
    /**
     * @Route("/", name="profil")
     * @return Response
     */
    public function index(): Response
    {
      $user = $this->getUser();
      
      $commandes = $this->getDoctrine()->getRepository(Commande::class)->findBy(['user' => $user->getId()]);
      
      $dons = $this->getDoctrine()->getRepository(Don::class)->fecthUserDonList($user->getId());
//      dd($dons);
      return $this->render('user/index.html.twig', [
          'commandes' => $commandes,
          'dons' => $dons
      ]);
    }
  }
