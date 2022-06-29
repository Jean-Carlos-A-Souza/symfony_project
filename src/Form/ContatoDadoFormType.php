<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ContatoDadoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('telefone', TextType::class, 
          ['label'=>'Telefone',
          'attr' => ['class' => 'telefone',
                    'maxlength'=>'15',
                    ]
          ])  
        ->add('email', TextType::class, 
          ['label'=>'E-mail'])
        ->add('endereco', TextType::class, 
          ['label'=>'Endereço'])    
         
          ->add('Salvar', SubmitType::class);      
        
    }
}