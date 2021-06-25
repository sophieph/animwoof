<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\Products;
use App\Form\Boutique\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Categorie;
use App\Form\Boutique\CategorieType;
use App\Services\Admin\ImageService;

/**
 * @Route("/admin/boutique")
 * Class AdminBlogController
 * @package App\Controller\Admin
 * @IsGranted("ROLE_ADMIN")
 */
class AdminBoutiqueController extends AbstractController
{

    /**
     * @Route("/", name="admin_shop")
     */
    public function shop(Request $request, ImageService $imageService)
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $produits = $this->getDoctrine()->getRepository(Products::class)->findAll();
        $commandes = $this->getDoctrine()->getRepository(Commande::class)->findAll();
        $em = $this->getDoctrine()->getManager();

        // Formulaire pour Catégorie
        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()){
            $name = $request->request->get('name');
            $img = $formCategorie->get('photo')->getData();
            $categorieExist = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(['name' => $name]);

            // On vérifie si la catégorie existe
            if ($categorieExist) {
                $this->addFlash('error', 'Catégorie déjà existante.');
                return $this->redirectToRoute('admin_shop');
            }

            $file = $imageService->upload($img, 'categorie');
            $categorie->setPhoto($file);

            try {
                $em->persist($categorie);
                $em->flush();
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Il y a eu un problème.');
                return $this->redirectToRoute('admin_shop');
            }
            $this->addFlash('success', 'Catégorie créee avec succés.');
            return $this->redirectToRoute('admin_shop');
        }

        // Formulaire pour Produits
        $produit = new Products();
        $formProduit = $this->createForm(ProductType::class, $produit);
        $formProduit->handleRequest($request);

        if ($formProduit->isSubmitted() && $formProduit->isValid()) {
            $img = $formProduit->get('image')->getData();
            if ($img) {
                $file = $imageService->upload($img, 'produit');
                $produit->setImage($file);
            }
            try {
                $em->persist($produit);
                $em->flush();
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Il y a eu un problème.');
                return $this->redirectToRoute('admin_shop');
            }
            $this->addFlash('success', 'Produit créee avec succés.');
            return $this->redirectToRoute('admin_shop');
        }

        return $this->render('admin/shop/shop.html.twig', [
            'categories' => $categories,
            'produits' => $produits,
            'commandes' => $commandes,
            'formCategorie' => $formCategorie->createView(),
            'formProduit' => $formProduit->createView()
        ]);
    }


    /**
     * @Route("/{id}", name="admin_produit_edit")
     * @param Request $request
     * @param Products $produit
     * @param ImageService $imageService
     * @return RedirectResponse|Response
     */
    public function editproduit(Request $request, Products $produit, ImageService $imageService): RedirectResponse|Response
    {

        if ($produit == null) {
            $this->addFlash('danger', 'Produit introuvable');
            return $this->redirectToRoute('admin_shop');
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(ProductType::class, $produit);
        $form->handleRequest($request);

        $image = $produit->getImage();

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('image')->getData();
            if ($img != null) {
                if ($image) {
                    unlink($this->getParameter('product_images_directory') . '/' . $image);
                }
                $file = $imageService->upload($img, 'produit');
                $produit->setImage($file);
            }
            $em->persist($produit);
            $em->flush();

            $this->addFlash('success', 'Produit modifié avec succès');
            return $this->redirectToRoute('admin_produit_edit', array('id' => $produit->getId()));

        }
        return $this->render('admin/shop/edit-produit.html.twig', [
            'form' => $form->createView(),
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="admin_categorie_edit")
     * @param Request $request
     * @param Categorie $categorie
     * @param ImageService $imageService
     * @return RedirectResponse|Response
     */
    public function editCategorie(Request $request, Categorie $categorie, ImageService $imageService)
    {
        if ($categorie == null) {
            $this->addFlash('danger', 'Catégorie introuvable');
            return $this->redirectToRoute('admin_shop');
        }

        $em = $this->getDoctrine()->getManager();

        $produits = $this->getDoctrine()->getRepository(Products::class)->findBy(['categorie' => $categorie]);

        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        $photo = $categorie->getPhoto();

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('photo')->getData();
            if ($img != null) {
                if ($photo) {
                    unlink($this->getParameter('categorie_images_directory') . '/' . $photo);

                }
                $file = $imageService->upload($img, 'categorie');
                $categorie->setPhoto($file);
            }

            $em->persist($categorie);
            $em->flush();

            $this->addFlash('success', 'Catégorie modifié avec succès');
            return $this->redirectToRoute('admin_shop');

        }
        return $this->render('admin/shop/edit-categorie.html.twig', [
            'produits' => $produits,
            'formEditCategorie' => $form->createView(),
            'categorie' => $categorie,
        ]);
    }
    /**
     * @Route("categorie/delete/{id}", name="admin_categorie_delete")
     * @param Categorie $categorie
     * @return RedirectResponse
     */
    public function delete(Categorie $categorie): RedirectResponse
    {
        if ($categorie == null) {
            $this->addFlash('error', 'Catégorie introuvable.');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        $this->addFlash('success', 'Catégorie retiré.');


        return $this->redirectToRoute('admin_shop');
    }
}