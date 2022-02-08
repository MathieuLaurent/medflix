<?php

namespace App\Form;

use DateTime;
use App\Entity\User;
use App\Entity\Media;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction('filtre/')
            ->setMethod('GET')
            ->add('createdAt', ChoiceType::class, [
                'choices' => [
                    'Date' => 'date',
                    'Nom' => 'nom'
                ],
                'multiple' => false,
                'expanded' => true
            ])
            ->add('extension', ChoiceType::class, [
                'choices' => [
                    'jpg' => 'jpg',
                    'jpeg' => 'jpeg',
                    'png' => 'png',
                    'gif' => 'gif',
                    'pdf' => 'pdf',
                    'mp4' => 'mp4',
                    'avi' => 'avi',
                    'webm' => 'webm'
                ],
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
