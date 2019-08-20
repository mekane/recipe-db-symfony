<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\DependencyInjection\ContainerInterface;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MakeUserCommand extends Command
{
    protected static $defaultName = 'app:make-user';

    private $container;
    private $passwordEncoder;

    public function __construct(ContainerInterface $container, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->container = $container;
        $this->passwordEncoder = $userPasswordEncoder;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Makes a default admin user for the recipe db system');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $newUser = new User();
        $newUser->setEmail('admin@localhost');
        $newUser->setPassword($this->passwordEncoder->encodePassword($newUser, 'changeme'));
        $newUser->setRoles(['ROLE_USER', 'ROLE_ADMIN']);


        //$entityManager = $this->getDoctrine()->getManager();
        $em = $this->container->get('doctrine')->getManager();
        $em->persist($newUser);
        $em->flush();

        //$arg1 = $input->getArgument('arg1');

        //if ($arg1) {
        //    $io->note(sprintf('You passed an argument: %s', $arg1));
        //}

        //if ($input->getOption('option1')) {

        $io->success('New user admin@localhost created');
    }
}
