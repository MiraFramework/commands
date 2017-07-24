<?php

namespace MiraCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateEvent extends Command
{
    public function configure()
    {
        $this->setName("new:event")
             ->setDescription('Make a new event')
             ->addArgument('event', InputArgument::REQUIRED, "Event Name");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $eventName = $input->getArgument('event');

        $this->new($eventName, $output);
    }

    private function new($eventName, OutputInterface $output)
    {
        if (file_exists("application/App/Providers/Events/$eventName.php")) {
            $output->writeln("Event already exists. Try renaming this event.");
            return false;
        }

        if (!file_exists("application/App/Providers/Events")) {
            mkdir("application/App/Providers/Events");
        }

        $output->writeln("Creating Event ... ");
        if (fopen("application/Providers/Events/$eventName.php", "a")) {
            $startevent = "<?php\n\n";
            $startevent .= "namespace Events;\n\n";
            $startevent .= "class $eventName\n";
            $startevent .= "{\n";
            $startevent .= "\x20\x20\x20\x20\x20 // Create a new event!\n";
            $startevent .= "}\n";
            file_put_contents("application/Providers/Events/$eventName.php", $startevent);
            $output->writeln("$eventName created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }
    }
}
