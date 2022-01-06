<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\Image1Type;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ImageController extends AbstractController
{
    /**
     * @Route("/image_index", name="image_index", methods={"GET"})
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $imageRepository = $em->getRepository(Image::class);
        $image =  $imageRepository->findAll();

        return $this->render('image/index.html.twig', [
            'controller_name' => 'imageController',
            'images' => $image,
        ]);
    }

    /**
     * @Route("/image_new", name="image_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {   
        $image = new Image();
        $form = $this->createForm(Image1Type::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            //récupération d'images
            $uploads = $form->get('img')->getData(); 
            foreach ($uploads as $upload) { 
            $fichier = md5(uniqid()) . '.' . $upload->guessExtension();
            $upload->move(
                $this->getParameter('images_directory'),
                $fichier
            );
            $temp_image = new Image();
            $temp_image->setImg("/images/".$fichier);
            $temp_image->setDescription($image->getDescription());
            $temp_image->setCaption($image->getCaption());
            $entityManager->persist($temp_image);
            }
            $entityManager->flush();

            return $this->redirectToRoute('image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/image_index/{idImage}", name="image_show", methods={"GET"})
     */
    public function show(Image $image): Response
    {
        return $this->render('image/show.html.twig', [
            'image' => $image,
        ]);
    }

    /**
     * @Route("/{idImage}/edit", name="image_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Image $image): Response
    {
        $form = $this->createForm(Image1Type::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('image_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('image/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/image_index/{idImage}", name="image_delete", methods={"POST"})
     */
    public function delete(Request $request, Image $image): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getIdImage(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_index', [], Response::HTTP_SEE_OTHER);
       // return new Response("Image supprimer de la BD");
    }
}
