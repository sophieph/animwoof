<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Article;
use App\Entity\Blog\Categorie;
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

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('admin/blog/blog.html.twig',
            [
                'categories' => $categories,
                'articles' => $articles
            ]
        );
    }
}