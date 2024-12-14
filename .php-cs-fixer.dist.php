<?php

/*
 * This file is part of keycloak PHP SDK.
 *
 * (c) Julius Stoerrle <juliusstoerrle@gmx.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/*
 * This file is part of keycloak PHP SDK.
 *
 * (c) Julius Stoerrle <juliusstoerrle@gmx.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return (new PhpCsFixer\Config())
    // ->setParallelConfig(new PhpCsFixer\Runner\Parallel\ParallelConfig(4, 20))
    ->setRules([
        '@PSR2' => true,
        'header_comment' => ['header' => <<<'EOF'
            This file is part of keycloak PHP SDK.

            (c) Julius Stoerrle <juliusstoerrle@gmx.de>

            This source file is subject to the MIT license that is bundled
            with this source code in the file LICENSE.
            EOF],
    ])
    ->setFinder(
        (new PhpCsFixer\Finder())
            ->ignoreDotFiles(false)
            ->ignoreVCSIgnored(true)
            ->exclude(['dist', 'tests/Fixtures/KeycloakRealm'])
            ->in(__DIR__)
    )
;
