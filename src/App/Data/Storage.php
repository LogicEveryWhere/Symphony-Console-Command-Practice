<?php 
namespace Console\App\Data;

use Console\App\Entities\Translation;
use Exception;

class Storage implements Persistence {
    private array $data = [];
    private int $lastId = 0;

    public function generateId(): int
    {
        $this->lastId++;

        return $this->lastId;
    }

    public function persist(Translation $data)
    {
        $this->data[$this->lastId] = $data;
    }

    public function retrieve(int $id): Translation
    {
        if (!isset($this->data[$id])) {
            throw new Exception(sprintf('No data found for ID %d', $id));
        }

        return $this->data[$id];
    }

    public function delete(int $id)
    {
        if (!isset($this->data[$id])) {
            throw new Exception(sprintf('No data found for ID %d', $id));
        }

        unset($this->data[$id]);
    }

    public function getAll() {
        return $this->data;
    }

    public function getCount(): int {
        return count($this->data);
    }
}