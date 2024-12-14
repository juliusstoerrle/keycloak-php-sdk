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

readonly class MemoryInfo
{
    public function __construct(
        public ?int $free = null,
        public ?string $freeFormated = null,
        public ?int $freePercentage = null,
        public ?int $total = null,
        public ?string $totalFormated = null,
        public ?int $used = null,
        public ?string $usedFormated = null,
    ) {
    }
}
