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

readonly class CryptoInfo
{
    public function __construct(
        /** @var string[]|null */
        protected ?array $clientSignatureAsymmetricAlgorithms = null,
        /** @var string[]|null */
        protected ?array $clientSignatureSymmetricAlgorithms = null,
        protected ?string $cryptoProvider = null,
        /** @var string[]|null */
        protected ?array $supportedKeystoreTypes = null,
    ) {
    }
}
