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

namespace JuliusStoerrle\KeycloakPhpSdk\Contracts\Operation;

/**
 * @template R
 * @extends Operation<R>
 */
interface OperationWithPayload extends Operation
{
    /**
     * @return array serializable payload of the operation (e.g. HTTP Request Body)
     */
    public function payload(): array;
}
