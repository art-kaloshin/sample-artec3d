<?php

interface TicketInterface
{
    public function setPriceCalculator(PriceCalculatorInterface $priceCalculator): self;

    public function setAllDay(bool $isAllDay): self;

    public function setOnline(bool $isOnline): self;

    public function isAllDay(): bool;

    public function isOnline(): bool;

    public function addEvent(EventInterface $event): self;

    public function getEventArray(): array;

    public function getEventCount(): int;

    public function markAsPayed(): self;

    public function isPayed(): bool;

    public function getPrice(): float;
}