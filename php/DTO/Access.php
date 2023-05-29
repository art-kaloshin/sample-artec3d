<?php

class Access implements AccessInterface
{

    private array $data = [];

    public function __construct()
    {
        $this->data = [
            'url' => 'DUMMY_URL',
            'accessData' => ['TicketValidationData'],
        ];
    }

    public function getAccessUrl(): string
    {
        return $this->data['url'];
    }

    public function getAccessData(): array
    {
        return $this->data['accessData'];
    }

    public function getAccessQrCode(): QrCodeObject
    {
        return new QrCodeObject();
    }
}