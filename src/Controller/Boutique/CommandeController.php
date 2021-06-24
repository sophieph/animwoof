<?php

namespace App\Controller\Boutique;

use App\Entity\Commande;
use App\Services\Boutique\CommandeService;
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
     * @param CommandeService $commandeService
     * @return Response
     */
    public function index(CommandeService $commandeService): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $commande = $commandeService->createCommande();

        return $this->redirectToRoute('commande_detail', ['id' => $commande->getId()]);
    }

    /**
     * @Route("/{id}", name="commande_detail")
     * @param Commande $commande
     * @return Response
     */
    public function detail(Commande $commande){

        return $this->render('boutique/commande/index.html.twig', [
            'commande' => $commande
        ]);
    }
}
