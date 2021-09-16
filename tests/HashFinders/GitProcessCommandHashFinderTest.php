<?php

declare(strict_types=1);

namespace Tjvb\GitHash\Tests\HashFinders;

use TJVB\GitHash\HashFinders\GitProcessCommandHashFinder;
use TJVB\GitHash\Tests\TestCase;

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
}
