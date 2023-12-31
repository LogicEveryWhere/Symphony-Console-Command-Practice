<?php

namespace Console\App;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Console\Command\Command;

class Parser
{
    protected $allowed_tags = [
        "p", "h1", "h2", "h3", "h4", "h5", "h6", "span", "a",
        "strong", "em", "blockquote", "pre", "cite", "code", "abbr",
        "label", "li", "figcaption", "summary", "button", "time", "q",
        "del", "ins", "sub", "sup", "dfn", "var", "kbd", "samp", "text", "div"
    ];

    private array $parsed_texts = [];

    function __construct(string $html)
    {
        $this->parse($html);
    }

    private function parse(string $html)
    {
        try {
            $domDocument = new Crawler($html);
            $array[] = [];

            foreach ($this->allowed_tags as $allowed_tag) {
                $filter = $domDocument->filter($allowed_tag);
                if($filter->count()) {
                    $this->parsed_texts = array_merge($this->parsed_texts, $filter->each(function (Crawler $node, $i): string {
                        return $node->text();
                    }));
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Cant\'t parse provided param as html');
        }
    }
    public function getTexts(): array
    {
        return $this->parsed_texts;
    }
}
