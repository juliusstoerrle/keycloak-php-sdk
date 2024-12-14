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

use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Authenticator;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Credentials;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakSdkException;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\TokenStorage;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakApiClient;
use JuliusStoerrle\KeycloakPhpSdk\Operations\TokenRequest;
use JuliusStoerrle\KeycloakPhpSdk\Representation\TokenEndpointResponse;
use Psr\Log\LoggerInterface;

readonly class DefaultAuthenticator implements Authenticator
{
    public function __construct(
        private KeycloakApiClient $instance,
        private Credentials       $credentials,
        private TokenStorage      $tokenStorage,
        private ?LoggerInterface $logger = null
    ) {
    }

    /**
     * @inheritdoc
     */
    public function isAuthorized(): bool
    {
        return $this->tokenStorage->hasValidAccessToken();
    }

    /**
     * @inheritdoc
     * @throws KeycloakSdkException
     */
    public function authorize(): void
    {
        try {
            // make sure we don't send multiple parallel auth requests:
            // TODO acquire lock
            $this->logger?->debug('Acquired lock to retrieve a new access token for the Keycloak service.');

            if ($this->tokenStorage->hasValidRefreshToken()) {
                // -- we do have a refresh token that might work:
                $this->tryToRefreshToken();
            }

            if ($this->tokenStorage->hasValidAccessToken()) {
                // -- the refresh token worked!
                $this->logger?->info('Used the refresh token to retrieve a new access token for the Keycloak service.');
                return;
            }

            // -- we still don't have a valid token, lets use our credentials:
            $this->executeTokenRequest($this->credentials->tokenRequestParameter());
            $this->logger?->info('Retrieved a new access token for the Keycloak service.');
        } catch (KeycloakSdkException $e) {
            $this->logger?->error(
                'Failed to obtain access token: ' . $e->getMessage(),
                ['exception_class' => $e::class]
            );
            throw $e; // TODO wrap?
        } finally {
            // TODO release lock
        }
    }

    private function storeTokenResponse(TokenEndpointResponse $tokens): void
    {
        $this->tokenStorage->storeAccessToken($tokens->access_token);
        $this->tokenStorage->storeRefreshToken($tokens->refresh_token ?? null);
    }

    /**
     * @throws KeycloakSdkException
     */
    private function executeTokenRequest(array $parameters): void
    {
        $this->storeTokenResponse($this->instance->execute(new TokenRequest($parameters)));
    }

    private function tryToRefreshToken(): void
    {
        try {
            $this->executeTokenRequest(
                $this->credentials->refreshTokenRequestParameters($this->tokenStorage->retrieveRefreshToken())
            );
        } catch (KeycloakSdkException $e) {
            // Log & ignore exception (try to request a fresh access token)
            $this->logger?->warning(
                'Failed to refresh access token: ' . $e->getMessage(),
                ['exception_class' => $e::class]
            );
        }
    }
}
