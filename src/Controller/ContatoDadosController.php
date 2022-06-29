<?php

namespace App\Controller;

use App\Entity\ContatoDados;
use App\Form\ContatoDadoType;
use App\Repository\ContatoDadosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ContatoDadosController extends AbstractController
{
    #[Route('/contato_dados', name: 'contato_dados')]
    /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function index(ContatoDadosRepository $contDadoRepo, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination= $data['contatos']=$contDadoRepo->findAll();

        $pagination = $paginator->paginate(
         $pagination,
         $request->query->getInt('page', 1), /*page number*/
         10 /*limit per page*/
     );

     return $this->render('contato_dados/index.html.twig',['pagination' => $pagination]);
 
    }
    
    #[Route('/contato_dados/adicionar', name: 'cont_dados_adicionar')]
             /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        
        $msg ='';
        $contatoDado = new ContatoDados();
        $form = $this->createForm(ContatoDadoType::class, $contatoDado) ;
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->persist($contatoDado);
          $em->flush();
          
          $msg="Dados de Contatos Cadastrado Com Sucesso";   
         }

        $data['Titulo'] = 'Adicionar Novos Dados';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('contato_dados/cadastro.html.twig', $data);
      }

       /**
     * @Route("/contato_dados/editar/{id}", name="cont_dados_editar")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ContatoDadosRepository $contDadoRepo): Response
    {
        $msg ='';
        $contatoDado = $contDadoRepo->find($id);
        $form = $this->createForm(ContatoDadoType::class, $contatoDado);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->flush();
          $msg="Dados de Contato foram Atualizados Com Sucesso";   
         }

        $data['Titulo'] = 'Editar Dados de Contatos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('contato_dados/cadastro.html.twig', $data);
      }

      
       /**
     * @Route("/contato_dados/excluir/{id}", name="cont_dados_excluir")
     * @IsGranted("ROLE_ADMIN")
     */
    public function excluir($id, EntityManagerInterface $em, ContatoDadosRepository $contDadoRepo): Response
    {
        
        $contatoDado = $contDadoRepo->find($id);
        $em ->remove($contatoDado);
        $em->flush();

        return $this->redirectToRoute('contato_dados');

      }



}
