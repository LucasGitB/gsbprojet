<?php
namespace App\Command;
 
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
 
use App\Entity\Users;
 
class AdduserCommand extends Command {
 
    private $container;
    private $passwordEncoder;
 
    public function __construct(Container $container, UserPasswordHasherInterface $passwordEncoder, bool $requirePassword = false) {
        $this->container = $container;
        $this->passwordEncoder = $passwordEncoder;
        $this->requirePassword = $requirePassword;
        parent::__construct();
    }
 

    protected function configure()
    {
        $this
            ->setName('gsb:add:user')
            ->setDescription('Create gsb user');
        $this
                ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
                ->addArgument('nom', InputArgument::REQUIRED, 'Nom of the user.')
                ->addArgument('prenom', InputArgument::REQUIRED, 'Name of the user.')
                ->addArgument('password', $this->requirePassword ? InputArgument::REQUIRED : InputArgument::OPTIONAL, 'User password')
                ;
 
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
 
        $em = $this->container->get('doctrine')->getManager();

        $user = new Users();
        $user->setEmail($input->getArgument('email'));
        $user->setNom($input->getArgument('nom'));
        $user->setPrenom($input->getArgument('prenom'));
        $user->setRoles(array('ROLE_USER'));
        if(is_null($input->getArgument('password'))) {
            $random_password = base64_encode(uniqid().time());
            $output->writeln($random_password);
            $encPassword = $this->passwordEncoder->hashPassword(
                $user,
                $random_password
            );
        } else {
            $encPassword = $this->passwordEncoder->hashPassword(
                $user,
                $input->getArgument('password')
            );
        }

        $user->setPassword($encPassword);

        $em->persist($user);
        $em->flush();

        return Command::SUCCESS;
    }
 
}