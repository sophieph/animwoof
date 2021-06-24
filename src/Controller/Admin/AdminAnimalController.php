<?php

namespace App\Controller\Admin;

use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Animal;
use App\Entity\Espece;
use App\Form\Admin\AddAnimalType;
use App\Form\Admin\AddEspeceType;
use App\Services\Admin\AnimalService;
use App\Services\Admin\ImageService;

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
    public function animals(Request $request, PaginatorInterface $paginator, ImageService $imageService): Response
    {
        $animals = $this->getDoctrine()->getRepository(Animal::class)->findAll();
        $animalsAdoptedReq = $this->getDoctrine()->getRepository(Animal::class)->findBy(['isAdopted' => true]);
        $animalsNotAdoptedReq = $this->getDoctrine()->getRepository(Animal::class)->findBy(['isAdopted' => false]);

        $animalsAdopted = $paginator->paginate(
            $animalsAdoptedReq,
            $request->query->getInt('page', 1),
            10
        );

        $animalsNotAdopted = $paginator->paginate(
            $animalsNotAdoptedReq,
            $request->query->getInt('page', 1),
            10
        );

        $especes = $this->getDoctrine()->getRepository(Espece::class)->findAll();

        $em = $this->getDoctrine()->getManager();

        // Formulaire pour espèce
        $espece = new Espece();
        $formEspece = $this->createForm(AddEspeceType::class, $espece);
        $formEspece->handleRequest($request);

        if ($formEspece->isSubmitted() && $formEspece->isValid()){
            $name = $request->request->get('nom');
            $especeExist = $this->getDoctrine()->getRepository(Espece::class)->findOneBy(['nom' => $name]);

            // On vérifie si l'espèce existe
            if ($especeExist) {
                $this->addFlash('error', 'Espèce déjà existante');
                return $this->redirectToRoute('admin_animals');
            }

            try {
                $em->persist($espece);
                $em->flush();
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Il y a eu un problème');
            }
            $this->addFlash('success', 'Espèce créee avec succés');
            return $this->redirectToRoute('admin_animals');
        }

        // Formulaire pour animal
        $animal = new Animal();
        $formAnimal = $this->createForm(AddAnimalType::class, $animal);
        $formAnimal->handleRequest($request);

        if ($formAnimal->isSubmitted() && $formAnimal->isValid()){
            $img = $formAnimal->get('photo')->getData();
            if ($img) {
                $file = $imageService->upload($img, 'animal');
                $animal->setPhoto($file);
            }
            try {
                $em->persist($animal);
                $em->flush();
            } catch (\Exception $exception) {
                $this->addFlash('error', 'Il y a eu un problème');
            }
            $this->addFlash('success', 'Animal créee avec succés');
            return $this->redirectToRoute('admin_animals');
        }

        return $this->render('admin/animal/animals.html.twig', [
            'animals' => $animals,
            'animalsAdopted' => $animalsAdopted,
            'animalsNotAdopted' => $animalsNotAdopted,
            'especes' => $especes,
            'formEspece' => $formEspece->createView(),
            'formAnimal' => $formAnimal->createView()
        ]);
    }


    /**
     * @Route("/{id}", name="admin_animals_edit")
     * @param Request $request
     * @param Animal $animal
     * @param ImageService $imageService
     * @return RedirectResponse|Response
     */
    public function editAnimal(Request $request, Animal $animal, ImageService $imageService)
    {
        if ($animal == null) {
            $this->addFlash('danger', 'Animal introuvable');
            return $this->redirectToRoute('admin_animals');
        }

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(AddAnimalType::class, $animal);
        $form->handleRequest($request);

        $photo = $animal->getPhoto();

        if ($form->isSubmitted() && $form->isValid()) {
            $img = $form->get('photo')->getData();
            if ($img != null) {
                unlink($this->getParameter('animal_images_directory') . '/' . $photo);
                $file = $imageService->upload($img, 'animal');
                $animal->setPhoto($file);
            }
            $em->persist($animal);
            $em->flush();

            $this->addFlash('success', 'Animal modifié avec succès');
            return $this->redirectToRoute('admin_animals_edit', array('id' => $animal->getId()));

        }
        return $this->render('admin/animal/edit-animal.html.twig', [
            'form' => $form->createView(),
            'animal' => $animal,
        ]);
    }
}