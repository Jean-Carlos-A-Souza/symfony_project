<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

class GaleriaType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titulo', TextType::class, 
          ['label'=>'Titulo',
          'attr' => [
                    'minlength'=>'5',
                    ]
          ])  
        ->add('descricao', TextareaType::class, 
          ['label'=>'Descricao',
          'attr' => [
                    'minlength'=>'55',
                    ]
                ]);
         
        
    }
}