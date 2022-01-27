<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Movie;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaults = [
            'nb_votes' => 1,
        ];

        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('plot', TextType::class, [
                'label' => 'Synopsis :',
                'attr' => [
                    'placeholder' => '255 caractères maximum'
                ]
            ])
            ->add('mark', IntegerType::class, [
                'label' => 'Note :',
                'attr' => [
                    'min' => 0,
                    'max' => 10,
                    'placeholder' => 'Mettez une note'
                ]
            ])
            ->add('nb_votes', IntegerType::class, [
                'empty_data' => '1',
            ])
            ->add('Valider', SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}