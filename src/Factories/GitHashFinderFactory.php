<?php

declare(strict_types=1);

namespace TJVB\GitHash\Factories;

use TJVB\GitHash\Contracts\FinderFactory;
use TJVB\GitHash\Contracts\GitHashFinder;
use TJVB\GitHash\HashFinders\GitFileSystemHashFinder;
use TJVB\GitHash\HashFinders\GitProcessCommandHashFinder;
use TJVB\GitHash\HashFinders\GitShellExecCommandHashFinder;

final class GitHashFinderFactory implements FinderFactory
{
    private array $finders = [];

    public function register(GitHashFinder $finder): void
    {
        $this->finders[] = $finder;
    }

    public function registerDefaultFinders(): void
    {
        $this->register(new GitProcessCommandHashFinder());
        $this->register(new GitShellExecCommandHashFinder());
        $this->register(new GitFileSystemHashFinder());
    }

    public function getRegisteredFinders(): array
    {
        return $this->finders;
    }

    public static function withDefaultFinders(): GitHashFinderFactory
    {
        $factory = new self();
        $factory->registerDefaultFinders();
        return $factory;
    }
}
