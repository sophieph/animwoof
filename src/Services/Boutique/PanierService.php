<?php

namespace App\Services\Boutique;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Security;

class PanierService
{

    private $em;
    private $session;
    private $security;
    private $productsRepository;

    public function __construct(Security $security, ProductsRepository $productsRepository, SessionInterface $session, EntityManagerInterface $em) {
        $this->em = $em;
        $this->productsRepository = $productsRepository;
        $this->session = $session;
        $this->security = $security;
    }

    public function add(Products $produit){
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$produit->getId()])) {
            $panier[$produit->getId()]++;
        } else {
            $panier[$produit->getId()] = 1;
        }

        $this->session->set('panier', $panier);
    }

    public function removeOne(Products $produit)
    {
        $panier = $this->session->get('panier', []);


        if ($panier[$produit->getId()] === 1) {
            unset($panier[$produit->getId()]);
            $this->session->getFlashBag()->add('notice', 'remove');
        } else if (!empty($panier[$produit->getId()])) {
            $panier[$produit->getId()]--;
            $this->session->getFlashBag()->add('notice', 'removeOne');

        }
        $this->session->set('panier', $panier);
    }

    public function remove(Products $produit)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$produit->getId()])) {
            unset($panier[$produit->getId()]);
        }

        $this->session->set('panier', $panier);
    }

    public function getFullCart(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'produit' => $this->productsRepository->find($id),
                'quantite' => $quantity
            ];
        }
        return $panierWithData;
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getFullCart() as $item) {
            if (empty($item['produit']->getPrice())) {
                $total += $item['produit']->getPrice() * $item['quantite'];
            } else {
                $total += $item['produit']->getPrice() * $item['quantite'];
            }
        }

        return round($total,2);
    }

}