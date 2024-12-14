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

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth;

/**
 * Configuration object to provide credentials to
 * authenticate this client against the keycloak API.
 *
 * This enables the SDK to implement different
 * authentication grants like client credentials with
 * shared secret or client certificate in an extensible
 * way.
 */
interface Credentials
{
    public function tokenRequestParameter(): array;

    public function refreshTokenRequestParameters(string $refreshToken): array;
}
