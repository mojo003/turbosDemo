<?php

namespace App\Command;

use App\Repository\DemandeDeServiceRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\Mailer;

class ServiceReminderCommand extends Command
{
    protected static $defaultName = 'Service:rappel-rappeler';

    /**
     * @var DemandeDeServiceRepository
     */
    private $demandeDeServiceRepository;
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(DemandeDeServiceRepository $demandeDeServiceRepository, Mailer $mailer)
    {
        parent::__construct(null);
        $this->demandeDeServiceRepository = $demandeDeServiceRepository;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this
            ->setDescription('Rappel pour les services');
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $demandesDeService = $this->demandeDeServiceRepository->returnOlderThan(10);
        $demandesDeServiceCount = count($demandesDeService);

        if (count($demandesDeService) === 0) {
            $io->error("Il n'y a pas de services en attente.");
            return -1;
        }

        $io->progressStart($demandesDeServiceCount);
        foreach ($demandesDeService as $demandeDeService) {
            $io->progressAdvance();
            $this->mailer->sendReminder($demandeDeService);
            }
        $io->progressFinish();
        $io->success("$demandesDeServiceCount rappels envoyés");

        return 0;
    }
}
