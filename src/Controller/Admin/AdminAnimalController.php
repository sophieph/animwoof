<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/animaux")
 * Class AdminAnimalController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class AdminAnimalController extends AbstractController
{

    /**
     * @Route("/", name="admin_animals")
     */
    public function animals()
    {
        return $this->render('admin/animal/animals.html.twig');
    }
}