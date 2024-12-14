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

readonly class ServerInfo
{
    public function __construct(
        public ?Map $builtinProtocolMappers = null,
        public ?Map $clientImporters = null,
        public ?Map $clientInstallations = null,
        public ?Map $componentTypes = null,
        public ?CryptoInfo $cryptoInfo = null,
        public ?Map $enums = null,
        //public ?FeatureCollection $features = null,
        public ?Map $identityProviders = null,
        public ?MemoryInfo $memoryInfo = null,
        //public ?PasswordPolicyTypeCollection $passwordPolicies = null,
        public ?ProfileInfo $profileInfo = null,
        public ?Map $protocolMapperTypes = null,
        public ?Map $providers = null,
        public ?Map $socialProviders = null,
        public ?SystemInfo $systemInfo = null,
        public ?Map $themes = null,
    ) {
    }
}
