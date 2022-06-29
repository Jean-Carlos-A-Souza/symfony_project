<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\File;

class GaleriaItemType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titulo', TextType::class, 
          ['label'=>'Titulo da Imagen',
          'attr' => ['minlength'=>'10']
          ])  
        ->add('descricao', TextareaType::class, 
          ['label'=>'Descrição da Imagen',
            'attr' => ['minlength'=>'40']
            ]) 
        ->add('imagen', FileType::class,  array('data_class' => null), [
          'label' => 'Enviar Imagen',

          'constraints' => [
              new File([
                  'maxSize' => '1024k',
                  'mimeTypes' => 'image/jpeg',
                  'mimeTypesMessage' => 'Por Favor, envie um imagen valida',
              ])
          ],
        ]);
        
        
    }

}