<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/blog")
 * Class AdminBlogController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class AdminBlogController extends AbstractController
{
    /**
     * @Route("/", name="admin_blog")
     */
    public function blog()
    {
        return $this->render('admin/blog/blog.html.twig');
    }
}