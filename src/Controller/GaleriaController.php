<?php

namespace App\Controller;

use App\Entity\Galeria;
use App\Form\GaleriaType;
use App\Repository\GaleriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class GaleriaController extends AbstractController
{
    #[Route('/galeria', name: 'galeria')]
     /**
    * @IsGranted("ROLE_ADMIN")
    */
        public function index(GaleriaRepository $galeriaRepo, PaginatorInterface $paginator, Request $request): Response
        {
            $pagination= $data['galerias']=$galeriaRepo->findAll();
    
            $pagination = $paginator->paginate(
             $pagination,
             $request->query->getInt('page', 1), /*page number*/
             10 /*limit per page*/
         );
    
         return $this->render('galeria/index.html.twig',['pagination' => $pagination]);
     
        }
        
        #[Route('/galeria/adicionar', name: 'galeria_adicionar')]
         /**
    * @IsGranted("ROLE_ADMIN")
    */
        public function adicionar(Request $request, EntityManagerInterface $em): Response
        {
            
            $msg ='';
            $galeria = new Galeria();
            $form = $this->createForm(GaleriaType::class, $galeria) ;
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
              $em->persist($galeria);
              $em->flush();
              
              $msg="Dados da Galeria Cadastrado Com Sucesso";   
             }
    
            $data['Titulo'] = 'Adicionar Novas Descricao a Galeria';
            $data['form'] = $form;
            $data['msg'] = $msg;
    
            return $this->renderForm('galeria/cadastro.html.twig', $data);
          }
    
           /**
         * @Route("/galeria/editar/{id}", name="galeria_editar")
         * @IsGranted("ROLE_ADMIN")
         */
        public function editar($id, Request $request, EntityManagerInterface $em, GaleriaRepository $galeriaRepo): Response
        {
            $msg ='';
            $galeria = $galeriaRepo->find($id);
            $form = $this->createForm(GaleriaType::class, $galeria);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
              $em->flush();
              $msg="Galeria foi Atualizada Com Sucesso";   
             }
    
            $data['Titulo'] = 'Editar Dados da Galeria';
            $data['form'] = $form;
            $data['msg'] = $msg;
    
            return $this->renderForm('galeria/cadastro.html.twig', $data);
          }
    
          
           /**
         * @Route("/galeria/excluir/{id}", name="galeria_excluir")
         * @IsGranted("ROLE_ADMIN")
         */
        public function excluir($id, EntityManagerInterface $em, GaleriaRepository $galeriaRepo): Response
        {
            
            $galeria = $galeriaRepo->find($id);
            $em ->remove($galeria);
            $em->flush();
    
            return $this->redirectToRoute('galeria');
    
          }
    
    
    
    }
