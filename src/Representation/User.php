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

readonly class User
{
    /**
     * @todo check type of $disableableCredentialTypes
     * @param UserConsent[]|null $clientConsents
     * @param Credential[]|null $credentials
     * @param FederatedIdentity[]|null $federatedIdentities
     */
    public function __construct(
        public ?Map $access = null,
        public ?Map $attributes = null,
        public ?array $clientConsents = null,
        public ?Map $clientRoles = null,
        public ?int $createdTimestamp = null,
        public ?array $credentials = null,
        /** @var string[]|null */
        public ?array $disableableCredentialTypes = null,
        public ?string $email = null,
        public ?bool $emailVerified = null,
        public ?bool $enabled = null,
        public ?array $federatedIdentities = null,
        public ?string $federationLink = null,
        public ?string $firstName = null,
        /** @var string[]|null */
        public ?array $groups = null,
        public ?string $id = null,
        public ?string $lastName = null,
        public ?int $notBefore = null,
        public ?string $origin = null,
        /** @var string[]|null */
        public ?array $realmRoles = null,
        /** @var string[]|null */
        public ?array $requiredActions = null,
        public ?string $self = null,
        public ?string $serviceAccountClientId = null,
        public ?bool $totp = null,
        public ?string $username = null,
    ) {
    }
}
