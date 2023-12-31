<?php

namespace Console\App;

use Symfony\Component\Console\Output\OutputInterface;

class OutputEnhancer
{

    public function __construct(private OutputInterface $output){}
    public function print($text): void
    {
        $this->output->writeln($text);
    }
    public function info($text): void
    {
        $this->output->writeln('<info>' . $text . '</>');
    }

    public function separator(): void
    {
        $this->output->writeln('<info>' . str_repeat('=', 50) . '</>');
    }
}
