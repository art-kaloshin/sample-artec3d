<?php

class MemoryStorage implements StorageInterface
{

    private array $storage = [];

    public function put(TicketInterface $ticket): int
    {
        $id = time();
        $this->storage[$id] = $ticket;
        return $id;
    }

    public function get(int $id): ?TicketInterface
    {
        return $this->storage[$id] ?? null;
    }

    public function update(int $id, TicketInterface $ticket): bool
    {
        if (! isset($this->storage[$id])) {
            return false;
        }

        $this->storage[$id] = $ticket;
        return true;
    }
}