<?php
/**
 * Created by PhpStorm.
 * User: digital
 * Date: 19/03/2018
 * Time: 16:04
 */

namespace AppBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserCommand extends Command
{
    protected  static  $defaultName = 'app:create-user';

    protected function configure()
    {
        $this->setDescription('Create User')
            ->addArgument('email', InputArgument::REQUIRED, 'EMAIL')
            ->addArgument('password',InputArgument::REQUIRED,'password');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $output->writeln(sprintf('<info>Email: %s, Password: %s </info>',$email, $password));
    }
}