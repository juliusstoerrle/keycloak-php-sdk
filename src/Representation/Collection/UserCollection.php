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

namespace JuliusStoerrle\KeycloakPhpSdk\Representation\Collection;

use JuliusStoerrle\KeycloakPhpSdk\Representation\User;

/**
 * @implements Collection<User>
 */
final readonly class UserCollection extends Collection
{
    #[\Override] public static function containsObjectsOfType(): string
    {
        return User::class;
    }
}
