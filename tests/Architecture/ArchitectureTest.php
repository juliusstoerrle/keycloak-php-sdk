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

use JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakSdkException;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\Operation;
use JuliusStoerrle\KeycloakPhpSdk\KeycloakApiClient;
use JuliusStoerrle\KeycloakPhpSdk\Representation\Collection\Collection;

arch('All contracts are interfaces')->expect('JuliusStoerrle\KeycloakPhpSdk\Contracts')->toBeInterfaces();

arch('All representational object are readonly')->expect('JuliusStoerrle\KeycloakPhpSdk\Representation')->toBeReadonly();

arch('All operations are readonly')->expect('JuliusStoerrle\KeycloakPhpSdk\Operations')->toBeReadonly();

arch('All operations are of type Operation')
    ->expect('JuliusStoerrle\KeycloakPhpSdk\Operations')
    ->toImplement(Operation::class);

arch('All representational collections are instances of collection')
    ->expect('JuliusStoerrle\KeycloakPhpSdk\Representation\Collection')
    ->toExtend(Collection::class);

arch('All exceptions can be attributed to the library')
    ->expect('JuliusStoerrle\KeycloakPhpSdk\Exception')
    ->toImplement(KeycloakSdkException::class)
    ->toExtend(\Exception::class);

arch('KeycloakApiClient fully relies on abstractions')
    ->expect(KeycloakApiClient::class)
    ->toOnlyUse([
        'JuliusStoerrle\KeycloakPhpSdk\Contracts',
        'JuliusStoerrle\KeycloakPhpSdk\Exception',
        'Psr\Log\LoggerInterface',
        \JuliusStoerrle\KeycloakPhpSdk\KeycloakService::class,
        \JuliusStoerrle\KeycloakPhpSdk\Http\MediaType::class,
        \JuliusStoerrle\KeycloakPhpSdk\Operations\TokenRequest::class,
    ]);
