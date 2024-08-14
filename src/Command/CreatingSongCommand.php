<?php

namespace App\Command;

use App\Client\SunoClient;
use App\SongGeneratorDto;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:creating-song',
    description: 'create a song',
)]
class CreatingSongCommand extends Command
{
    public function __construct(
        private SunoClient $client,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('prompt', InputArgument::OPTIONAL, 'song description')
            ->addOption('instrumental', 'i', InputOption::VALUE_NONE, 'Is instrumental')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $prompt = $input->getArgument('prompt');

        $songGeneratorDto = new SongGeneratorDto(prompt: $prompt, gptDescriptionPrompt: $prompt, makeInstrumental: (bool) $input->getOption('instrumental'));
        dd($this->client->generate($songGeneratorDto));

        $io->success('Song generated');

        return Command::SUCCESS;
    }
}
