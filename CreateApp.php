<?php

namespace MiraCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateApp extends Command
{
    public function configure()
    {
        $this->setName("new:app")
             ->setDescription('Make a new app')
             ->addArgument('app', InputArgument::REQUIRED, "Model Name");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $app= $input->getArgument('app');

        $this->new($app, $output);
    }

    public static function new($app, OutputInterface $output)
    {
        $created = true;

        if (file_exists("application/App/$app")) {
            $output->writeln("App already exists. Please rename your app.");
            return false;
        }
        $output->writeln("Creating app folder ... ");
        if (mkdir("application/App/$app")) {
            $output->writeln("created successfully!\n");
        } else {
            echo "failed\n";
            $created = false;
        }

        $output->writeln("Creating app config file ... ");
        // Create config file

        $configfile = "<?php\n\n";
        $configfile .= "return [\n";
        $configfile .= "\x20\x20\x20\x20\x20//'header' => '$app.header',\n";
        $configfile .= "\x20\x20\x20\x20\x20//'footer' => '$app.footer',\n";
        $configfile .= "];\n";
        if (file_put_contents("application/App/$app/config.php", $configfile)) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        // Create templates folder
        $output->writeln("Creating app template folder ... ");
        if (mkdir("application/App/$app/templates")) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }
        
        // Create resources folder
        $output->writeln("Creating app images folder ... ");
        if (mkdir("application/App/$app/images")) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        // Create resources folder
        $output->writeln("Creating app js folder ... ");
        if (mkdir("application/App/$app/js")) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        // Create css folder
        $output->writeln("Creating app css folder ... ");
        if (mkdir("application/App/$app/css")) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }


        
        $output->writeln("Creating app routes folder ... ");
        if (mkdir("application/App/$app/Routes")) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        $output->writeln("Creating app routes/routes.php file ... ");
        if (fopen("application/App/$app/Routes/Routes.php", "a")) {
            $startroute = "<?php\n\n";
            $startroute .= "use Mira\Route;\n";
            $startroute .= "use Mira\Render\Render;\n\n";
            $startroute .= "// Routes Here\n";
            file_put_contents("application/App/$app/Routes/Routes.php", $startroute);
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        $output->writeln("Creating app controller folder ... ");
        if (mkdir("application/App/$app/Controller")) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        $output->writeln("Creating app controller/controller.php file ... ");
        if (fopen("application/App/$app/Controller/Controller.php", "a")) {
            $startcontroller = "<?php\n\n";
            $startcontroller .= "use Mira\Controller\Controller;\n\n";
            $startcontroller .= "// Controllers Here\n";
            file_put_contents("application/App/$app/Controller/Controller.php", $startcontroller);
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        $output->writeln("Creating app model folder ... ");
        if (mkdir("application/App/$app/Models")) {
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed");
            $created = false;
        }

        $output->writeln("Creating app models/models.php file ... ");
        if (fopen("application/App/$app/Models/StarterModel.php", "w")) {
            $startmodel = "<?php\n\n";
            $startmodel .= "namespace App\\$app\Models;\n\n";
            $startmodel .= "use Mira\Models\Model;\n\n";
            $startmodel .= "// Models Here\n";
            file_put_contents("application/App/$app/Models/StarterModel.php", $startmodel);
            $output->writeln("created successfully!\n");
        } else {
            $output->writeln("failed!");
            $created = false;
        }

        if ($created) {
            $output->writeln("App Successfully Created!");
        } else {
            $output->writeln("App could not be  created ...");
        }
    }
}
