<?php

namespace Console\Commands;

use MatthiasMullie\Minify\JS;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'build:js',
    description: 'Combine and minify JS scripts with "bin/console build:js" command',
    hidden: false,
    aliases: ['build:js']
)]
class BuildJsCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $sourceFiles = [
            'assets/js/ajax/question/admin-questions-ajax.js',
            'assets/js/ajax/game/answer-questions-ajax.js',
            'assets/js/ajax/score/user-score-ajax.js',
            'assets/js/scripts/components/category-filters.js',
            'assets/js/scripts/components/custom-select.js',
            'assets/js/scripts/utilities/text-truncate.js',
            'assets/js/scripts/templates/partials/navbar.js',
        ];
        
        $minifier = new JS();

        foreach ($sourceFiles as $file) {
            $minifier->addFile($file);
        }

        $minifier->minify('public/js/main.min.js');
        
        return Command::SUCCESS;
    }
}
