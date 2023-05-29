<?php

/**
 * всё, что здесь есть это некие заглушки методов
 * при их использовании логика работать не будет
 */
class Request
{
    public function isGetMethod(): bool
    {
        return true;
    }

    public function isPostMethod(): bool
    {
        return true;
    }

    public function isPutMethod(): bool
    {
        return true;
    }

    public function getRequestData(): array
    {
        return [
            'ticket' => $this->getTickerArray(),
        ];
    }

    public function getTickerArray(): array
    {
        return [
            'isOnline' => true,
            'isAllDay' => true,
            'eventArray' => $this->getEventArray(),
        ];
    }

    public function getEventArray(): array
    {
        return [
            [
                'title' => 'Title 1',
                'author' => 'Author 1',
            ],
            [
                'title' => 'Title 2',
                'author' => 'Author 2',
            ],
            [
                'title' => 'Title 3',
                'author' => 'Author 3',
            ],
        ];
    }

    public function getTicketId(): int
    {
        return time();
    }
}