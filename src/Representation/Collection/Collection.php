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

namespace JuliusStoerrle\KeycloakPhpSdk\Representation\Collection;

use Traversable;

/**
 * Readonly collection of representation objects
 *
 * @template T of object
 */
abstract readonly class Collection implements \Countable
{
    /**
     * @param \IteratorAggregate<T> $objects
     */
    public function __construct(protected \IteratorAggregate $objects)
    {
    }

    /**
     * @return class-string<T>
     */
    abstract public static function containsObjectsOfType(): string;

    /**
     * @return T[]
     */
    public function all(): array
    {
        return $this->objects instanceof Traversable
            ? iterator_to_array($this->objects, true)
            : (array) $this->objects;
    }

    #[\Override]
    public function count(): int
    {
        return count($this->all());
    }
}
