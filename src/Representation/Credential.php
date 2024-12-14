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

readonly class Credential
{
    public function __construct(
        public ?int $createdDate = null,
        #[\SensitiveParameter]
        public ?string $credentialData = null,
        public ?string $id = null,
        public ?int $priority = null,
        #[\SensitiveParameter]
        public ?string $secretData = null,
        public ?bool $temporary = null,
        public ?string $type = null,
        public ?string $userLabel = null,
        #[\SensitiveParameter]
        public ?string $value = null,
        #[\SensitiveParameter]
        public ?string $device = null,
        #[\SensitiveParameter]
        public ?string $salt = null,
        public ?int $hashIterations = null,
        public ?string $algorithm = null,
        public ?int $counter = null,
        public ?int $digits = null,
        public ?int $period = null,
    ) {
    }
}
