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

namespace JuliusStoerrle\KeycloakPhpSdk\Adapter\Mapping;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\ObjectMapper;
use JuliusStoerrle\KeycloakPhpSdk\Representation\Collection\Collection;
use League\ObjectMapper\ObjectMapperUsingReflection;

/**
 * Provides a league/object-mapper for hydrating response representations
 */
final readonly class LeagueObjectMapper implements ObjectMapper
{
    public static function usingReflection(): LeagueObjectMapper
    {
        return new self(new ObjectMapperUsingReflection());
    }

    public function __construct(
        public \League\ObjectMapper\ObjectMapper $mapper
    ) {
    }

    #[\Override] public function hydrate(string $className, array $data): object
    {
        if (is_subclass_of($className, Collection::class)) {
            return new $className($this->mapper->hydrateObjects($className::containsObjectsOfType(), $data));
        }

        return $this->mapper->hydrateObject($className, $data);
    }
}
