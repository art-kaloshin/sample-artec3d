<?php

class AccessFactory
{
    public static function getAccessProvider(): AccessInterface
    {
        return new Access();
    }
}