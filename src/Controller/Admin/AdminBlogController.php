<?php

namespace App\Controller\Admin;

use App\Entity\Blog\Article;
use App\Entity\Blog\Categorie;
use App\Form\Blog\ArticleType;
use App\Form\Blog\CategorieType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function blog(Request $request)
    {

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        // Formulaire pour catégorie
        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid())
        {
            try {
                $em->persist($categorie);
                $em->flush();
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Il y a eu un problème');
            }
            $this->addFlash('success', 'Catégorie créee avec succés');

            return $this->redirectToRoute('admin_blog');
        }

        // Formulaire pour article
        $article = new Article();
        $formArticle = $this->createForm(ArticleType::class, $article);
        $formArticle->handleRequest($request);

        if ($formArticle->isSubmitted() && $formArticle->isValid())
        {
            $article->setUser($user);
            try {
                $em->persist($article);
                $em->flush();
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Il y a eu un problème');
            }
            $this->addFlash('success', 'Article créee avec succés');

            return $this->redirectToRoute('admin_blog');
        }

        return $this->render('admin/blog/blog.html.twig',
            [
                'categories' => $categories,
                'articles' => $articles,
                'formCategorie' => $formCategorie->createView(),
                'formArticle' => $formArticle->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="admin_blog_edit")
     * @param Request $request
     * @param Article $article
     * @return RedirectResponse|Response
     */
    public function editArticle(Request $request, Article $article)
    {
       if ($article == null) {
           $this->addFlash('error', 'Article introuvable');
       }

       $em = $this->getDoctrine()->getManager();
       $form = $this->createForm(ArticleType::class, $article);
       $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Article modifié avec succès');
            return $this->redirectToRoute('admin_blog_edit', array('id' => $article->getId()));

        }
        return $this->render('admin/blog/edit-article.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="admin_blog_delete")
     * @param Article $article
     * @return RedirectResponse
     */
    public function delete(Article $article) {
        if ($article == null) {
            $this->addFlash('error', 'Article introuvable');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $this->addFlash('success', 'Article retiré');

        return $this->redirectToRoute('admin_blog');
    }

}