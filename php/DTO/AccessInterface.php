<?php

interface AccessInterface
{
    public function getAccessUrl(): string;

    public function getAccessData(): array;

    public function getAccessQrCode(): QrCodeObject;
}