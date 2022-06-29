<?php

namespace App\Controller;

use App\Repository\ProdutoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Contato;
use App\Form\ContatoType;
use App\Repository\BannerRepository;
use App\Repository\ClienteRepository;
use App\Repository\ContatoDadosRepository;
use App\Repository\ContatoRepository;
use App\Repository\DepoimentoRepository;
use App\Repository\GaleriaItemsRepository;
use App\Repository\GaleriaRepository;
use App\Repository\NoticiaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;




class apresenta extends AbstractController
{
    /**
     * @Route("/", name="home_page")
    */
    public function homepage(ProdutoRepository $produtoRepo, Request $request, EntityManagerInterface $em, 
    NoticiaRepository $noticiaRepo ,DepoimentoRepository $depoRepo, BannerRepository $bannerRepo,
    ClienteRepository $clienteRepo, ContatoDadosRepository $contDadosRepo, GaleriaRepository $galeriaRepo,
    GaleriaItemsRepository $galeriaItemRepo) : Response
    {
         $msg ="";
         $contato = new contato();
         $form = $this->createForm(ContatoType::class, $contato);
         $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()){
           $em->persist($contato);
           $em->flush();

           return $this->redirect($request->getUri());

        }

          $data['Titulo'] = 'Envie sua Messagem';
          $data['form'] = $form;
          $data['msg'] = $msg;
          $data['produtos'] = $produtoRepo->findAll();
          $data['banners'] = $bannerRepo->findAll();
          $data['clientes'] = $clienteRepo->findAll();
          $data['depoimentos'] = $depoRepo->findAll();
          $data['contatos'] = $contDadosRepo->findAll();
          $data['noticias'] = $noticiaRepo->findAll();
          $data['galerias'] = $galeriaRepo->findAll();
          $data['galeria_items'] = $galeriaItemRepo->findAll();


        return $this->renderForm('base.html.twig',$data);
        
    }
 
     /**
     * @Route("/dashboard", name="dashboard")
    * @IsGranted("ROLE_ADMIN")
    */

    public function show(ContatoRepository $contRepo, ProdutoRepository $prodRepo, ClienteRepository $clienteRepo, 
    DepoimentoRepository $depoRepo, GaleriaRepository $galeRepo)
    {
        
        $data['contatos_count'] = count($contRepo->findAll());
        $data['produtos_count'] = count($prodRepo->findAll());
        $data['clientes_logo_count'] = count($clienteRepo->findAll());
        $data['clientes_depo_count'] = count($depoRepo->findAll());
        $data['galeria_count'] = count($galeRepo->findAll());

        return $this->render('index.html.twig', $data );
    }

    /**
     * @Route("/fail_senha", name="fail_senha")
    */

    public function fail_senha()
    {
        
        return $this->render('login/fail_senha.html.twig');
    }

     


}