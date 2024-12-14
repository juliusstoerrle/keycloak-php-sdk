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

namespace JuliusStoerrle\KeycloakPhpSdk;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Authenticator;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\HttpClient;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\ObjectMapper;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\Operation;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\OperationWithPayload;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\UnauthenticatedOperation;
use JuliusStoerrle\KeycloakPhpSdk\Exception\KeycloakOperationFailed;
use JuliusStoerrle\KeycloakPhpSdk\Http\MediaType;
use JuliusStoerrle\KeycloakPhpSdk\Operations\TokenRequest;
use Psr\Log\LoggerInterface;

final class KeycloakApiClient implements \JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakApiClient
{
    private Authenticator|null $authenticator;

    public function __construct(
        private readonly KeycloakService $keycloakService,
        private readonly HttpClient $httpClient,
        private readonly ObjectMapper $objectMapper,
        private readonly ?LoggerInterface $logger = null
    ) {
    }

    /**
     * @template R
     * @param Operation<R> $operation
     * @return R
     */
    public function execute(Operation $operation): mixed
    {
        try {
            $this->logOperation($operation);

            if ($operation instanceof TokenRequest) {
                return $this->executeTokenRequest($operation);
            }

            if (
                !$operation instanceof UnauthenticatedOperation
                && !$this->authenticator->isAuthorized()
            ) {
                $this->logger?->debug('Missing authorization');
                $this->authenticator->authorize();
            }

            return $this->executeOperation($operation);
        } catch (\Exception $e) {
            throw KeycloakOperationFailed::becauseOf($e, $operation);
        }
    }

    private function asFullUrl(string $uri): string
    {
        return $this->keycloakService->baseUrl . str_replace('{defaultRealm}', $this->keycloakService->realm, $uri);
    }

    public function useAuthenticator(Contracts\Auth\Authenticator $authenticator): void
    {
        $this->authenticator = $authenticator;
    }

    private function executeOperation(Operation $operation): mixed
    {
        $response = $this->httpClient->execute(
            $operation->method(),
            $this->asFullUrl($operation->uri()),
            body: $operation instanceof OperationWithPayload ? $operation->payload() : null
        );
        return $this->processResponse($operation, $response);
    }

    private function executeTokenRequest(Operation $operation): mixed
    {
        $response = $this->httpClient->execute(
            $operation->method(),
            $this->asFullUrl($operation->uri()),
            body: $operation->payload(),
            withCredentials: false,
            contentType: MediaType::FORM_URLENCODED
        );
        return $this->processResponse($operation, $response);
    }

    private function logOperation(Operation $operation): void
    {
        $this->logger && $this->logger->debug(
            sprintf('Executing "%s" against "%s"', get_class($operation), $this->keycloakService->baseUrl),
            [
                'operation' => $operation::class,
                'keycloakService' => $this->keycloakService->baseUrl,
                'defaultRealm' => $this->keycloakService->realm
            ]
        );
    }

    private function processResponse(Operation $operation, mixed $response): mixed
    {
        return $this->objectMapper->hydrate($operation->resultRepresentation(), $response);
    }
}
