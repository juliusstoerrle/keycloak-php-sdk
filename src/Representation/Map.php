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

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

readonly class Map implements Countable, IteratorAggregate
{
    public function __construct(
        private array $map = []
    ) {
    }

    public function jsonSerialize(): object
    {
        return (object) $this->map;
    }

    #[\Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->map);
    }

    #[\Override]
    public function count(): int
    {
        return count($this->map);
    }
}
