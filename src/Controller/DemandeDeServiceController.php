<?php

namespace App\Controller;
//archive pour manipulation
use App\Entity\ArchiveService;
use App\Controller\ArchiveServiceController;

use App\Entity\DemandeDeService;
use App\Form\DemandeDeServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class DemandeDeServiceController extends AbstractController
{
    /**
     * @Route("/demande_service", name="demande_service", methods={"GET"})
     */

    public function demande_service(Request $request): Response 
    {
       $em = $this->getDoctrine()->getManager();
       $demandeDeServiceRepository = $em->getRepository(DemandeDeService::class);
       $demandeDeService =  $demandeDeServiceRepository->findAll();

       //Recherche des demandes de Services
       $nomService="";                             
       $requestParameters = $request->query->all();            
       $parameters=array_keys($requestParameters);

       if(!empty($parameters))
       {
           $nomService = $requestParameters['nom'];    
           $demandeDeService = $this->getDoctrine()->getRepository(DemandeDeService::class)->searchDemandeService($nomService); 
       }   

            return $this->render('demande_de_service/index.html.twig', [
            'controller_name' => 'DemandeDeServiceController', 
            'demande_service' =>  $demandeDeService,
            'message_bienvenue' => 'Voici la liste des demandes de services:' ,
            ]);
    }


    /**
    * @Route("/form_nouvelle_demande_de_service", name="form_nouvelle_demande_de_service", methods={"GET","POST"})
    */

    public function ajouter_nouvelle_demande_de_service_form(MailerInterface $mailer, Request $request): Response
    {
        $nouvelleDS = new DemandeDeService();


        $form = $this->createForm(DemandeDeServiceType::class, $nouvelleDS, ['action' => $this->generateUrl('form_nouvelle_demande_de_service'), 'method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
           $em = $this->getDoctrine()->getManager();
           $em->persist($nouvelleDS);
           $em->flush();
           // objet permettant d'envoyer un courriel après la création de la demande
            $email_admin = (new TemplatedEmail())
                ->from('markocegeptest@gmail.com')
                ->to('markocegeptest@gmail.com')
                ->subject('Nouvelle demande de service')
                ->htmlTemplate('emails/demande_de_service_admin.html.twig')
                ->context([
                    'mail' => $nouvelleDS->getCourriel(),
                    'description' => $nouvelleDS->getDescription(),
                    'nom' => $nouvelleDS->getNom(),
                    'prenom' => $nouvelleDS->getPrenom(),
                    'adresse' => $nouvelleDS->getAdresse(),
                    'telephone' => $nouvelleDS->getTelephone()
                ]);
            $email_client = (new TemplatedEmail())
                ->from('markocegeptest@gmail.com')
                ->to($nouvelleDS->getCourriel())
                ->subject('Turbo S - Confirmation de réception de demande de service')
                ->htmlTemplate('emails/demande_de_service_client.html.twig')
                ->context([
                    'description' => $nouvelleDS->getDescription(),
                    'adresse' => $nouvelleDS->getAdresse(),
                ]);
            $mailer->send($email_admin);
            $mailer->send($email_client);

           return $this->render('demande_de_service/confirmation.html.twig');
           

        }

        return $this->render('demande_de_service/new.html.twig', 
                            ['formulaire' => $form->createView()]);
    }

 
 
    /**
    * @Route("/form_edit_demande_de_service/{idDemandeService}", name="form_edit_demande_de_service", methods={"GET","POST"})
    */
    public function edit_demande_de_service(DemandeDeService $DemandeService, Request $request): Response
   {  
        
    
        $form = $this->createForm(DemandeDeServiceType::class, $DemandeService, ['method' => 'POST']);
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($DemandeService);
            $em->flush();

            return $this->render('demande_de_service/show.html.twig', [
                'demande_de_service' => $DemandeService,
            ]);
        }

        return $this->render('demande_de_service/edit.html.twig',
         
            ['formulaire' => $form->createView()]);
    } 


    /**
     * @Route("/show_demande_service/{idDemandeService}", name="show_demande_service", methods={"GET"})
     */
    public function show(DemandeDeService $DemandeService): Response
    {
        return $this->render('demande_de_service/show.html.twig', [
            'demande_de_service' => $DemandeService,
        ]);
    }


    /**
    * @Route("/form_delete_demande_service/{idDemandeService}", name="form_delete_demande_service", methods={"GET", "POST"})
    */
    public function delete(Request $request, DemandeDeService $demande_service): Response
    {
            //Efface la ligne dans la liste demande de service
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($demande_service);
            $entityManager->flush();

            $archiveService = new ArchiveService();
            $archiveService->setNom($demande_service->getNom());
            $archiveService->setPrenom($demande_service->getPrenom());
            $archiveService->setAdresse($demande_service->getAdresse());
            $archiveService->setTelephone($demande_service->getTelephone());
            $archiveService->setCourriel($demande_service->getCourriel());
            $archiveService->setDescription($demande_service->getDescription());
            $archiveService->setDateHeure(new \DateTime());
            $archiveService->setStatut($demande_service->getStatut());

            $archivecontroller = new ArchiveServiceController();

            //$archiveManager = $archivecontroller->getDoctrine()->getManager();

            // On enregistre dans archiveService
            $archivecontroller = $this->getDoctrine()->getManager();
            $archivecontroller->persist($archiveService);
            $archivecontroller->flush();



        return $this->redirectToRoute('demande_service', [], Response::HTTP_SEE_OTHER);
    }
    
}
