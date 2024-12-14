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
use JuliusStoerrle\KeycloakPhpSdk\Representation\User;

/**
 * @implements Operation<User>
 */
readonly class UserWithIdQuery implements Operation
{
    public const string URI_TEMPLATE = '/admin/realms/%s/users/%s';

    public function __construct(public string $id, public string $realm = '{defaultRealm}')
    {
    }

    #[\Override] public function method(): string
    {
        return 'GET';
    }

    #[\Override] public function uri(): string
    {
        return sprintf(self::URI_TEMPLATE, $this->realm, $this->id);
    }

    #[\Override] public function resultRepresentation(): string
    {
        return User::class;
    }
}
