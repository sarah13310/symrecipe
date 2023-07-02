<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('fullname', TextType::class, ['attr'=>[
            'class' => 'form-control',
            'minlength' => 5,
           'maxlength' =>50
        ],
        'label' =>'Nom / Prénom',
        'label_attr' => ['class' => 'form-label mt-4'],
        'constraints' => [new Assert\NotBlank(),new Assert\Length(min: 5, max: 50)]

        ])
        ->add('pseudo', TextType::class, ['attr'=>[
            'class' => 'form-control',
            'minlength' => 5,
           'maxlength' =>50
        ],
        'required' => false,
        'label' =>'Pseudo',
        'label_attr' => ['class' => 'form-label mt-4'],
        'constraints' => [new Assert\Length(min: 5, max: 50)]
            
        ])
        ->add('submit', SubmitType::class,[
            'attr' => ['class' => 'btn btn-primary mt-3'],
            'label' => 'Modifier',
            
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
