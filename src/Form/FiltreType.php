<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction('/profile/filtre')
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
            'attr' => ['id' => 'filterForm']
        ]);
    }
}
