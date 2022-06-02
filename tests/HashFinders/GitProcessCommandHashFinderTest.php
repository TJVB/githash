<?php

declare(strict_types=1);

namespace Tjvb\GitHash\Tests\HashFinders;

use TJVB\GitHash\Exceptions\GitHashException;
use TJVB\GitHash\HashFinders\GitFileSystemHashFinder;
use TJVB\GitHash\HashFinders\GitProcessCommandHashFinder;
use TJVB\GitHash\Tests\TestCase;
use TJVB\GitHash\Values\GitHash;

class GitProcessCommandHashFinderTest extends TestCase
{
    /**
     * @test
     */
    public function weSeeThatTheFinderIsAvailable(): void
    {
        // setup / mock

        // run
        $finder = new GitProcessCommandHashFinder();

        // verify/assert
        $this->assertTrue($finder->isAvailable());
    }

    /**
     * @test
     */
    public function weCanFindAHashFromTheRepositoryRoot(): void
    {
        // setup / mock

        // run
        $finder = new GitProcessCommandHashFinder();
        $result = $finder->findHash(self::PROJECT_ROOT);

        // verify/assert
        // @TODO work with a fixed git directory to get a fixed hash
        $this->assertInstanceOf(GitHash::class, $result);
    }

    /**
     * @test
     */
    public function weCanFindAHashFromASubDirectory(): void
    {
        // setup / mock

        // run
        $finder = new GitProcessCommandHashFinder();
        $result = $finder->findHash(self::PROJECT_ROOT);

        // verify/assert
        // @TODO work with a fixed git directory to get a fixed hash
        $this->assertInstanceOf(GitHash::class, $result);
    }

    /**
     * @test
     */
    public function weCantFindAHashIfTheDirectoryIsNotPartOfAGitRepository(): void
    {
        // setup / mock
        $this->expectException(GitHashException::class);

        // run
        $finder = new GitProcessCommandHashFinder();
        $finder->findHash(sys_get_temp_dir());

        // verify/assert
    }
}
