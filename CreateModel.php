<?php

namespace MiraCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateModel extends Command
{
    public function configure()
    {
        $this->setName("new:model")
             ->setDescription('Make a new model')
             ->addArgument('model', InputArgument::REQUIRED, "Model Name")
             ->addArgument('app', InputArgument::REQUIRED, "Model Name");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $model = $input->getArgument('model');
        $app= $input->getArgument('app');

        $this->new($model, $app, $output);
    }

    public static function new($model, $app, OutputInterface $output)
    {
        $basedir = $_SERVER['DOCUMENT_ROOT'];
        if (file_exists('application/App/'.$app.'/Models/'.$model.'.php')) {
            $output->writeln('Model already exists. Try renaming you model');
            return false;
        }
        $file = fopen('application/App/'.$app.'/Models/'.$model.'.php', "w");
        $data = "<?php\n\n";
        $data .= "namespace App\\$app\\Models;\n\n";
        $data .= "class $model extends Model\n";
        $data .= "{\n\x20\x20\x20\x20\x20// A Model for the $app App\n}\n";
        fwrite($file, $data);
        fclose($file);

        $output->writeln("Model Created");
    }
}
