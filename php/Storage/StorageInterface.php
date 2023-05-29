<?php

interface StorageInterface
{
    public function put(TicketInterface $ticket): int;

    public function get(int $id): ?TicketInterface;

    public function update(int $id, TicketInterface $ticket);
}