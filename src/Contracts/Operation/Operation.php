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

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation;

/**
 * @template R the result representation
 */
interface Operation
{
    public function method(): string;

    public function uri(): string;

    /**
     * @return class-string<R>
     */
    public function resultRepresentation(): string;
}
