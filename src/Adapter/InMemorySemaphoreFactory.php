<?php

declare(strict_types=1);

/*
 * This file is part of keycloak PHP SDK.
 *
 * (c) Julius Stoerrle <juliusstoerrle@gmx.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace JuliusStoerrle\KeycloakPhpSdk\Adapter;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\Semaphore;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\SemaphoreFactory;

class InMemorySemaphoreFactory implements SemaphoreFactory
{
    #[\Override] public function create(string $key, int $parallel): Semaphore
    {
        // TODO: Implement create() method.
    }

    #[\Override] public function createLock(string $key): Semaphore
    {
        // TODO: Implement createLock() method.
    }
}
