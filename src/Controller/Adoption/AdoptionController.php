<?php

namespace App\Controller\Adoption;

use App\Entity\Animal;
use App\Entity\Reservation;
use App\Form\Adoption\ReservationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/adoption")
 * Class AdoptionController
 * @package App\Controller\Adoption
 */
class AdoptionController extends AbstractController
{

    /**
     * @Route("/", name="adoption")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $animals = $this->getDoctrine()->getRepository(Animal::class)->findAll();

        $animals = $paginator->paginate(
            $animals,
            $request->query->getInt('page', 1),
            10
        );

        $animalAdoptedLastMonth = $this->getDoctrine()->getRepository(Animal::class)->findLastAdopted();
        return $this->render('adoption/index.html.twig', [
            'date' => new \Datetime('last day of last month'),
        'animals' => $animals,
            'animalAdopted' => $animalAdoptedLastMonth
        ]);
    }

    /**
     * @Route("/animal/{id}", name="adoption_animal_description")
     * @param Animal $animal
     * @return Response
     */
    public function animal(Request $request, Animal $animal)
    {

        $em = $this->getDoctrine()->getManager();

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            if ($user) {
                $reservation->setAnimal($animal);
                $reservation->setUser($user);
                $reservation->setEmail($user->getEmail());
                $animal->setIsAdopted(true);
                $animal->setDateAdoption(new \DateTime());
                $animal->setReservation($reservation);
                $em->persist($reservation);
                $em->persist($animal);
                $em->flush();
            }

            $this->addFlash('success', 'Génial ! On se retrouve très prochainement avec votre futur membre de la famille ! ');

            return $this->redirectToRoute('adoption_animal_description', ['id' => $animal->getId()]);
        }

        return $this->render('adoption/animal-description.html.twig', [
            'animal' => $animal,
            'form' => $form->createView()
        ]);
    }
}
