<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

class NoticiaType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titulo', TextType::class, 
          ['label'=>'Titulo do Noticia',
          'attr' => ['minlength'=>'10']
          ])  
        ->add('descricao', TextareaType::class, 
        ['label'=>'Descrição do Noticia',
        'attr' => ['minlength'=>'30']
        ])  
        ->add('autor', TextType::class, 
        ['label'=>'Autor'])  
        ->add('data', DateType::class,  [
            'widget' => 'single_text',
            'label'=>'Data da Noticia',
            'attr' => ['class' => 'js-datepicker']
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