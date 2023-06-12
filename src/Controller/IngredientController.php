<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


// Your code here


class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'app_ingredient', methods: 'GET')]
    public function index(IngredientRepository $repository): Response
    {
        $ingredients=$repository->findAll();
        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }
}
