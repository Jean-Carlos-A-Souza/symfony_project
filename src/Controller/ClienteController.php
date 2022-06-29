<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ClienteController extends AbstractController
{
    #[Route('/cliente', name: 'cliente')]
      /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function index( ClienteRepository $clienteRepo,EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {   

      $pagination= $data['clientes']=$clienteRepo->findAll();

       $pagination = $paginator->paginate(
        $pagination,
        $request->query->getInt('page', 1), /*page number*/
        10 /*limit per page*/
    );

      return $this->render('cliente/index.html.twig',['pagination' => $pagination]);
    }

    #[Route('/cliente/adicionar', name: 'cliente_adicionar')]
      /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function adicionar(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $msg ='';
        $cliente = new Cliente();
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          
          $clienteForm = $form->get('imagen')->getData();
          if ($clienteForm) {
              $originalFilename = pathinfo($clienteForm->getClientOriginalName(), PATHINFO_FILENAME);
              $safeFilename = $slugger->slug($originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$clienteForm->guessExtension();

              try {
                  $clienteForm->move(
                      $this->getParameter('clientes_directory'),
                      $newFilename
                  );
              } catch (FileException $e) {
                  
              }
              $cliente->setImagen($newFilename);
          }

          $em->persist($cliente);
          $em->flush();
          
          $msg="Cliente Cadastrado Com Sucesso";   
         }

        $data['Titulo'] = 'Adicionar Novos Produtos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('cliente/cadastro.html.twig', $data);
      }

    /**
     * @Route("/cliente/editar/{id}", name="cliente_editar")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ClienteRepository $clienteRepo): Response
    {
        $msg ='';
        $cliente = $clienteRepo->find($id);
        $form = $this->createForm(ClienteType::class, $cliente);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->flush();
          $msg="Cliente Atualizado Com Sucesso";   
         }

        $data['Titulo'] = 'Editar Clientes';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('cliente/cadastro.html.twig', $data);
      }

       /**
     * @Route("/cliente/excluir/{id}", name="cliente_excluir")
      * @IsGranted("ROLE_ADMIN")
     */
    public function excluir($id, EntityManagerInterface $em, ClienteRepository $clienteRepo): Response
    {
        
        $cliente = $clienteRepo->find($id);
        $em ->remove($cliente);
        $em->flush();

        return $this->redirectToRoute('cliente');

      }
}

