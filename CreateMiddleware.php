<?php

namespace MiraCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateMiddleware extends Command
{
    public function configure()
    {
        $this->setName("new:middleware")
             ->setDescription('Make a new middleware')
             ->addArgument('middleware', InputArgument::REQUIRED, "Middleware Name");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $middlewareName = $input->getArgument('middleware');

        $this->new($middlewareName, $output);
    }

    private function new($middlewareName, OutputInterface $output)
    {
        if (file_exists("application/Middleware/$middlewareName.php")) {
            $output->writeln("Middleware already exists. Try renaming this middleware.");
            return false;
        }
        $output->writeln("Creating Middleware ... ");
        if (fopen("application/Middleware/$middlewareName.php", "a")) {
            $startmiddleware = "<?php\n\n";
            $startmiddleware .= "namespace Middleware;\n\n";
            $startmiddleware .= "class $middlewareName\n";
            $startmiddleware .= "{\n";
            $startmiddleware .= "\x20\x20\x20\x20\x20 // Create a new Middleware!\n";
            $startmiddleware .= "}\n";
            file_put_contents("application/Middleware/$middlewareName.php", $startmiddleware);
            $output->writeln("$middlewareName created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }
    }
}
