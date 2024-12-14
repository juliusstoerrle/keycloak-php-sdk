<?php

/*
 * This file is part of keycloak PHP SDK.
 *
 * (c) Julius Stoerrle <juliusstoerrle@gmx.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth;

use JuliusStoerrle\KeycloakPhpSdk\Exception\AuthorizationException;

/**
 * The Authenticator coordinates the (re-)authentication
 * process.
 *
 * It requests access tokens from the provided credentials,
 * may refresh with refresh tokens and optimize
 * authentication for concurrent requests.
 *
 * For most use-cases the default implementation should be
 * sufficient (@see \JuliusStoerrle\KeycloakPhpSdk\Auth\Authenticator)
 */
interface Authenticator
{
    /**
     * A fast, client side check if the current
     * authentication is likely valid or if the
     * authorize-method needs to be invoked.
     */
    public function isAuthorized(): bool;

    /**
     * (Re-)authorize this client against the API
     *
     * @throws AuthorizationException
     */
    public function authorize(): void;
}
