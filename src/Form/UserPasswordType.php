<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder 
            
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'label' => 'Mot de passe actuel',
                'attr' => ['class' => 'form-control']
                ],
           'second_options' => [
            'attr' => ['class' => 'form-control',],
            'label' => 'Confirmation du mot de passe'],
            'label_attr' => ['class' => 'form-label'],
        ])

        ->add('newPassword', PasswordType::class, ['attr'=>[
            'class' => 'form-control',
            'minlength' => 5,
           'maxlength' =>50
        ],
        'label' =>'Nouveau mot de passe',
        'label_attr' => ['class' => 'form-label'],
        'constraints' => [new Assert\NotBlank(),new Assert\Length(min: 5, max: 50)]

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
