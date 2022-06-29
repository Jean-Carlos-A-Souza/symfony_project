<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class BannerType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titulo', TextType::class, 
          ['label'=>'Titulo do Banner'])  
          ->add('descricao', TextareaType::class, 
          ['label'=>'Descricao do Banner'])  
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