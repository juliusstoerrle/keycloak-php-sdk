<?php

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts;

interface SemaphoreFactory
{
    public function create(string $key, int $parallel): Semaphore;

    public function createLock(string $key): Semaphore;
}
