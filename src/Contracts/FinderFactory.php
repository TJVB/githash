<?php

declare(strict_types=1);

namespace TJVB\GitHash\Contracts;

interface FinderFactory
{
    public function register(GitHashFinder $finder): void;
    public function registerDefaultFinders(): void;
    public function getRegisteredFinders(): array;
}
