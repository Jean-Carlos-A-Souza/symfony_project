<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Validator\Constraints\File;

class DepoimentoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nome', TextType::class, 
          ['label'=>'Nome do Cliente',
          'attr' => ['minlength'=>'5']
          ])  
        ->add('depoimento', TextareaType::class, 
          ['label'=>'Depoimento do Cliente',
          'attr' => ['minlength'=>'35']
          ]) 
          ->add('imagen', FileType::class, [
            'label' => 'Enviar Imagen',
  
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' =>[ 'image/jpeg',
                                'image/png',
                     ],
                    'mimeTypesMessage' => 'Por Favor, envie um imagen valida',
                ])
            ],
          ])
          ->add('Salvar', SubmitType::class);      
    }
}