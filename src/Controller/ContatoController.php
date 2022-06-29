<?php

namespace App\Controller;

use App\Entity\Contato;
use App\Form\ContatoType;
use App\Repository\ContatoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ContatoController extends AbstractController
{
    #[Route('/contato', name: 'contato')]
          /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function index(ContatoRepository $contatoRepo, PaginatorInterface $paginator, Request $request): Response
    {   

      $pagination= $data['contatos']=$contatoRepo->findAll();

       $pagination = $paginator->paginate(
        $pagination,
        $request->query->getInt('page', 1), /*page number*/
        10 /*limit per page*/
    );

      return $this->render('contato/index.html.twig',['pagination' => $pagination]);
    }

    
    #[Route('/contato/adicionar', name: 'contato_adicionar')]
    /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        $msg ='';
        $contato = new contato();
        $form = $this->createForm(ContatoType::class, $contato);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->persist($contato);
          $em->flush();
          
          $msg="Contato Cadastrado Com Sucesso";   
         }

        $data['Titulo'] = 'Adicionar Novos Contatos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('contato/cadastro.html.twig', $data);
      }

    /**
     * @Route("/contato/editar/{id}", name="contato_editar")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ContatoRepository $contatoRepo): Response
    {
        $msg ='';
        $contato = $contatoRepo->find($id);
        $form = $this->createForm(ContatoType::class, $contato);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->flush();
          $msg="Contatos Atualizado Com Sucesso";   
         }

        $data['Titulo'] = 'Editar Contatos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('contato/cadastro.html.twig', $data);
      }

       /**
     * @Route("/contato/excluir/{id}", name="contato_excluir")
     * @IsGranted("ROLE_ADMIN")
     */
    public function excluir($id, EntityManagerInterface $em, ContatoRepository $contatoRepo): Response
    {
        
        $contato = $contatoRepo->find($id);
        $em ->remove($contato);
        $em->flush();

        return $this->redirectToRoute('contato');

      }
}

