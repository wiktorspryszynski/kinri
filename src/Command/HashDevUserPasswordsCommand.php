<?php

namespace App\Command;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:hash-dev-passwords',
    description: 'Set all users\' password to "dev" (hashed). Dev only.',
)]
final class HashDevUserPasswordsCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $users = $this->userRepository->findAll();

        if ($users === []) {
            $io->warning('No users in database.');

            return Command::SUCCESS;
        }

        foreach ($users as $user) {
            $user->setPassword($this->passwordHasher->hashPassword($user, 'dev'));
        }

        $this->entityManager->flush();

        $io->success(sprintf('Hashed password "dev" for %d user(s).', count($users)));

        return Command::SUCCESS;
    }
}
