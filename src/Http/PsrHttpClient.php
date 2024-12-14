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

namespace JuliusStoerrle\KeycloakPhpSdk\Http;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\HttpClient;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\TokenStorage;
use JuliusStoerrle\KeycloakPhpSdk\Exception\FailedToParseResponse;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Encapsulate the complexity of the PSR HTTP abstraction behind a simpler API.
 */
class PsrHttpClient implements HttpClient
{
    const string DEFAULT_USER_AGENT = 'juliusstoerrle/keycloak-php-sdk';

    const string USER_AGENT_HEADER = 'User-Agent';
    const string ACCEPT_HEADER = 'Accept';
    const string CONTENT_TYPE_HEADER = 'Content-Type';
    const string AUTHORIZATION_HEADER = 'Authorization';
    const string AUTHORIZATION_HEADER_PREFIX = 'Bearer ';

    public function __construct(
        private readonly ClientInterface         $httpClient,
        private readonly RequestFactoryInterface $requestFactoryInterface,
        private readonly StreamFactoryInterface  $streamFactory,
        private readonly TokenStorage            $tokenStorage,
        private readonly string $userAgent = self::DEFAULT_USER_AGENT
    ) {
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $queryParams
     * @param \JsonSerializable|int|float|string|array|bool|null $body the payload send in the request body
     * @param bool $withCredentials if true, the current access token will be added to the request
     * @param MediaType $contentType overwrite default content type for special endpoints
     */
    public function execute(
        string $method,
        string $uri,
        array $queryParams = [],
        \JsonSerializable|int|float|string|array|bool $body = null,
        bool $withCredentials = true,
        MediaType $contentType = MediaType::JSON
    ): int|float|string|array|bool {
        $request = $this->initiateRequestObject($method, $uri);

        if (true === $withCredentials) {
            $request = $this->withCredentials($request);
        }

        if ($body != null) {
            $request = $this->withBody($request, $contentType, $body);
        }

        return $this->process($request);
    }

    private function withCredentials(RequestInterface $request): RequestInterface
    {
        return $request->withHeader(
            self::AUTHORIZATION_HEADER,
            self::AUTHORIZATION_HEADER_PREFIX . $this->tokenStorage->retrieveAccessToken()
        );
    }

    /**
     * creates an intermediary normalised representation of the response
     *
     * This is usually array-based and can be converted to
     * an object by the {@see \JuliusStoerrle\KeycloakPhpSdk\Contracts\ObjectMapper}
     */
    private function parseResponseBody(ResponseInterface $response): mixed
    {
        try {
            return json_decode(
                $response->getBody()->getContents(),
                true,
                flags: JSON_THROW_ON_ERROR,
            );
        } catch (\JsonException $jsonException) {
            throw new FailedToParseResponse($jsonException->getMessage(), 0, $jsonException);
        }
    }

    private function process(RequestInterface $request): mixed
    {
        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            // TODO rethrow
            throw new \RuntimeException('http client error', $e->getCode(), $e);
        }

        return match ($response->getStatusCode()) {
            200, 201 => $this->parseResponseBody($response),
            204 => null,
            404 => throw new \RuntimeException('resource or endpoint not found'),
            401, 403 => throw new \RuntimeException('authentication issue'),
            307, 400, 405, 409, 415 => throw new \RuntimeException('request malformed'),
            500 => throw new \RuntimeException('server error'),
            default => throw new \RuntimeException(sprintf('request failed: %s %s', $response->getStatusCode(), $response->getReasonPhrase()))
        };
    }

    private function initiateRequestObject(string $method, string $uri): RequestInterface
    {
        $request = $this->requestFactoryInterface->createRequest($method, $uri);
        $request = $request->withHeader(self::USER_AGENT_HEADER, $this->userAgent);
        return $request->withHeader(self::ACCEPT_HEADER, MediaType::JSON->value);
    }

    private function withBody(RequestInterface $request, MediaType $contentType, float|int|array|string|\JsonSerializable $body): RequestInterface
    {
        $content = match ($contentType) {
            MediaType::FORM_URLENCODED => http_build_query($body),
            MediaType::JSON => json_encode($body)
        };

        $request = $request->withHeader(self::CONTENT_TYPE_HEADER, $contentType->value);
        return $request->withBody($this->streamFactory->createStream($content));
    }
}
