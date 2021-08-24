<?php

declare(strict_types=1);

namespace TJVB\GitHash\Contracts;

use TJVB\GitHash\Values\GitHash;

interface GitHashRetriever
{
    public function setFinderFactory(FinderFactory $finderFactory): void;

    public function getHash(string $path): GitHash;

    public function getHashAndIgnoreFailures(string $path): GitHash;
}
