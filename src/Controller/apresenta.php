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
        return $this->render('base.html.twig');
        
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
    /**
     * @Route("/fail_senha", name="fail_senha")
    */

    public function fail_senha()
    {
        return $this->render('login/fail_senha.html.twig');
    }


}