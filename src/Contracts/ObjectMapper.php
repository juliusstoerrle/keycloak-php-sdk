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
 * Object to hydrate responses into representation objects
 */
interface ObjectMapper
{
    /**
     * @template T
     * @param string $className<T>
     * @return T
     */
    public function hydrate(string $className, array $data): mixed;
}
