<?php

interface EventInterface
{
    public function setTitle(string $title): self;

    public function getTitle(): string;

    public function setDescription(string $description): self;

    public function getDescription(): string;

    public function setAccess(AccessInterface $access): self;

    public function getAccess(): AccessInterface;
}