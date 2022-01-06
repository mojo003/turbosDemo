<?php

namespace App\Controller;

use App\Entity\ArchiveService;
use App\Form\ArchiveServiceType;
use App\Repository\ArchiveServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArchiveServiceController extends AbstractController
{
    /**
     * @Route("/archive_service", name="archive_service", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $archiveServiceRepository = $em->getRepository(ArchiveService::class);
        $archiveService =  $archiveServiceRepository->findAll();
 
        //Recherche Archives
        $nomArchives="";                             
        $requestParameters = $request->query->all();            
        $parameters=array_keys($requestParameters);
 
        if(!empty($parameters))
        {
            $nomArchives = $requestParameters['nom'];    
            $archiveService = $this->getDoctrine()->getRepository(ArchiveService::class)->searchArchiveEmploye($nomArchives); 
        }   

        return $this->render('archive_service/index.html.twig', [
        'controller_name' => 'archiveServiceController', 
        'archive_services' =>  $archiveService,
        'message_bienvenue' => 'Voici la liste de l\'archive de services:' ,
        ]);
    }

    /**
     * @Route("/new", name="archive_service_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $archiveService = new ArchiveService();
        $form = $this->createForm(ArchiveServiceType::class, $archiveService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($archiveService);
            $entityManager->flush();

            return $this->redirectToRoute('archive_service', [], Response::HTTP_SEE_OTHER);
        }

        //Recherche des archives
        $nomArchive="";                             
        $requestParameters = $request->query->all();            
        $parameters=array_keys($requestParameters);

        if(!empty($parameters))
        {
            $nomArchive = $requestParameters['nom'];    
            $archiveService = $this->getDoctrine()->getRepository(ArchiveService::class)->searchArchiveEmploye($nomArchive); 
        }   




        return $this->renderForm('archive_service/new.html.twig', [
            'archive_service' => $archiveService,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/archive_service/{id}", name="archive_service_show", methods={"GET"})
     */
    public function show(ArchiveService $archiveService): Response
    {
        return $this->render('archive_service/show.html.twig', [
            'archive_service' => $archiveService,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="archive_service_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArchiveService $archiveService): Response
    {
        $form = $this->createForm(ArchiveServiceType::class, $archiveService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('archive_service', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('archive_service/edit.html.twig', [
            'archive_service' => $archiveService,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/delete", name="archive_service_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, ArchiveService $archiveService): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($archiveService);
            $entityManager->flush();
    

        return $this->redirectToRoute('archive_service', [], Response::HTTP_SEE_OTHER);
    }

}
