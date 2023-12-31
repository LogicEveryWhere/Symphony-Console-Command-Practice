<?php

namespace Console\App\Entities;

class TranslationUnit
{
    public function __construct(
        public string $text,
        public string $lang
    ) {}
}
