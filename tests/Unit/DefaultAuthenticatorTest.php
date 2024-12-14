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

use JuliusStoerrle\KeycloakPhpSdk\Operations\AllUsersQuery;
use JuliusStoerrle\KeycloakPhpSdk\Operations\UserWithIdQuery;
use JuliusStoerrle\KeycloakPhpSdk\Representation\Collection\UserCollection;
use JuliusStoerrle\KeycloakPhpSdk\Representation\User;

describe(\JuliusStoerrle\KeycloakPhpSdk\Auth\DefaultAuthenticator::class, function () {

    test('does not try refresh_token grant when token not available', function () {
        $tokenStorage = Mockery::mock(\JuliusStoerrle\KeycloakPhpSdk\Contracts\TokenStorage::class);
        $tokenStorage->expects('hasValidRefreshToken')->andReturn(false);
        $tokenStorage->expects('hasValidAccessToken')->andReturn(false);
        $tokenStorage->expects('storeAccessToken')->once()->with('at');
        $tokenStorage->expects('storeRefreshToken')->once()->with('rt');

        $instance = Mockery::mock(\JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakApiClient::class);
        $instance->shouldReceive('execute')->once()->withArgs(function ($arg) {
            return ($arg instanceof \JuliusStoerrle\KeycloakPhpSdk\Operations\TokenRequest) && $arg->payload()['grant_type'] === 'client_credentials';
        })->andReturn(new \JuliusStoerrle\KeycloakPhpSdk\Representation\TokenEndpointResponse('at', 'rt'));

        $credentials = new \JuliusStoerrle\KeycloakPhpSdk\Auth\ClientSecretCredentials('test', 'test');

        $sut = new \JuliusStoerrle\KeycloakPhpSdk\Auth\DefaultAuthenticator($instance, $credentials, $tokenStorage);

        $sut->authorize();
    });

    test('uses refresh token_grant when possible', function () {
        $tokenStorage = Mockery::mock(\JuliusStoerrle\KeycloakPhpSdk\Contracts\TokenStorage::class);
        $tokenStorage->expects('hasValidRefreshToken')->andReturn(true);
        $tokenStorage->expects('hasValidAccessToken')->andReturn(true);
        $tokenStorage->expects('retrieveRefreshToken')->andReturn('rtold');
        $tokenStorage->expects('storeAccessToken')->once()->with('at');
        $tokenStorage->expects('storeRefreshToken')->once()->with(null);

        $instance = Mockery::mock(\JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakApiClient::class);
        $instance->shouldReceive('execute')->once()->withArgs(function ($arg) {
            return ($arg instanceof \JuliusStoerrle\KeycloakPhpSdk\Operations\TokenRequest) && $arg->payload()['grant_type'] === 'refresh_token';
        })->andReturn(new \JuliusStoerrle\KeycloakPhpSdk\Representation\TokenEndpointResponse('at', null));

        $credentials = new \JuliusStoerrle\KeycloakPhpSdk\Auth\ClientSecretCredentials('test', 'test');

        $sut = new \JuliusStoerrle\KeycloakPhpSdk\Auth\DefaultAuthenticator($instance, $credentials, $tokenStorage);

        $sut->authorize();
    });

});