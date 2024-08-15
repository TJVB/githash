<?php

declare(strict_types=1);

namespace Tjvb\GitHash\Tests\HashFinders;

use TJVB\GitHash\HashFinders\GitShellExecCommandHashFinder;
use TJVB\GitHash\Tests\TestCase;
use TJVB\GitHash\Values\GitHash;

final class GitShellExecCommandHashFinderTest extends TestCase
{
    /**
     * @test
     */
    public function weSeeThatTheFinderIsAvailable(): void
    {
        // run
        $finder = new GitShellExecCommandHashFinder();

        // verify/assert
        $this->assertTrue($finder->isAvailable());
    }

    /**
     * @test
     */
    public function weCanFindAHashFromTheRepositoryRoot(): void
    {
        // run
        $finder = new GitShellExecCommandHashFinder();
        $result = $finder->findHash(self::PROJECT_ROOT);

        // verify/assert
        // @TODO work with a fixed git directory to get a fixed hash
        $this->assertInstanceOf(GitHash::class, $result);
    }

    /**
     * @test
     */
    public function weCanHandleASeparatorAtTheEndOfThePath(): void
    {
        // run
        $finder = new GitShellExecCommandHashFinder();
        $result = $finder->findHash(self::PROJECT_ROOT . DIRECTORY_SEPARATOR);

        // verify/assert
        // @TODO work with a fixed git directory to get a fixed hash
        $this->assertInstanceOf(GitHash::class, $result);
    }

    /**
     * @test
     */
    public function weCanFindAHashFromASubDirectory(): void
    {
        // run
        $finder = new GitShellExecCommandHashFinder();
        $result = $finder->findHash(self::PROJECT_ROOT);

        // verify/assert
        // @TODO work with a fixed git directory to get a fixed hash
        $this->assertInstanceOf(GitHash::class, $result);
    }
}
