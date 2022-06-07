<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class apresenta extends AbstractController
{
    /**
     * @Route("/", name="home_page")
    */
    public function homepage()
    {
        return $this->render('index.html.twig');
        return new Response('Ola Mundo Teste Symfony 2');
    }
 
     /**
     * @Route("/logado", name="logado")
    */

    public function show()
    {
        return $this->render('index.html.twig');

    }

       /**
     * @Route("/contatos", name="contatos")
    */

    public function contato()
    {
        return $this->render('contacts.html.twig');
    }


}