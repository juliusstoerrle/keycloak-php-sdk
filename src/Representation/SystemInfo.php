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

namespace JuliusStoerrle\KeycloakPhpSdk\Representation;

readonly class SystemInfo
{
    public function __construct(
        public ?string $fileEncoding = null,
        public ?string $javaHome = null,
        public ?string $javaRuntime = null,
        public ?string $javaVendor = null,
        public ?string $javaVersion = null,
        public ?string $javaVm = null,
        public ?string $javaVmVersion = null,
        public ?string $osArchitecture = null,
        public ?string $osName = null,
        public ?string $osVersion = null,
        public ?string $serverTime = null,
        public ?string $uptime = null,
        public ?int $uptimeMillis = null,
        public ?string $userDir = null,
        public ?string $userLocale = null,
        public ?string $userName = null,
        public ?string $userTimezone = null,
        public ?string $version = null,
    ) {
    }
}
