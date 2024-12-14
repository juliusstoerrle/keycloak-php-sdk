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

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts;

interface TokenStorage
{
    public function storeAccessToken(string $accessToken): void;

    public function storeRefreshToken(string|null $refreshToken): void;

    public function retrieveAccessToken(): ?string;

    public function retrieveRefreshToken(): ?string;

    /**
     * Check if an access token, that is valid from a
     * client perspective, is present in the storage.
     *
     * Is valid from a client perspective means (at least)
     * not yet expired.
     *
     * {@internal This method was added here so all token
     * parsing/serializing etc. can be encapsulated in the
     * storage layer and no external dependencies are
     * pulled into the core library.}
     */
    public function hasValidAccessToken(): bool;

    /**
     * Check if an access token, that is valid from a
     * client perspective, is present in the storage.
     *
     * Is valid from a client perspective means (at least)
     * not yet expired.
     *
     * {@internal This method was added here so all token
     * parsing/serializing etc. can be encapsulated in the
     * storage layer and no external dependencies are
     * pulled into the core library.}
     */
    public function hasValidRefreshToken(): bool;
}
