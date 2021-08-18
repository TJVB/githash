<?php

declare(strict_types=1);

namespace TJVB\GitHash\Contracts;

use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\Values\GitHash;

interface GitHashFinder
{
    /**
     * @param string $path
     *
     * @return GitHash
     *
     * @throws GitHashException
     */
    public function findHash(string $path): GitHash;

    public function isAvailable(): bool;
}
