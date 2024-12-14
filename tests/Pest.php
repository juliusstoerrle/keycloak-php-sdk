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

use JuliusStoerrle\KeycloakPhpSdk\Auth\ClientSecretCredentials;
use JuliusStoerrle\KeycloakPhpSdk\Auth\InMemoryTokenStorage;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Auth\Credentials;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\TokenStorage;
use JuliusStoerrle\KeycloakPhpSdk\Http\PsrHttpClient;
use JuliusStoerrle\KeycloakPhpSdk\KeycloakApiClient;
use JuliusStoerrle\KeycloakPhpSdk\KeycloakApiClientFactory;
use JuliusStoerrle\KeycloakPhpSdk\KeycloakService;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

uses()
    ->group('architecture')
    ->in('Architecture');

uses()
    ->group('integration')
    ->in('Integration');

uses()
    ->group('unit')
    ->in('Unit');

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/
// uses(Tests\TestCase::class)->in('Feature');
/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/
// expect()->extend('toBeOne', fn() => $this->toBe(1));
/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function keycloakCredentials(): Credentials
{
    return new ClientSecretCredentials(
        getenv('KEYCLOAK_CLIENT_ID'),
        getenv('KEYCLOAK_CLIENT_SECRET')
    );
}

function keycloakTestService(): KeycloakService
{
    return new KeycloakService(
        getenv('KEYCLOAK_URL'),
        getenv('KEYCLOAK_REALM')
    );
}

function integrationHttpClientUsing(TokenStorage $tokenStorage): \JuliusStoerrle\KeycloakPhpSdk\Contracts\HttpClient
{
    $psr17Factory = new Psr17Factory();
    return new PsrHttpClient(
        new Psr18Client(
            HttpClient::create(),
            $psr17Factory,
            $psr17Factory
        ),
        $psr17Factory,
        $psr17Factory,
        $tokenStorage
    );
}

function integrationKeycloakApiClient(): KeycloakApiClient
{
    $tokenStorage = InMemoryTokenStorage::singelton();
    $httpClient = integrationHttpClientUsing($tokenStorage);

    return KeycloakApiClientFactory::for(
        keycloakTestService(),
        keycloakCredentials()
    )
        ->withTokenStorage($tokenStorage)
        ->withHttpClient($httpClient)
        // Optional: ->withObjectMapper(LeagueObjectMapper::usingReflection())
        ->create();
}
