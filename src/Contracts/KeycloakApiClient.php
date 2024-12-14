<?php

/*
 * This file is part of keycloak PHP SDK.
 *
 * (c) Julius Stoerrle <juliusstoerrle@gmx.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Authenticator;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\Operation;

interface KeycloakApiClient
{
    /**
     * @template R
     * @param Operation<R> $operation
     * @return R
     */
    public function execute(Operation $operation): mixed;

    public function useAuthenticator(Authenticator $authenticator): void;
}
