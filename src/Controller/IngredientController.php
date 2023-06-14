<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;



class IngredientController extends AbstractController
{
    /**
     * index function
     *
     * @param IngredientRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/ingredient', name: 'ingredient.index', methods: 'GET')]
    public function index(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $paginator->paginate(
            $repository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
    
        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }     

    #[Route('ingredient/new', name: 'ingredient.new',methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response{
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $ingredient=$form->getData();
            $manager->persist($ingredient);
            $manager->flush();
            //
            $this->addFlash('success', 'Votre ingredient a bien été enregistré.');
            
            return $this->redirectToRoute('ingredient.index'); 

        }

        return $this->render('ingredient/new.html.twig', [  
            'form' => $form->createView()
        ]);
        
    }
    #[Route('ingredient/edit/{id}', name: 'ingredient.edit', methods: ['GET','POST'])]
    public function update(Request $request, EntityManagerInterface $manager, Ingredient $ingredient): Response{
        
        
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ingredient);
            $manager->flush();
            //
            $this->addFlash('success', 'Votre ingredient a bien été modifié.');            
            return $this->redirectToRoute('ingredient.index'); 
        }
        
        return $this->render('ingredient/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('ingredient/delete/{id}', name: 'ingredient.delete', methods: ['GET','POST'])]
    public function delete(Request $request, EntityManagerInterface $manager, Ingredient $ingredient):Response{

        if (!$ingredient){
            $this->addFlash('warning', 'Votre ingredient n\'a pas été trouvé.');
            return $this->redirectToRoute('ingredient.index');      
        }
        $manager->remove($ingredient);
        $manager->flush();
        $this->addFlash('success', 'Votre ingredient a bien été supprimé.');
        return $this->redirectToRoute('ingredient.index');
    }
}