<?php

namespace App\Service;

use App\Entity\DemandeDeService;
use App\Repository\DemandeDeServiceRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    private $mailer;
    /**
     * @var DemandeDeServiceRepository
     */
    private $demandeDeServiceRepository;

    public function __construct(MailerInterface $mailer, DemandeDeServiceRepository $demandeDeServiceRepository)
    {
        $this->mailer = $mailer;
        $this->demandeDeServiceRepository = $demandeDeServiceRepository;
    }

    public function sendReminder(DemandeDeService $demandeDeService)
    {

        $message = (new  TemplatedEmail())
            ->from( 'markocegeptest@gmail.com')
            ->to('markocegeptest@gmail.com')
            ->subject('Rappel de service à effectuer dans 2 jours')
            ->htmlTemplate('emails/rappel_service.html.twig')
            ->context([
                'prenom' => $demandeDeService->getPrenom(),
                'nom' => $demandeDeService->getNom(),
                'description' => $demandeDeService->getDescription(),
                'adresse' => $demandeDeService->getAdresse(),
                'telephone' => $demandeDeService->getTelephone()
            ]);
        ;

        $this->mailer->send($message);
    }
}