<?php
namespace MiraCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateTest extends Command
{
    public function configure()
    {
        $this->setName("new:modeltest")
             ->setDescription('Make a new model test')
             ->addArgument('model', InputArgument::REQUIRED, "Model test name")
             ->addArgument('app', InputArgument::REQUIRED, "App where the model resides");
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $model = $input->getArgument('model');
        $app = $input->getArgument('app');

        $this->new($model, $app, $output);
    }

    public static function new($model, $app, OutputInterface $output)
    {
        if (!file_exists('tests/models/')) {
            mkdir('tests');
            mkdir('tests/models/');
        }
        $basedir = $_SERVER['DOCUMENT_ROOT'];
        if (file_exists('tests/models/'.ucwords($model).'Test.php')) {
            $output->writeln('Model Test already exists. Try renaming your model');
            return false;
        }
        $modelname = ucwords($model);
        $file = fopen('tests/models/'.$modelname.'Test.php', "w");
        $data = "<?php\n\n";
        $data .= "use App\\$app\\Models\\$modelname;\n\n";
        $data .= "use Mira\Testing\ModelTesting;\n";
        $data .= "class {$model}Test extends PHPUNIT_Framework_Testcase\n";
        $data .= "{\n\x20\x20\x20use ModelTesting;\n\x20\x20\x20public function __construct()\n\x20\x20\x20{\n\x20\x20\x20\x20\x20\x20".'$this->model = new '.$modelname."();\n\x20\x20\x20}\n}";
        fwrite($file, $data);
        fclose($file);

        $output->writeln("Model Created");
    }
}
