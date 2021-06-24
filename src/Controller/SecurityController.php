<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use App\Security\LoginFormAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
//        dd($authenticationUtils);
         if ($this->getUser()) {
             return $this->redirectToRoute('homepage');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/signup", name="signup")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param UserPasswordHasherInterface $passwordHasher
     * @return RedirectResponse|Response
     */
    public function signup(Request $request,EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new User();
        $form = $this->createForm(SignUpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userExists = $em->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
            if ($userExists) {
                $this->addFlash(
                    'verify_email_error',
                    'L\'email existe déjà.'
                );
                return $this->redirectToRoute('signup');
            }

            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('security/signup.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
