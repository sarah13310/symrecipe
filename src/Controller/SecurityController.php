<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/connect', name: 'security.login', methods:['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('security/login.html.twig', [
            
        ]);
    }
}