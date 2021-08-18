<?php

declare(strict_types=1);

namespace TJVB\GitHash\Values;

final class GitHash
{
    private string $hash;

    public function __construct(string $hash)
    {
        $this->hash = trim($hash);
    }

    public function hash(): string
    {
        return $this->hash;
    }

    public function short(int $size = 8): string
    {
        return substr($this->hash, 0, $size);
    }
}
