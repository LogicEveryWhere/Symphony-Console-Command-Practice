<?php

namespace Console\App;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Console\App\Entities\Translation;

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

    public function printTranslations(array $data, $originLang, $translationLang): void {
        $this->output->writeln(PHP_EOL);
        $table = new Table($this->output);
        $prepared_data = [];
        /** @var Translation $translation */
        foreach ($data as $translation) {
            $translation = $translation->getTranslation();
            $prepared_data[] = [
                $translation[$originLang],
                $translation[$translationLang],
            ];
        }

        $table
            ->setHeaders(['Origin word('. $originLang .')', 'Translation ('. $translationLang . ')'])
            ->setRows($prepared_data);
        $table->render();
    }
}
