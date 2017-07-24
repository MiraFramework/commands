<?php

namespace MiraCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class InstallApp extends Command
{
    public function configure()
    {
        $this->setName("new:install")
             ->setDescription('Install an app from github')
             ->addArgument('github', InputArgument::REQUIRED, "Github account e.x: account/repo");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $github = $input->getArgument('github');

        $this->new($github, $output);
    }

    public static function new($github, OutputInterface $output)
    {
        $created = true;
        $github = explode("/", $github);

        $github_account = $github[0];
        $github_repo = ucwords($github[1]);

        $github_url = "https://github.com/$github_account/$github_repo.git";

        exec("cd application/App && git clone $github_url $github_repo");

        if ($created) {
            $output->writeln("App Successfully Created!");
        } else {
            $output->writeln("App could not be  created ...");
        }
    }
}
