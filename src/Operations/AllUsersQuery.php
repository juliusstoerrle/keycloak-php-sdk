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

namespace JuliusStoerrle\KeycloakPhpSdk\Operations;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\Operation;
use JuliusStoerrle\KeycloakPhpSdk\Representation\Collection\UserCollection;

/**
 * @implements Operation<UserCollection>
 */
readonly class AllUsersQuery implements Operation
{
    public function __construct(public string $realm = '{defaultRealm}')
    {
    }

    #[\Override] public function method(): string
    {
        return 'GET';
    }

    #[\Override] public function uri(): string
    {
        return sprintf('/admin/realms/%s/users', $this->realm);
    }

    #[\Override] public function resultRepresentation(): string
    {
        return UserCollection::class;
    }
}
