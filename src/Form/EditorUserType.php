<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditorUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('roles', ChoiceType::class, 
            [
                'multiple'=>true,
                'choices'=> [
                    /*ROLE_ADMIN }
         - { path: ^/editor, roles: ROLE_WRITTER }
         - { path: ^/profile, roles: ROLE_READER*/
                    "ROLE_READER" => "ROLE_READER",
                    "ROLE_WRITTER"=> "ROLE_WRITTER",
                    "ROLE_ADMIN"=>"ROLE_ADMIN"
                ],
                "expanded"=> true
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
