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

use JuliusStoerrle\KeycloakPhpSdk\Operations\ServerInfoQuery;
use JuliusStoerrle\KeycloakPhpSdk\Representation\ServerInfo;

test('can request server info', function () {
    $res = integrationKeycloakApiClient()
        ->execute(new ServerInfoQuery());
    expect($res)->toBeInstanceOf(ServerInfo::class);
});
