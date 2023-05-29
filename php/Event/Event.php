<?php

class Event implements EventInterface
{

    private string $title;
    private AccessInterface $access;
    private string $description;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): EventInterface
    {
        $this->title = $title;
        return $this;
    }

    public function getAccess(): AccessInterface
    {
        return $this->access;
    }

    public function setAccess(AccessInterface $access): EventInterface
    {
        $this->access = $access;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): EventInterface
    {
        $this->description = $description;
        return $this;
    }
}