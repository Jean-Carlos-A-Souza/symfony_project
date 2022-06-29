<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\HttpFoundation\File\File;




class ProdutoController extends AbstractController
{
    #[Route('/produto', name: 'produto')]
     /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function index( ProdutoRepository $produtoRepo,EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {   

      $pagination= $data['produtos']=$produtoRepo->findAll();

       $pagination = $paginator->paginate(
        $pagination,
        $request->query->getInt('page', 1), /*page number*/
        10 /*limit per page*/
    );

      return $this->render('produto/index.html.twig',['pagination' => $pagination]);
    }

    #[Route('/produto/adicionar', name: 'produto_adicionar')]
     /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function adicionar(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $msg ='';
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          

          $produtoImg = $form->get('imagen')->getData();
          if ($produtoImg) {
              $originalFilename = pathinfo($produtoImg->getClientOriginalName(), PATHINFO_FILENAME);
              $safeFilename = $slugger->slug($originalFilename);
              $newFilename = $safeFilename.'-'.uniqid().'.'.$produtoImg->guessExtension();

              try {
                  $produtoImg->move(
                      $this->getParameter('produtos_directory'),
                      $newFilename
                  );
              } catch (FileException $e) {
                  
              }
              $produto->setImagen($newFilename);
          }
          $em->persist($produto);
          $em->flush();
          
          $msg="Produto Cadastrado Com Sucesso";   
         }

        $data['Titulo'] = 'Adicionar Novos Produtos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('produto/cadastro.html.twig', $data);
      }

    /**
     * @Route("/produto/editar/{id}", name="produto_editar")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepo): Response
    {
        $msg ='';
        $produto = $produtoRepo->find($id);
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->flush();
          $msg="Produto Atualizado Com Sucesso";   
         }

        $data['Titulo'] = 'Editar Produtos';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('produto/cadastro.html.twig', $data);
      }

       /**
     * @Route("/produto/excluir/{id}", name="produto_excluir")
     * @IsGranted("ROLE_ADMIN")
     */
    public function excluir($id, EntityManagerInterface $em, ProdutoRepository $produtoRepo): Response
    {
        
        $produto = $produtoRepo->find($id);
        $em ->remove($produto);
        $em->flush();

        return $this->redirectToRoute('produto');

      }
}
