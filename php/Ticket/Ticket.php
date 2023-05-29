<?php

class Ticket implements TicketInterface
{

    private PriceCalculatorInterface $priceCalculator;
    private bool $isAllDay;
    private bool $isOnline;
    private array $eventArray;
    private bool $isPayed = false;
    private float $price = 0;

    public function setPriceCalculator(PriceCalculatorInterface $priceCalculator): TicketInterface
    {
        $this->priceCalculator = $priceCalculator;
        return $this;
    }

    public function setAllDay(bool $isAllDay): TicketInterface
    {
        $this->isAllDay = $isAllDay;
        return $this;
    }

    public function setOnline(bool $isOnline): TicketInterface
    {
        $this->isOnline = $isOnline;
        return $this;
    }

    public function isAllDay(): bool
    {
        return $this->isAllDay;
    }

    public function isOnline(): bool
    {
        return $this->isOnline;
    }

    public function addEvent(EventInterface $event): TicketInterface
    {
        $this->eventArray[] = $event;
        return $this;
    }

    public function getEventArray(): array
    {
        return $this->eventArray;
    }

    public function getEventCount(): int
    {
        return count($this->eventArray);
    }

    public function markAsPayed(): TicketInterface
    {
        $this->isPayed = true;

        $access = AccessFactory::getAccessProvider();

        /** @var EventInterface $event */
        foreach ($this->eventArray as $event) {
            $event->setAccess($this->isAllDay ? $access : AccessFactory::getAccessProvider());
        }

        return $this;
    }

    public function isPayed(): bool
    {
        return $this->isPayed;
    }

    public function getPrice(): float
    {
        ! $this->isAllDay && $this->priceCalculator->setEventAmount(count($this->eventArray));
        $this->price = $this->priceCalculator->getPrice();
        return $this->price;
    }
}