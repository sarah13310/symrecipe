<?php

namespace App\DataFixtures;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredients=[];
        for( $i = 1; $i < 50;$i++){
            $ingredient = new Ingredient();
            $ingredient->setName('Ingredient'.$i);
            $ingredient->setPrice(mt_rand(20,180));
            $manager->persist($ingredient);
            $ingredients[]=$ingredient;
        }     
        // Recipes
        for( $i = 1; $i < 50;$i++){
            $recipe = new Recipe();
            $recipe->setName('Recette'.$i)
            ->setTime(mt_rand(2,15))
            ->setNbPeople(mt_rand(1,25))
            ->setDifficulty(mt_rand(1,5))
            ->setDescription("Voici une recette facile à faire en famille.Sinon vous pouvez la savourer tout seul. ")
            ->setPrice(mt_rand(20,180))
            ->setIsFavorite(mt_rand(0,1));
            for ($j = 1; $j < mt_rand(5,20); $j++) {
                $recipe->addIngredient($ingredients[mt_rand(0,count($ingredients) - 1)]);
            }
            $manager->persist($recipe);
        }        
        $manager->flush();
    }
}
