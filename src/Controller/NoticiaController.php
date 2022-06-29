<?php

namespace App\Controller;

use App\Entity\Noticia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\NoticiaType;
use App\Repository\NoticiaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class NoticiaController extends AbstractController
{
    #[Route('/noticia', name: 'noticia')]
    /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function index(NoticiaRepository $noticiaRepo, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination= $data['noticias']=$noticiaRepo->findAll();

        $pagination = $paginator->paginate(
         $pagination,
         $request->query->getInt('page', 1), /*page number*/
         10 /*limit per page*/
     );

     return $this->render('noticia/index.html.twig',['pagination' => $pagination]);
 
    }
    
    #[Route('/noticia/adicionar', name: 'noticia_adicionar')]
    /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function adicionar(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        
        $msg ='';
        $noticia = new Noticia();
        $form = $this->createForm(NoticiaType::class, $noticia) ;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $noticiaImg = $form->get('imagen')->getData();
          if ($noticiaImg) {
              $originalFilename = pathinfo($noticiaImg->getClientOriginalName(), PATHINFO_FILENAME);
              $safeFilename = $slugger->slug($originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$noticiaImg->guessExtension();

              try {
                  $noticiaImg->move(
                      $this->getParameter('noticias_directory'),
                      $newFilename
                  );
              } catch (FileException $e) {
                  
              }
              $noticia->setImagen($newFilename);
          }
          $em->persist($noticia);
          $em->flush();
          
          $msg="Produto Cadastrado Com Sucesso";   
         }

        $data['Titulo'] = 'Adicionar Novas Noticias';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('noticia/cadastro.html.twig', $data);
      }

       /**
     * @Route("/noticia/editar/{id}", name="noticia_editar")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, NoticiaRepository $noticiaRepo): Response
    {
        $msg ='';
        $noticia = $noticiaRepo->find($id);
        $form = $this->createForm(NoticiaType::class, $noticia);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->flush();
          $msg="Noticia Atualizada Com Sucesso";   
         }

        $data['Titulo'] = 'Editar Produtos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('noticia/cadastro.html.twig', $data);
      }

      
       /**
     * @Route("/noticia/excluir/{id}", name="noticia_excluir")
     * @IsGranted("ROLE_ADMIN")
     */
    public function excluir($id, EntityManagerInterface $em, NoticiaRepository $noticiaRepo): Response
    {
        
        $noticia = $noticiaRepo->find($id);
        $em ->remove($noticia);
        $em->flush();

        return $this->redirectToRoute('noticia');

      }



}
