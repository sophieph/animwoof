<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class AdminController
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_dashboard")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/animaux", name="admin_animals")
     */
    public function animals()
    {
        return $this->render('admin/animals.html.twig');
    }

    /**
     * @Route("/boutique", name="admin_shop")
     */
    public function shop()
    {
        return $this->render('admin/shop.html.twig');
    }

    /**
     * @Route("/dons", name="admin_donation")
     */
    public function donation()
    {
        return $this->render('admin/donation.html.twig');
    }

    /**
     * @Route("/blog", name="admin_animals")
     */
    public function blog()
    {
        return $this->render('admin/blog.html.twig');
    }
}
