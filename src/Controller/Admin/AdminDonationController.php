<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/donation")
 * Class AdminDonationController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class AdminDonationController extends AbstractController
{


    /**
     * @Route("/", name="admin_donation")
     */
    public function donation()
    {
        return $this->render('admin/donation/donation.html.twig');
    }
}