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
use JuliusStoerrle\KeycloakPhpSdk\Representation\ServerInfo;

/**
 * @implements Operation<ServerInfo>
 */
readonly class ServerInfoQuery implements Operation
{
    #[\Override] public function method(): string
    {
        return 'GET';
    }

    #[\Override] public function uri(): string
    {
        return '/admin/serverinfo';
    }

    #[\Override] public function resultRepresentation(): string
    {
        return ServerInfo::class;
    }
}
