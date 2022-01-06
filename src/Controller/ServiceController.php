<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Form\SearchInfoType;
use App\Repository\ServiceRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ServiceController extends AbstractController
{
   /**
     * @Route("/liste_services", name="liste_services")
     */
    public function liste_services(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $serviceRepository = $em->getRepository(Service::class);
        $listeServices = $serviceRepository->findAll();

        //Pour la recherche de services
        $mots="";                             
        $requestParameters = $request->query->all();            
        $parameters=array_keys($requestParameters);

        if(!empty($parameters))
        {
            $mots = $requestParameters['mots'];       
            $listeServices = $this->getDoctrine()->getRepository(Service::class)->searchService($mots);
            //unset ($request);
        }   

            return $this->render('service/index.html.twig', [
                'controller_name' => 'ServiceController', 
                'liste_services' => $listeServices,
                'message_bienvenue' => 'Voici la liste des services:' ,
                ]);
                
    }


    
    /**
    * @Route("/form_service", name="form_service")
    */

    public function new_service_form(Request $request): Response
    {
        $nouveauService = new Service();


        $form = $this->createForm(ServiceType::class, $nouveauService, ['action' => $this->generateUrl('form_service'), 'method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
           $em = $this->getDoctrine()->getManager();
           $em->persist($nouveauService);
           $em->flush();

           # return new Response("Nouveau service enregistré dans la BD")
        }

        return $this->render('service/new.html.twig', 
        ['formulaire' => $form->createView()]);
   }
        

      
    

  

   /**
    * @Route("/form_edit_service", name="form_edit_service")
    */
    public function edit_service(Request $request): Response
   {  
        $editService = new Service();
    
        $form = $this->createForm(ServiceType::class, $editService, ['action' => $this->generateUrl('form_edit_service'), 'method' => 'POST']);
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($editService);
            $em->flush();

            return new Response("Service modifié dans la BD");
        }

        return $this->render('service/edit.html.twig',
         
            ['formulaire' => $form->createView()]);
    }


  /**
     * @Route("/show_service", name="show_service")
     */
    public function show(Service $Service): Response
    {
        return $this->render('service/show.html.twig', [
            'show_service' => $Service,
        ]);
    }




  /**
    * @Route("/form_delete_service/{idService}", name="form_delete_service")
    */
    public function delete(Service $Service, Request $request): Response

    {
    
        if ($this->isCsrfTokenValid('delete'.$Service->getIdService(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Service);
            $entityManager->flush();
        }

        return new Response("Service supprimer de la BD");
       
    }


 
}

