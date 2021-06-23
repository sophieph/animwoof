<?php

namespace App\Controller\Boutique;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commande")
 * Class CommandeController
 * @package App\Controller\Boutique
 * @IsGranted("ROLE_USER")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande")
     * @return Response
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('boutique/commande/index.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
