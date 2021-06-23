<?php

namespace App\Controller\Boutique;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/boutique")
 */
class BoutiqueController extends AbstractController
{

    /**
     * @Route("/", name="boutique")
     */
    public function index(SessionInterface $session): Response
    {
//        $session->remove('panier');

        $produits = $this->getDoctrine()->getRepository(Products::class)->findAll();

        return $this->render('boutique/index.html.twig', [
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/produit/{id}", name="boutique_produit_description")
     * @param Products $produit
     */
    public function produit(Products $produit)
    {
        return $this->render('boutique/produit-description.html.twig', [
            'produit' => $produit
        ]);
    }
    
}
