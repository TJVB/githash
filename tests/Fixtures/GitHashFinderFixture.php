<?php

declare(strict_types=1);

namespace TJVB\GitHash\Tests\Fixtures;

use TJVB\GitHash\Contracts\GitHashFinder;
use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\Values\GitHash;

final class GitHashFinderFixture implements GitHashFinder
{
    public ?GitHash $gitHash = null;

    public bool $available = true;

    public ?GitHashException $exception = null;

    public function findHash(string $path): GitHash
    {
        if ($this->exception !== null) {
            throw $this->exception;
        }
        if ($this->gitHash === null) {
            $this->gitHash = new GitHash('invalidhash');
        }
        return $this->gitHash;
    }

    public function isAvailable(): bool
    {
        return $this->available;
    }
}
