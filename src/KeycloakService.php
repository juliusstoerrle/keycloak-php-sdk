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

namespace JuliusStoerrle\KeycloakPhpSdk;

/**
 * Configuration for one Keycloak instance/cluster
 */
readonly class KeycloakService
{
    public function __construct(
        public string $baseUrl,
        public string $realm,
    ) {
    }
}
