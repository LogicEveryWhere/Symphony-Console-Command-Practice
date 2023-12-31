<?php

declare(strict_types=1);

namespace Console\App\Data;

use Console\App\Entities\Translation;

interface Persistence
{
    public function generateId(): int;

    public function persist(Translation $data);

    public function retrieve(int $id): Translation;

    public function delete(int $id);
}