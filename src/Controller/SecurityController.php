<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * conncet function
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    #[Route('/connect', name: 'security.login', methods:['GET', 'POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * logout() function
     *
     * @return void
     */
    #[Route('/logout', name:'security.logout', methods: ['GET'])]
    public function logout(){
    }

    /**
     * register() function
     *
     * @return Response
     */
    #[Route('/register', name:'security.register', methods: ['GET', 'POST'])]
    public function register(Request $request, EntityManagerInterface $manager):Response{
        $user= new User();
        $user->setRoles(['ROLE_USER']);
        $form= $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if ( $form->isSubmitted() && $form->isValid() ) {
            $user= $form->getData();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre compte a bien été créé.');
            return $this->redirectToRoute('security.login');
        }
        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
