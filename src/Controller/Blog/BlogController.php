<?php

namespace App\Controller\Blog;

use App\Entity\Blog\Article;
use App\Entity\Blog\Categorie;
use App\Form\Blog\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 * Class BlogController
 * @package App\Controller\Blog
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog")
     * @return Response
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="blog_categorie")
     * @param Categorie $categorie
     * @return Response
     */
    public function showArticlesFromCategorie(Categorie $categorie): Response
    {
        $articles = $categorie->getArticles();

        return $this->render('blog/categorie.html.twig', [
            'articles' => $articles,
            'categorie' => $categorie
        ]);
    }

    /**
     * @Route("/article/{id}", name="blog_article")
     * @param Article $article
     * @return Response
     */
    public function showArticle(Article $article) {
        return $this->render('blog/article.html.twig', [
            'article' => $article
        ]);
    }



}
