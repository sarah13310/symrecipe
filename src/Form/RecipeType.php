<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name',
        TextType::class, 
        [
            'attr' => ['class' => 'form-control',
            'minlength'=>'2',
            'maxlength'=>'50'
        ],
            'label'=>'Nom',
            'label_attr' => ['class' => 'form-label mt-2' ],
            'constraints'=>[ new Assert\NotBlank(), new Assert\Length(min:2,max:50)]
        ])
        ->add('time',
        IntegerType::class, 
        [
            'attr' => ['class' => 'form-control',    
            'min'=>'1',
            'max'=>'1440'        
        ],
            'label'=>'Durée ',
            'label_attr' => ['class' => 'form-label mt-2' ],
            'constraints'=>[  new Assert\Positive(), new Assert\LessThan(1441)]
        ])
        ->add('nbPeople',
        IntegerType::class, 
        [
            'attr' => ['class' => 'form-control',    
            'min' => '1',
            'max' => '25',        
        ],
            'label'=>'Nombre de personnes :',
            'label_attr' => ['class' => 'form-label mt-2' ],
            'constraints'=>[  new Assert\Positive(), new Assert\LessThan(26)]
        ])
        ->add('difficulty',
        RangeType::class, 
        [
            'attr' => ['class' => 'form-range',     
            'min'=>'1',
            'max'=>'5'       
        ],
            'label'=>'Difficulté',
            'label_attr' => ['class' => 'form-label mt-2' ],
            'constraints'=>[  new Assert\Positive(), new Assert\LessThan(6)]
        ])
        ->add('description',
        TextareaType::class, 
        [
            'attr' => ['class' => 'form-control',
            
        ],
            'label'=>'Description',
            'label_attr' => ['class' => 'form-label mt-2' ],
            'constraints'=>[ new Assert\NotBlank(), new Assert\Length(min:2,max:50)]
        ])
        ->add('price',
        MoneyType::class, 
        [
            'attr' => ['class' => 'form-control',
            'min'=>'1',
            'max'=>'500'
        ],
            'label'=>'Prix',
            'label_attr' => ['class' => 'form-label mt-2' ],
            'constraints'=>[ new Assert\Positive(), new Assert\LessThan(501)]
        ])
        ->add('isFavorite',
        CheckboxType::class, 
        [
            'attr' => ['class' => 'form-option',
            
            
        ],
            'required' => false,
            'label'=>'Favori ',
            'label_attr' => ['class' => 'form-label ' ],            
        ])    
        ->add('ingredients',
        EntityType::class, 
        [  
            'attr' => ['class' => 'form-select mt-2',],
            'class' => Ingredient::class,
            'query_builder' => function (IngredientRepository $er) use ($options) {
                return $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC');
            },
            'choice_label' => 'name',
            'multiple' => true,// choix multiple
            'expanded' => true, // on ajoute les checkbox
        ],
        )  
            
        

            ->add('submit', SubmitType::class, ['attr' => ['class' => 'btn btn-primary mt-3',]]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
