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

namespace JuliusStoerrle\KeycloakPhpSdk\Exception;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\KeycloakSdkException;
use JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation\Operation;

/**
 * The executed operation could not be completed.
 */
final class KeycloakOperationFailed extends \RuntimeException implements KeycloakSdkException
{
    public static function becauseOf(\Exception $exception, Operation $operation): KeycloakOperationFailed
    {
        return new self(
            sprintf('Operation "%s" failed with "%s"', $operation::class, $exception->getMessage()),
            $exception->getCode(),
            $exception
        );
    }
}
