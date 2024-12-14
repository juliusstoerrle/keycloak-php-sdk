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

readonly class ProfileInfo
{
    public function __construct(
        /** @var string[]|null */
        public ?array $disabledFeatures = null,
        /** @var string[]|null */
        public ?array $experimentalFeatures = null,
        public ?string $name = null,
        /** @var string[]|null */
        public ?array $previewFeatures = null,
    ) {
    }
}
