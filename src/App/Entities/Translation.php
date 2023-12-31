<?php 
namespace Console\App\Entities;

class Translation
{
    private array $translationPair = [];
    const ALLOWED_LANGUAGES =  ['en', 'uk', 'de', 'fr'];
    public function __construct(TranslationUnit $translation, string $word, string $lang) {
        $this->translationPair = [
            $translation->lang => $translation->text,
            $lang => $word
        ];
    }

    public function getTranslation() {
        return $this->translationPair;
    }
}