<?php

namespace Console\App\Commands;

use Console\App\Data\Storage;
use Console\App\Entities\Translation;
use Console\App\Entities\TranslationUnit;
use Console\App\OutputEnhancer;
use Console\App\Parser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class ParseCommand extends Command
{

    protected function configure(): void
    {
        $this->setName('parse')
            ->setDescription('This command can parse texts and allow you to translate to opposite language')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('html', InputArgument::REQUIRED, 'HTML piece that should be parsed')
            ->addArgument('lang', InputArgument::REQUIRED, 'Language iso code of HTML content');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        try {
            $lang = $input->getArgument('lang');
            if (!in_array($lang, Translation::ALLOWED_LANGUAGES)) {
                throw new \Exception('Language not supported');
            }
        } catch (\Exception $e) {
            throw new \Exception('Language ' . $lang . ' is not supported, please select one of suggested: ' . implode(', ', Translation::ALLOWED_LANGUAGES));
            return Command::FAILURE;
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $consoleOutput =  new OutputEnhancer($output);
        $html = $input->getArgument('html');
        $inputLang = $input->getArgument('lang');

        $consoleOutput->info(sprintf('HTML that You have provided %s', $html));
        $consoleOutput->info(sprintf('Selected language of origin, %s', $inputLang));
        $consoleOutput->separator();

        /** @var HelperInterface $helper */
        $helper = $this->getHelper('question');
        $availableLanguages = array_values(array_diff(Translation::ALLOWED_LANGUAGES, [$inputLang]));
        $langQuestion = new ChoiceQuestion(
            'Please select language for translation default is( ' . $availableLanguages[0] . ')',
            // choices can also be PHP objects that implement __toString() method
            $availableLanguages,
            0
        );
        $langQuestion->setAutocompleterValues($availableLanguages);
        $langQuestion->setErrorMessage('Selected lang %s is invalid.');


        try {
            $crawler = new Parser($html);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return Command::FAILURE;
        }

        $lang = $helper->ask($input, $output, $langQuestion);
        $consoleOutput->print('You have just selected:');
        $consoleOutput->info($lang);
        $consoleOutput->separator();

        $texts = $crawler->getTexts();
        $storage = new Storage();

        foreach ($texts as $text)
        {
            $wordQuestion = new Question('Please enter translation for ' . $text .': ');
            $originWord = new TranslationUnit($text, $inputLang);
            $word = $helper->ask($input, $output, $wordQuestion);
            $storage->persist(new Translation($originWord, $word, $lang));
            $consoleOutput->separator();
        }

        $progressBar = new ProgressBar($output, $storage->getCount());
            $consoleOutput->info('Pseudo saving and processing');
            $progressBar->start();
            if (is_array($texts) && count($texts))
            {
                foreach ($texts as $text)
                {
                    sleep(1);
                    $progressBar->advance();
                }
            }
            $progressBar->finish();

            $consoleOutput->printTranslations($storage->getAll(), $inputLang,  $lang);



        return Command::SUCCESS;
    }
}
