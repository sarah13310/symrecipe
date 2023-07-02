<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeController extends AbstractController
{

    /**
     * index() function
     *
     * @param RecipeRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/recette', name: 'recipe.index', methods: ['GET'])]
    public function index(RecipeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $recipes = $paginator->paginate(
            $repository->findBy(['user'=>$this->getUser()]), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }


    /**
     * new() function
     * Création d'une recette
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/recette/new', name: 'recipe.new', methods: ['POST', 'GET'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $manager->persist($recipe);
            $manager->flush();
            //
            $this->addFlash('success', 'La recette a bien été créée');
            return $this->redirectToRoute('recipe.index');
        }
        return $this->render('recipe/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * update() function
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Recipe $recipe
     * @return Response
     */
    #[Route('recipe/edit/{id}', name: 'recipe.edit', methods: ['GET', 'POST'])]
    public function update(Request $request, EntityManagerInterface $manager, Recipe $recipe): Response
    {
        $form = $this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($recipe);
            $manager->flush();
            //
            $this->addFlash('success', 'Votre recette a bien été modifiée.');
            return $this->redirectToRoute('recipe.index');
        }

        return $this->render('recipe/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * delete function
     *
     * @param EntityManagerInterface $manager
     * @param Recipe $recipe
     * @return Response
     */
    #[Route('recipe/delete/{id}', name: 'recipe.delete', methods: ['GET', 'POST'])]
    public function delete( EntityManagerInterface $manager, Recipe $recipe): Response
    {

        if (!$recipe) {
            $this->addFlash('warning', 'Votre recette n\'a pas été trouvée.');
            return $this->redirectToRoute('recipe.index');
        }
        $manager->remove($recipe);
        $manager->flush();
        $this->addFlash('success', 'Votre recette a bien été supprimée.');
        return $this->redirectToRoute('recipe.index');
    }
}
