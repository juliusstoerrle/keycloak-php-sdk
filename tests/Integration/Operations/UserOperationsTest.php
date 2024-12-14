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

test('can query for all users', function () {
    $res = integrationKeycloakApiClient()->execute(new AllUsersQuery());
    expect($res)->toBeInstanceOf(UserCollection::class)
        ->and($res->all())
            ->toBeArray()
            ->toHaveLength(1)
            ->toContainOnlyInstancesOf(User::class);
});

test('can query for a user with id', function () {
    $res = integrationKeycloakApiClient()->execute(new UserWithIdQuery(
        id: 'c6d566e1-6234-407a-9c43-31b2a670a302'
    ));
    expect($res)->toBeInstanceOf(User::class);
});
