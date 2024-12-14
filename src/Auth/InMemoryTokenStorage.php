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

namespace JuliusStoerrle\KeycloakPhpSdk\Auth;

use JuliusStoerrle\KeycloakPhpSdk\Contracts\TokenStorage;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

/**
 * Stores token in-memory
 *
 * Not recommended for production use as the tokens are
 * only available to the current process and each php
 * process must request their own tokens.
 */
class InMemoryTokenStorage implements TokenStorage
{
    private string|null $accessToken = null;

    private string|null $refreshToken = null;

    public static function singelton(): InMemoryTokenStorage {
        static $instance;
        if (!$instance instanceof InMemoryTokenStorage) {
            $instance = new InMemoryTokenStorage();
        }
        return $instance;
    }

    #[\Override] public function storeAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    #[\Override] public function storeRefreshToken(?string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    #[\Override] public function retrieveAccessToken(): ?string
    {
        return $this->accessToken;
    }

    #[\Override] public function retrieveRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    #[\Override] public function hasValidAccessToken(): bool
    {
        var_dump($this->accessToken);
        return $this->accessToken && $this->tokenNotExpired($this->accessToken);
    }

    #[\Override] public function hasValidRefreshToken(): bool
    {
        return $this->refreshToken && $this->tokenNotExpired($this->refreshToken);
    }

    private function tokenNotExpired(?string $token): bool
    {
        $parser = (new Parser(new JoseEncoder()));
        return $parser->parse($token)->isExpired(new \DateTimeImmutable());
    }
}
