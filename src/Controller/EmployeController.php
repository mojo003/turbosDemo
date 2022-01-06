<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employe;
use App\Form\EmployeType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;




class EmployeController extends AbstractController
{

    /**
     * @Route("/liste_employes", name="liste_employes")
     */

    public function liste_employes(Request $request): Response 
    {
        $em = $this->getDoctrine()->getManager();
        $employeRepository = $em->getRepository(Employe::class);
        $listeEmployes = $employeRepository->findAll();

        //Recherche des employés
        $nomEmploye="";                             
        $requestParameters = $request->query->all();            
        $parameters=array_keys($requestParameters);

        if(!empty($parameters))
        {
            $nomEmploye = $requestParameters['nom'];    
            $listeEmployes = $this->getDoctrine()->getRepository(Employe::class)->searchEmploye($nomEmploye); 
        }   


            return $this->render('employe/index.html.twig', [
                'controller_name' => 'EmployeController', 
                'liste_employes' => $listeEmployes,
                'message_bienvenue' => 'Voici la liste des employés:' ,
            ]);
            
    }

      

    /**
    * @Route("/form_nouvel_employe", name="form_nouvel_employe")
    */

    public function ajouter_employe_form(Request $request): Response
    {
        $nouvelEmploye = new Employe();


        $form = $this->createForm(EmployeType::class, $nouvelEmploye, ['action' => $this->generateUrl('form_nouvel_employe'), 'method' => 'POST']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
           $em = $this->getDoctrine()->getManager();
           $em->persist($nouvelEmploye);
           $em->flush();
           return $this->redirectToRoute('app_register', ['courriel'=>$request->request->get('employe')['courriel']]);
        }


        return $this->render('employe/new.html.twig', 
                            ['formulaire' => $form->createView()]);
    }



    /**
    * @Route("/form_edit_employe/{idEmploye}", name="form_edit_employe")
    */
    public function edit_employe(Employe $Employe, Request $request): Response
   {  
       
        $form = $this->createForm(EmployeType::class, $Employe, [ 'method' => 'POST']);
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($Employe);
            $em->flush();

            return new Response("Employé modifié dans la BD");
        }

            return $this->render('employe/edit.html.twig',
         
            ['formulaire' => $form->createView(), 'employe' => $Employe]);
    }

    

    /**
     * @Route("/show_employe/{idEmploye}", name="show_employe")
     */
    public function show(Employe $Employe): Response
    {
        return $this->render('employe/show.html.twig', [
            'employe' => $Employe,
        ]);
    }


    
    /**
    * @Route("/form_delete_employe/{idEmploye}", name="form_delete_employe")
    */
    public function delete(Employe $Employe, Request $request): Response

    {
    
        if ($this->isCsrfTokenValid('delete'.$Employe->getIdEmploye(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($Employe);
            $entityManager->flush();
        }

        return new Response("Employé supprimer de la BD");
       
    }
    
}
