<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ContatoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nome', TextType::class, 
          ['label'=>'Nome',
          'attr' => [
                    
                    'placeholder' => 'Digite o Nome ...' ]
           ])
          ->add('sobrenome', TextType::class, 
          ['label'=>'Sobreome',
          'attr' => [
                    
                    'placeholder' => 'Digite o Sobrenome ...' ]
         ])
          ->add('telefone', TextType::class, [
          'label'=>'Telefone',
          'attr' => ['class' => 'telefone',
                    'maxlength'=>'15',
                    'placeholder' => 'Digite o Telefone ...' ]   
           ])
          ->add('email', TextType::class, 
          ['label'=>'Email',
          'attr' => [
          'minlength'=>'10',
          'placeholder' => 'Digite o E-Mail ....' ]   
          
          ])  
          ->add('data', DateType::class,  [
            'widget' => 'single_text',
            'label'=>'Data',
            'attr' => ['class' => 'js-datepicker']
        ])
        ->add('mensagem', TextareaType::class, 
          ['label'=>'Mensagem',
          'attr' => [
          'placeholder' => 'Digite Sua Mensagen ...' ]   
          ]) 
        ->add('Enviar', SubmitType::class,
             ['attr' => ['class' => 'login_submit text-white' ]
            ]);
        
    }
}