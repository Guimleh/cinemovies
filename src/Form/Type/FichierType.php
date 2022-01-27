<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Movie;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class FichierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class,[
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File(['maxSize' => '1024k', 'mimeTypes' => ['text/csv'] ])
                ]
            ])
            ->add('Valider', SubmitType::class)
            ;
        
        
    }

}