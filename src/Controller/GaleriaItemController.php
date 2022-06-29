<?php

namespace App\Controller;

use App\Entity\GaleriaItems;
use App\Form\GaleriaItemType;
use App\Repository\GaleriaItemsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\HttpFoundation\File\File;

class GaleriaItemController extends AbstractController
{
    #[Route('/galeria_item', name: 'galeria_item')]  
                 /**
    * @IsGranted("ROLE_ADMIN")
    */
      public function index( GaleriaItemsRepository $galeriaItemRepo,EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
        {   
    
          $pagination= $data['galeria_items']=$galeriaItemRepo->findAll();
    
           $pagination = $paginator->paginate(
            $pagination,
            $request->query->getInt('page', 1), 5
        );
    
          return $this->render('galeria_item/index.html.twig',['pagination' => $pagination]);
        }
    
        #[Route('/galeria_item/adicionar', name: 'galeria_item_adicionar')]
                     /**
    * @IsGranted("ROLE_ADMIN")
    */
        public function adicionar(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
        {
            $msg ='';
            $galeria = new GaleriaItems();
            $form = $this->createForm(GaleriaItemType::class, $galeria);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
              
    
              $galeriaImg = $form->get('imagen')->getData();
              if ($galeriaImg) {
                  $originalFilename = pathinfo($galeriaImg->getClientOriginalName(), PATHINFO_FILENAME);
                  $safeFilename = $slugger->slug($originalFilename);
                  $newFilename = $safeFilename.'-'.uniqid().'.'.$galeriaImg->guessExtension();
    
                  try {
                      $galeriaImg->move(
                          $this->getParameter('galeria_directory'),
                          $newFilename
                      );
                  } catch (FileException $e) {
                      
                  }
                  $galeria->setImagen($newFilename);
              }
              $em->persist($galeria);
              $em->flush();
              
              $msg="Items da Galeria Cadastrado Com Sucesso";   
             }
    
            $data['Titulo'] = 'Adicionar Novos Items a Galeria';
            $data['form'] = $form;
            $data['msg'] = $msg;
    
            return $this->renderForm('galeria_item/cadastro.html.twig', $data);
          }
    
        /**
         * @Route("/galeria_item/editar/{id}", name="galeria_item_editar")
         * @IsGranted("ROLE_ADMIN")
         */
        public function editar($id, Request $request, EntityManagerInterface $em, GaleriaItemsRepository $galeriaItemRepo): Response
        {
            $msg ='';
            $galeria = $galeriaItemRepo->find($id);
            $form = $this->createForm(GaleriaItemType::class, $galeria);
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
              $em->flush();
              $msg="Item da Galeria Atualizado Com Sucesso";   
             }
    
            $data['Titulo'] = 'Editar Item da Galeria';
            $data['form'] = $form;
            $data['msg'] = $msg;
    
            return $this->renderForm('galeria_item/cadastro.html.twig', $data);
          }
    
           /**
         * @Route("/galeria_item/excluir/{id}", name="galeria_item_excluir")
         * @IsGranted("ROLE_ADMIN")
         */
        public function excluir($id, EntityManagerInterface $em, GaleriaItemsRepository $galeriaItemRepo): Response
        {
            
            $galeriaItem = $galeriaItemRepo->find($id);
            $em ->remove($galeriaItem);
            $em->flush();
    
            return $this->redirectToRoute('galeria_item');
    
          }
    }
    
