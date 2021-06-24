<?php

namespace App\Services\Boutique;

use App\Entity\Commande;
use App\Entity\CommandeDetail;
use App\Entity\Panier;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class CommandeService
{

    private $em;
    private $panierService;
    private $session;
    private $security;


    public function __construct(Security $security, SessionInterface $session, EntityManagerInterface $em, PanierService $panierService){
        $this->session = $session;
        $this->em = $em;
        $this->panierService = $panierService;
        $this->security = $security;

    }

    public function createCommande()
    {
        $user = $this->security->getUser();
        $panier = $this->panierService->getFullCart();
        $total = $this->panierService->getTotal();

        $commande = new Commande();
        $commande->setUser($user);
        $commande->setPrixFinal($total);

        $this->em->persist($commande);

        foreach ($panier as $produit)
        {
            $commandeDetail = new CommandeDetail();
            $commandeDetail->setCommande($commande);
            $commandeDetail->setQuantite($produit['quantite']);
            $commandeDetail->setProduit($produit['produit']);
            $this->em->persist($commandeDetail);
            $this->em->flush();
            $this->changeQuantiteProduit($produit['produit'], $produit['quantite']);
        }

        $this->session->remove('panier');

        return $commande;
    }

    public function changeQuantiteProduit(Products $produit, int $quantite)
    {
        $quantiteFinale = $produit->getQuantity() - $quantite;
        $produit->setQuantity($quantiteFinale);
        $this->em->persist($produit);
        $this->em->flush();
    }
}