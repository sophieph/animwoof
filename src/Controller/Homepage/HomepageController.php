<?php

namespace App\Controller\Homepage;

use App\Entity\Animal;
use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function index(): Response
    {
        $animals = $this->getDoctrine()->getRepository(Animal::class)->getRandomAnimals();
        $produits = $this->getDoctrine()->getRepository(Products::class)->getRandomProducts();

        return $this->render('homepage/index.html.twig', [
            'produits' => $produits,
            'animals' => $animals
        ]);
    }
}
