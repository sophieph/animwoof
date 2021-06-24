<?php

namespace App\Controller\Boutique;

use App\Entity\Products;
use App\Services\Boutique\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/panier")
 * Class PanierController
 * @package App\Controller\Boutique
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier")
     * @param SessionInterface $session
     * @param PanierService $cartService
     * @return Response
     */
    public function index(SessionInterface $session, PanierService $cartService): Response
    {
        $panier = $cartService->getFullCart();

        $total = $cartService->getTotal();

        return $this->render('boutique/panier/index.html.twig', [
            'items' => $panier,
            'totalPrix' => $total
        ]);
    }

    /**
     * @Route("/add/{id}", name="panier_add")
     * @param Products $produit
     * @param PanierService $panierService
     * @return RedirectResponse
     */
    public function add(Products $produit, PanierService $panierService): RedirectResponse
    {
        $panierService->add($produit);

        $this->addFlash('success', 'Produit ajouté au panier');
        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/remove/{id}", name="panier_remove")
     * @param Products $produit
     * @param PanierService $panierService
     * @return RedirectResponse
     */
    public function remove(Products $produit, PanierService $panierService): RedirectResponse
    {
        $panierService->remove($produit);
        $this->addFlash('success', 'Produit supprimé du panier');
        return $this->redirectToRoute('panier');
    }

    /**
     * @Route("/remove_one/{id}", name="panier_remove_one")
     * @param Products $produit
     * @param PanierService $panierService
     * @return RedirectResponse
     */
    public function removeOne(Products $produit, PanierService $panierService): RedirectResponse
    {
        $panierService->removeOne($produit);
        $this->addFlash('success', 'Produit supprimé du panier');
        return $this->redirectToRoute('panier');
    }
}
