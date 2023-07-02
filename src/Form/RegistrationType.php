<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationType extends AbstractType
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
        'label_attr' => ['class' => 'form-label'],
        'constraints' => [new Assert\NotBlank(),new Assert\Length(min: 5, max: 50)]

        ])
        ->add('pseudo', TextType::class, ['attr'=>[
            'class' => 'form-control',
            'minlength' => 5,
           'maxlength' =>50
        ],
        'required' => false,
        'label' =>'Pseudo',
        'label_attr' => ['class' => 'form-label'],
        'constraints' => [new Assert\Length(min: 5, max: 50)]
            
        ])

        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Mot de passe',
                'attr' => ['class' => 'form-control']
                ],
           'second_options' => [
            'attr' => ['class' => 'form-control',],
            'label' => 'Confirmation'],
            'label_attr' => ['class' => 'form-label'],
        ])

        ->add('email', EmailType::class, ['attr'=>[
            'class' => 'form-control'],
            'label' =>'Email',
            'label_attr' => ['class' => 'form-label'],
            'constraints' => [new Assert\NotBlank(), 
            new Assert\Email(),                
            new Assert\Length(min: 5, max: 180)] ,
            "invalid_message" => "Veuillez saisir une adresse email",
            
        ])

        
        ->add('submit', SubmitType::class,[
            'attr' => ['class' => 'btn btn-primary mt-3'],
            'label' => 'S\'inscrire',
            
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
