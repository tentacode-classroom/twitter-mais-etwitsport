<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class Install2Command extends Command
{
    protected static $defaultName = 'app:install2';

    protected function configure()
    {
        $this
            ->setName('app:install2')
            ->setDescription('Command to install the project')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Installation of the project');
        $io->progressStart(6);


        $io->title('Installation of the project');
        $io->progressAdvance();
        $io->newLine(4);

        $io->section('Launch MySQL server');
        $process = new Process('sudo service mysql start');
        $process->setTimeout(300);
        $process->mustRun(function ($type, $buffer) use ($io, $output) {
            $output->writeln('> '.$buffer);
        });


            $io->newLine(20);



        $io->title('Installation of the project');
        $io->progressAdvance();
        $io->newLine(4);

        $io->section('Create DataBase');
        $process = new Process('bin/console doctrine:database:create --if-not-exists');
        $process->setTimeout(300);
        $process->mustRun(function ($type, $buffer) use ($io, $output) {
            $output->writeln('> '.$buffer);
        });


        $io->newLine(20);



        $io->title('Installation of the project');
        $io->progressAdvance();
        $io->newLine(4);

        $io->section('Init DataBase');
        $process = new Process('bin/console doctrine:migration:migrate');
        $process->setTimeout(300);
        $process->mustRun(function ($type, $buffer) use ($io, $output) {
            $output->writeln('> '.$buffer);
        });


        $io->newLine(20);

        $io->title('Installation of the project');
        $io->progressAdvance();
        $io->newLine(4);

        $io->section('Fixtures');
        $process = new Process('php bin/console doctrine:fixtures:load');
        $process->setTimeout(300);
        $process->mustRun(function ($type, $buffer) use ($io, $output) {
            $output->writeln('> '.$buffer);
        });


        $io->newLine(20);

        $io->title('Installation of the project');
        $io->progressAdvance();
        $io->newLine(4);

        $io->section('Run the server');
        $process = new Process('php bin/console server:start');
        // $process->setTimeout(300);
        $process->mustRun(function ($type, $buffer) use ($io, $output) {
            $output->writeln('> '.$buffer);
        });


        $io->newLine(20);



        $io->title('Installation of the project');
            $io->progressFinish();
        $io->newLine(20);

        $io->newLine(2);
        $io->success('Yeah ! The project is installed ! You can check it out in your favourite web browser :D');
    }
}
