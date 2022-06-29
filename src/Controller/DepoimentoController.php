<?php

namespace App\Controller;

use App\Entity\Depoimento;
use App\Form\DepoimentoType;
use App\Repository\DepoimentoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DepoimentoController extends AbstractController
{
    #[Route('/depoimento', name: 'depoimento')]
             /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function index(DepoimentoRepository $DepoimentoRepo, PaginatorInterface $paginator, Request $request): Response
    {   

      $pagination= $data['depoimentos']=$DepoimentoRepo->findAll();

       $pagination = $paginator->paginate(
        $pagination,
        $request->query->getInt('page', 1), /*page number*/
        10 /*limit per page*/
    );

      return $this->render('depoimento/index.html.twig',['pagination' => $pagination]);
    }

    
    #[Route('/depoimento/adicionar', name: 'depoimento_adicionar')]
             /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function adicionar(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $msg ='';
        $depoimento = new Depoimento();
        $form = $this->createForm(DepoimentoType::class, $depoimento);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          
          $depoimentoImg = $form->get('imagen')->getData();
          if ($depoimentoImg) {
              $originalFilename = pathinfo($depoimentoImg->getClientOriginalName(), PATHINFO_FILENAME);
              $safeFilename = $slugger->slug($originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$depoimentoImg->guessExtension();

              try {
                  $depoimentoImg->move(
                      $this->getParameter('depoimentos_directory'),
                      $newFilename
                  );
              } catch (FileException $e) {
                  
              }
              $depoimento->setImagen($newFilename);
          }
          $em->persist($depoimento);
          $em->flush();
          
          $msg="Depoimento Cadastrado Com Sucesso";   
         }

        $data['Titulo'] = 'Adicionar Novos Depoimentos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('depoimento/cadastro.html.twig', $data);
      }

    /**
     * @Route("/depoimento/editar/{id}", name="depoimento_editar")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, DepoimentoRepository $depoimentoRepo): Response
    {
        $msg ='';
        $depoimento = $depoimentoRepo->find($id);
        $form = $this->createForm(DepoimentoType::class, $depoimento);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->flush();
          $msg="Depoimentos Atualizado Com Sucesso";   
         }

        $data['Titulo'] = 'Editar Depoimentos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('depoimento/cadastro.html.twig', $data);
      }

       /**
     * @Route("/depoimento/excluir/{id}", name="depoimento_excluir")
     * @IsGranted("ROLE_ADMIN")
     */
    public function excluir($id, EntityManagerInterface $em, DepoimentoRepository $depoimentoRepo): Response
    {
        
        $depoimento = $depoimentoRepo->find($id);
        $em ->remove($depoimento);
        $em->flush();

        return $this->redirectToRoute('depoimento');

      }
}

