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

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts;

/**
 * Semaphore abstraction to restrict the number of parallel requests.
 */
interface Semaphore
{
    public function acquire(): bool;

    public function release(): void;
}
