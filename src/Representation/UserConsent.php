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

readonly class UserConsent
{
    public function __construct(
        public ?string $clientId = null,
        public ?int $createdDate = null,
        /** @var string[]|null */
        public ?array $grantedClientScopes = null,
        public ?int $lastUpdatedDate = null,
    ) {
    }
}
