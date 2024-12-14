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

use JuliusStoerrle\KeycloakPhpSdk\Http\MediaType;

/**
 * Creates & processes the actual HTTP request
 *
 * The implementation is responsible to:
 * - encode the request body
 * - decode the response body to a normalized state
 */
interface HttpClient
{
    /**
     * Execute an HTTP request based on the provided endpoint, method and data
     *
     * Optionally, some default values may be overwritten for special endpoints
     *
     * @param string $method
     * @param string $uri
     * @param array $queryParams
     * @param \JsonSerializable|int|float|string|array|null $body the payload send in the request body
     * @param bool $withCredentials if true, the current access token will be added to the request
     * @param MediaType $contentType overwrite default content type for special endpoints
     */
    public function execute(
        string $method,
        string $uri,
        array $queryParams = [],
        \JsonSerializable|int|float|string|array $body = null,
        bool $withCredentials = true,
        MediaType $contentType = MediaType::JSON
    ): mixed;
}
