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

namespace JuliusStoerrle\KeycloakPhpSdk\Auth;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Credentials;

readonly class ClientSecretCredentials implements Credentials
{
    public function __construct(
        public string $clientId,
        #[\SensitiveParameter]
        public string $clientSecret
    ) {
    }

    #[\Override]
    public function tokenRequestParameter(): array
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials'
        ];
    }

    #[\Override]
    public function refreshTokenRequestParameters(
        #[\SensitiveParameter] string $refreshToken
    ): array {
        return [
            'client_id' => $this->clientId,
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token'
        ];
    }
}
