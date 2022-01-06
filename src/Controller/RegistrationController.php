<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Entity\Employe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(MailerInterface $mailer, Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {   
        $user = new User();
            if (!empty($email=$request->query->get('courriel'))) {
                $user->setEmail($email);
            }
        $id_employe = $this->getDoctrine()->getRepository(Employe::class)
        ->findOneBy(['courriel'=>$email]);
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setIdEmploye($id_employe);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // objet permettant d'envoyer un courriel de bienvenue à l'adresse utilisée pour créer un utilisateur
            $email = (new TemplatedEmail())
                ->from('markocegeptest@gmail.com')
                ->to($user->getEmail())
                ->subject('Bienvenue sur la plateforme Turbo S!')
                ->htmlTemplate('emails/creation_employe.html.twig')
                ->context([
                    'mail' => $user->getEmail(),
                    'password' => $form->get('plainPassword')->getData()
                ]);
            $mailer->send($email);
            return $this->render('registration/confirmation.html.twig');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
