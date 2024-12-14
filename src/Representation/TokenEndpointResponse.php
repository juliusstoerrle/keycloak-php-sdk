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

namespace JuliusStoerrle\KeycloakPhpSdk\Representation;

readonly class TokenEndpointResponse
{
    public function __construct(
        #[\SensitiveParameter]
        public string $access_token,
        #[\SensitiveParameter]
        public string|null $refresh_token,
    ) {
    }
}
