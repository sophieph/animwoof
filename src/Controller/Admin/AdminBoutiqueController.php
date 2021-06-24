<?php

namespace App\Controller\Admin;

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
        $em = $this->getDoctrine()->getManager();

        // Formulaire pour Catégorie
        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieType::class, $categorie);
        $formCategorie->handleRequest($request);

        if ($formCategorie->isSubmitted() && $formCategorie->isValid()){
            $name = $request->request->get('name');
            $categorieExist = $this->getDoctrine()->getRepository(Categorie::class)->findOneBy(['name' => $name]);

            // On vérifie si la catégorie existe
            if ($categorieExist) {
                $this->addFlash('error', 'Catégorie déjà existante.');
                return $this->redirectToRoute('admin_shop');
            }

            try {
                $em->persist($categorie);
                $em->flush();
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Il y a eu un problème.');
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
            }
            $this->addFlash('success', 'Produit créee avec succés.');
            return $this->redirectToRoute('admin_shop');
        }

        return $this->render('admin/shop/shop.html.twig', [
            'categories' => $categories,
            'produits' => $produits,
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
    public function editproduit(Request $request, Products $produit, ImageService $imageService)
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
                unlink($this->getParameter('product_images_directory') . '/' . $image);
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

//    /**
//     * @Route("/{id}", name="admin_categorie_edit")
//     * @param Request $request
//     * @param Categorie $categorie
//     * @return RedirectResponse|Response
//     */
//    public function editCategorie(Request $request, Categorie $categorie, ImageService $ImageService)
//    {
//        if ($categorie == null) {
//            $this->addFlash('danger', 'Catégorie introuvable');
//            return $this->redirectToRoute('admin_shop');
//        }
//
//        $em = $this->getDoctrine()->getManager();
//
//        $form = $this->createForm(CategorieType::class, $categorie);
//        $form->handleRequest($request);
//
//        $photo = $categorie->getPhoto();
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $img = $form->get('photo')->getData();
//            if ($img != null) {
//                unlink($this->getParameter('categorie_images_directory') . $photo);
//                $file = $ImageService->upload($img);
//                $animal->setPhoto($file);
//            }
//
//
//            $em->persist($animal);
//            $em->flush();
//
//            $this->addFlash('success', 'Catégorie modifié avec succès');
//            return $this->redirectToRoute('admin_categorie_edit', array('id' => $categorie->getId()));
//
//        }
//        return $this->render('admin/categorie/edit-categorie.html.twig', [
//            'form-edit-categorie' => $form->createView(),
//            'categorie' => $categorie,
//        ]);
//    }
}