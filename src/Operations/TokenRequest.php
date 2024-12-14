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

namespace JuliusStoerrle\KeycloakPhpSdk\Operations;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\OperationWithPayload;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\UnauthenticatedOperation;
use JuliusStoerrle\KeycloakPhpSdk\Representation\TokenEndpointResponse;

/**
 * @internal
 * @implements OperationWithPayload<TokenEndpointResponse>
 */
readonly class TokenRequest implements OperationWithPayload, UnauthenticatedOperation
{
    public const string TOKEN_ENDPOINT = '/realms/{defaultRealm}/protocol/openid-connect/token';

    public function __construct(
        #[\SensitiveParameter]
        private array $parameters
    ) {
    }

    #[\Override] public function method(): string
    {
        return 'POST';
    }

    #[\Override] public function uri(): string
    {
        return self::TOKEN_ENDPOINT;
    }

    #[\Override] public function payload(): array
    {
        ;
        return [...$this->parameters];
    }

    #[\Override] public function resultRepresentation(): string
    {
        return TokenEndpointResponse::class;
    }
}
