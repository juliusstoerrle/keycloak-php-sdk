<?php

/*
 * This file is part of keycloak PHP SDK.
 *
 * (c) Julius Stoerrle <juliusstoerrle@gmx.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace JuliusStoerrle\KeycloakPhpSdk;

use Composer\InstalledVersions;
use JuliusStoerrle\KeycloakPhpSdk\Adapter\Mapping\LeagueObjectMapper;
use JuliusStoerrle\KeycloakPhpSdk\Auth\DefaultAuthenticator;
use JuliusStoerrle\KeycloakPhpSdk\Auth\InMemoryTokenStorage;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Authenticator;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Credentials;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\HttpClient;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakApiClient as KeycloakApiClientInterface;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\ObjectMapper;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\TokenStorage;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

/**
 * Easily create a new keycloak service instance with minimal configuration effort
 *
 * @api
 */
final class KeycloakApiClientFactory
{
    private TokenStorage|null $tokenStorage = null;
    private HttpClient|null $httpClient = null;
    private ObjectMapper|null $objectMapper = null;
    private LoggerInterface|null $logger = null;

    private function __construct(
        private readonly KeycloakService $keycloakService,
        private readonly Credentials $credentials
    ) {
    }

    public static function for(KeycloakService $keycloakService, Credentials $credentials): KeycloakApiClientFactory
    {
        return new KeycloakApiClientFactory($keycloakService, $credentials);
    }

    public function create(): KeycloakApiClientInterface
    {
        $keycloakApiClient = new KeycloakApiClient(
            $this->keycloakService,
            $this->httpClient(),
            $this->objectMapper(),
            $this->logger()
        );
        $keycloakApiClient->useAuthenticator($this->authenticator($keycloakApiClient));
        return $keycloakApiClient;
    }

    private function tokenStorage(): TokenStorage
    {
        if (!$this->tokenStorage instanceof TokenStorage) {
            $this->tokenStorage = new InMemoryTokenStorage();
        }
        return $this->tokenStorage;
    }

    private function httpClient(): HttpClient
    {
        if (!$this->httpClient instanceof HttpClient) {
            throw new \LogicException('You must pass a HTTP Client implementation');
        }
        return $this->httpClient;
    }

    private function objectMapper(): ObjectMapper
    {
        if (!$this->objectMapper instanceof ObjectMapper) {
            if (
                class_exists(InstalledVersions::class)
                && InstalledVersions::isInstalled('league/object-mapper')
            ) {
                return $this->objectMapper = LeagueObjectMapper::usingReflection();
            }

            throw new \LogicException('No object mapper implementation provided');
        }
        return $this->objectMapper;
    }

    private function logger(): LoggerInterface
    {
        if (!$this->logger instanceof LoggerInterface) {
            $this->logger = new Logger('KeycloakPhpSdk');
            $this->logger->pushHandler(new StreamHandler('./debug.log', Level::Debug));
        }
        return $this->logger;
    }

    private function authenticator(KeycloakApiClient $client): Authenticator
    {
        return new DefaultAuthenticator($client, $this->credentials, $this->tokenStorage(), $this->logger());
    }

    public function withTokenStorage(TokenStorage $tokenStorage): self
    {
        $this->tokenStorage = $tokenStorage;
        return $this;
    }

    public function withHttpClient(Contracts\HttpClient $httpClient): self
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    public function withObjectMapper(Contracts\ObjectMapper $objectMapper): self
    {
        $this->objectMapper = $objectMapper;
        return $this;
    }
}
