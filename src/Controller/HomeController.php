<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Service;
use App\Entity\Image;

class HomeController extends AbstractController
{
      /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

      /**
     * @Route("/home_employes", name="home_employes")
     */
    public function index_employes(): Response
    {

       return $this->render('home/home_employes.html.twig' , [
        'controller_name' => 'HomeController',
       ]);
    }

     /**
     * @Route("/home_services", name="home_services")
     */
    public function index_services(): Response
    {      $em = $this->getDoctrine()->getManager();
        $imageRepository = $em->getRepository(Image::class);
        $galerieImages = $imageRepository->findAll();

       return $this->render('home/home_services.html.twig' , [
        'controller_name' => 'HomeController',
        'galerie_images' => $galerieImages,
       ]);
    }
    
    /**
     * @Route("/promotion_gestion", name="promotion_gestion")
     */
    public function promotion(): Response
    {   
       return $this->render('promotion/promotion.html.twig' , [
        'controller_name' => 'promotion_gestion',

       ]);
    }
}
