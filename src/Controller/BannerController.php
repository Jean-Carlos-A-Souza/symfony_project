<?php

namespace App\Controller;

use App\Entity\Banner;
use App\Form\BannerType;
use App\Repository\BannerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class BannerController extends AbstractController
{
    #[Route('/banner', name: 'banner')]
    /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function index( BannerRepository $bannerRepo, PaginatorInterface $paginator, Request $request): Response
    {   

      $pagination= $data['banners']=$bannerRepo->findAll();

       $pagination = $paginator->paginate(
        $pagination,
        $request->query->getInt('page', 1), /*page number*/
        10 /*limit per page*/
    );

      return $this->render('banner/index.html.twig',['pagination' => $pagination]);
    }

    #[Route('/banner/adicionar', name: 'banner_adicionar')]
      /**
    * @IsGranted("ROLE_ADMIN")
    */
    public function adicionar(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $msg ='';
        $banner = new Banner();
        $form = $this->createForm(BannerType::class, $banner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

        
            $bannerImg = $form->get('imagen')->getData();
            if ($bannerImg) {
                $originalFilename = pathinfo($bannerImg->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$bannerImg->guessExtension();
  
                try {
                    $bannerImg->move(
                        $this->getParameter('banners_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    
                }
                $banner->setImagen($newFilename);
            }

          $em->persist($banner);
          $em->flush();
          
          $msg="Banner Cadastrado Com Sucesso";   
         }

        $data['Titulo'] = 'Adicionar Novos Banners';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('banner/cadastro.html.twig', $data);
      }

    /**
     * @Route("/banner/editar/{id}", name="banner_editar")
    * @IsGranted("ROLE_ADMIN") 
     */
    public function editar($id, Request $request, EntityManagerInterface $em, BannerRepository $bannerRepo): Response
    {
        $msg ='';
        $banner = $bannerRepo->find($id);
        $form = $this->createForm(BannerType::class, $banner);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em->flush();
          $msg="Banner Atualizado Com Sucesso";   
         }

        $data['Titulo'] = 'Editar Banners';
        $data['form'] = $form;
        $data['msg'] = $msg;

        return $this->renderForm('banner/cadastro.html.twig', $data);
      }

       /**
     * @Route("/banner/excluir/{id}", name="banner_excluir")
    * @IsGranted("ROLE_ADMIN")
     */
    public function excluir($id, EntityManagerInterface $em, BannerRepository $bannerRepo): Response
    {
        
        $banner = $bannerRepo->find($id);
        $em ->remove($banner);
        $em->flush();

        return $this->redirectToRoute('banner');

      }
}
